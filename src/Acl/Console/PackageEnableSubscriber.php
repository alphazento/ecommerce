<?php
/**
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\Console;

use Event;

class PackageEnableSubscriber
{
    public function subscribe()
    {
        Event::listen(
            'Illuminate\Console\Events\CommandFinished',
            function ($event) {
                if ($event->command == 'package:enable') {
                    // Artisan::call('acl:sync');
                }
            }
        );
    }
}
