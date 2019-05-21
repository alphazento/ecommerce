<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\Console\Commands;

use Zento\Acl\Model\Auth\User;

class AddUser extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apc:adduser {email : email address} {--root} {--password=}';

    protected $description = 'Add a admin user';

    public function handle() {
        $email = $this->argument('email');
        $root = $this->option('root');
        $password = $this->option('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = new User;
            $user->email = $email;
            $user->first_name = explode('@', $email)[0];
            $user->last_name = '';
            if ($password) {
                $user->password = $user->encryptPassword($password);
            } else {
                $user->password = '';
            }
            $user->save();
            $this->info(sprintf('User(%s) has been created.' , $email));
        } else {
            $this->error(sprintf('User(%s) has exists.' , $email));
        }
    }
}
