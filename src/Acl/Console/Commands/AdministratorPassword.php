<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\Console\Commands;

use Auth;
use Illuminate\Support\Facades\Hash;
use Zento\Acl\Model\Auth\Administrator;

class AdministratorPassword extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:password {email : email address} {password : password}';

    protected $description = 'Change a admin user password.';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (strlen($password) < 8) {
            $this->error('Password is too short. At least 8 characters.');
            return;
        }

        $user = Administrator::where('email', $email)->first();
        if (!$user) {
            $this->error(sprintf('User(%s) does not exists.', $email));
        } else {
            $user->password = Hash::make($password);
            $user->save();
            $this->info(sprintf('User(%s) password has been changed.', $email));
        }
    }
}
