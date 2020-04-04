<?php

namespace Zento\ApiDocAdv\Strategies\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Mpociot\ApiDoc\Extracting\ParamHelpers;
use Mpociot\ApiDoc\Extracting\Strategies\Strategy;
use Mpociot\ApiDoc\Tools\Flags;
use Mpociot\ApiDoc\Tools\Utils;
use Mpociot\Reflection\DocBlock\Tag;
use Mpociot\ApiDoc\Extracting\RouteDocBlocker;
use Mpociot\ApiDoc\Tools\DocumentationConfig;

use Zento\Acl\DocBlock\RouteAnalyzer;
use Zento\Kernel\Http\Controllers\TraitApiResponse;
use Zento\Kernel\Http\Controllers\ApiBaseController;

/**
 * Make a call to the route and retrieve its response.
 */
class ResponseCalls extends \Mpociot\ApiDoc\Extracting\Strategies\Responses\ResponseCalls
{
    use TraitApiResponse;

    /**
     * @var RouteAnalyzer
     */
    protected $routeAnalyzer;

    protected $requestParameters = null;

    public function __construct(string $stage, DocumentationConfig $config)
    {
        parent::__construct($stage, $config);
        $this->routeAnalyzer = new RouteAnalyzer();
    }
    
    public function __invoke(Route $route, \ReflectionClass $controller, \ReflectionMethod $method, array $routeRules, array $context = [])
    {
        $this->data['data'] = [];
        $this->requestParameters = null;
        if ($ret = $this->tryTags($route)) {
            return $ret;
        }
        return parent::__invoke($route, $controller, $method, $routeRules, $context);
    }
    /**
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function callLaravelRoute(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        // Confirm we're running in Laravel, not Lumen
        if (app()->bound(\Illuminate\Contracts\Http\Kernel::class)) {
            $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
            $response = $kernel->handle($request);
            app()->instance('middleware.disable', true);
            $kernel->terminate($request, $response);
        } else {
            // Handle the request using the Lumen application.
            $kernel = app();
            $response = $kernel->handle($request);
        }

        return $response;
    }

    protected function tryTags(Route $route) {
        $docBlocks = RouteDocBlocker::getDocBlocksFromRoute($route);
        /** @var DocBlock $methodDocBlock */
        $methodDocBlock = $docBlocks['method'];
        return $this->getResponseByModels($methodDocBlock->getTags(), $route);
    }

    protected function getResponseByModels($tags, Route $route) {
        $responses = [];
        foreach($tags as $tag) {
            if ($tag instanceof Tag) {
                $this->data['data'] = [];
                $name = $tag->getName();
                switch($name) {
                    case 'responseModel':
                    case 'responseCollection':
                    case 'responseCollectionPagination':
                        if($data = $this->responseByModel($name, $tag->getContent(), $route)) {
                            $responses = array_merge($responses, $data);
                        }
                    break;
                    case 'responseBy':
                        $this->requestParameters = json_decode($tag->getContent(), true);
                    break;
                    case 'responseError':
                        $errors = explode(',', $tag->getContent());
                        $this->error(...$errors);
                        $responses[] = [
                            'content' => $this->data,
                            'status' => 200
                        ];
                    break;
                }
            }
        }

        return count($responses) > 0 ? $responses : false;
    }

    protected function responseByModel($tagName, $content, Route $route) {
        $content = trim($content);
        if (!empty($content)) {
            $parts = explode(' ', $content);
            $class = array_pop($parts);
            $code = $parts[0] ?? 200;
            if (class_exists($class)) {
                switch($tagName) {
                    case 'responseModel':
                        if ($instance = $class::first()) {
                            return $this->wrapResponse($route, $instance->toArray(), $code);
                        }
                    break;
                    case 'responseCollection':
                        if ($instance = $class::first()) {
                            return $this->wrapResponse($route, [$instance->toArray()], $code);
                        }
                    break;
                    case 'responseCollectionPagination':
                        if ($instance = $class::paginate(1)) {
                            return $this->wrapResponse($route, [$instance->toArray()], $code);
                        }
                    break;
                }
            }
        }
        return false;
    }

    protected function wrapResponse(Route $route, $data, $code = 200) {
        list($className, $methodName) = $this->routeAnalyzer->getClassAndMethodNames($route);
        if ($className && class_exists($className)) {
            if (with(new $className) instanceof ApiBaseController) {
                $this->withData($data)->success($code);
                $response = [
                    [
                        'content' => $this->data,
                        'status' => 200
                    ]
                ];
                $this->data['data'] = [];
                $this->error(403, 'ACL Denied.');
                $response[] = [
                    'content' => $this->data,
                    'status' => 200
                ];
                return $response;
            }
        }
        return [
            [
                'content' => $data,
                'status' => 200
            ]
        ];
    }

    protected function prepareRequest(Route $route, 
        array $rulesToApply, 
        array $urlParams, 
        array $bodyParams, 
        array $queryParams, 
        array $headers) 
    {
        if ($this->requestParameters && count($this->requestParameters) > 0) {
            if ($pairs = $this->requestParameters['url'] ?? false) {
                foreach($pairs as $k => $v) {
                    $urlParams[$k] = $v;
                }
            }
            if ($pairs = $this->requestParameters['body'] ?? false) {
                $bodyParams[$k] = $v;
            }
            if ($pairs = $this->requestParameters['body'] ?? false) {
                $queryParams[$k] = $v;
            }
        }
        return parent::prepareRequest($route, $rulesToApply, $urlParams, $bodyParams, $queryParams, $headers);
    }
}
