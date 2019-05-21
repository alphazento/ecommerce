<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen tony@tonercity.com.au
 */

namespace Zento\Acl\Console\Commands;

use Zento\Acl\Model\Auth\User;

class DisableUser extends \Inkstation\Base\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apc:user:disable {email : email address}';

    protected $description = 'Enable a exists user';

    public function handle() {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error(sprintf('User(%s) does not exist' , $email));
        } else {
            $user->active = 0;
            $user->save();
            $this->info(sprintf('User(%s) has been disabled.' , $email));
        }
    }
}
