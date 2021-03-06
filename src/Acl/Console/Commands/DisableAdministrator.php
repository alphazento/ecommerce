<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\Console\Commands;

use Zento\Acl\Model\Auth\User;

class DisableAdministrator extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:user:disable {email : email address}';

    protected $description = 'Enable a exists user';

    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error(sprintf('User(%s) does not exist', $email));
        } else {
            $user->active = 0;
            $user->save();
            $this->info(sprintf('User(%s) has been disabled.', $email));
        }
    }
}
