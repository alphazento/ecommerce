<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\ApiDocAdv\Console;

use Event;
use Config;
use Mpociot\Documentarian\Documentarian;

class ApidocGenerateSubscriber
{
    public function subscribe()
    {
        Event::listen(
            'Illuminate\Console\Events\CommandStarting',
            function ($event) {
                if ($event->command == 'apidoc:generate') {
                    $this->replaceDocs();
                    if (Config::get('apidoc.strategies')) {
                        $responses = Config::get('apidoc.strategies.responses');
                        // array_push($responses, '\Zento\ApiDocAdv\Strategies\Responses\UseTransformerTags');
                        for($i= 0, $l = count($responses); $i<$l; $i++) {
                            if ($responses[$i] === 'Mpociot\ApiDoc\Extracting\Strategies\Responses\ResponseCalls') {
                                $responses[$i] = \Zento\ApiDocAdv\Strategies\Responses\ResponseCalls::class;
                                Config::set('apidoc.strategies.responses', $responses);
                                break;
                            }
                        } 
                    }
                }
            }
        );
    }

    protected function replaceDocs() {
        $documentarian = new \ReflectionClass(Documentarian::class);
        $parts = pathinfo($documentarian->getFileName());
        $targetPath = realpath($parts['dirname'] . '/../resources/views');
        $sourcePath = realpath(__DIR__ . '/../resources/docs');
        copy($sourcePath . '/template.blade.php', $targetPath . '/index.blade.php');
    }
}
