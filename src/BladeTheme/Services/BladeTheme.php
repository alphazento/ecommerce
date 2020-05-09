<?php
namespace Zento\BladeTheme\Services;

use Route;
use Request;
use ShareBucket;

use Illuminate\Support\Traits\Macroable;

class BladeTheme {
    use Macroable;
    use Concerns\TraitBladeDirective;
    use Concerns\TraitBreadcrumb;
    use Concerns\TraitViewData;
    use Concerns\TraitViewStub;

    public function apiUrl($path) {
        return sprintf('/api/v1/%s', $path);
    }

    public function requestInnerApi($method, $url, $data = [], $headers = []) : \Zento\Kernel\Http\ApiResponse {
        //keep origin stack
        $originRequest = Request::instance();
        $originRoute = Route::current();

        //inner request disable middleware
        app()->instance('middleware.disable', true);

        //prepare new request instance
        $request = Request::create($url, $method, $data);
        if ($token = $this->globalViewData['apiGuestToken'] ?? false) {
            $request->headers->add(['authorization' => $token]);
        }
        if (count($headers)) {
            $request->headers->add($headers);
        }
        app()->instance('request', $request);
        
        ShareBucket::put(\Zento\Passport\Http\Middleware\GuestToken::ALLOW_GUEST_API, true);
        try {
            $resp = Route::dispatch($request)->getOriginalContent();
        } catch (\Exception $e) {
            throw new \Exception(sprintf('Request to [%s] %s', $url, $e->getMessage()));
        }

        //restore to origin stack
        app()->instance('request', $originRequest);
        Route::setCurrent($originRoute);

        if (is_string($resp) && env('APP_DEBUG')) {
            //it's a debug error render.
            echo $resp;die;
        }
        
        return $resp->getApiResponse();
    }

    public function getApiGuestToken($user) {
        return sprintf('Guest %s', encrypt(json_encode($user->toArray())));
    }
}
