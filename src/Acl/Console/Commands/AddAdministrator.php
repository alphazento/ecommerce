<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\Console\Commands;

use Zento\Acl\Model\Auth\Administrator;

class AddAdministrator extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:addadmin {email : email address} {--root}';

    protected $description = 'Add an administrator';

    public function handle() {
        $email = $this->argument('email');
        $root = $this->option('root');
        $user = Administrator::where('email', $email)->first();
        if (!$user) {
            $user = new Administrator;
            $user->email = $email;
            $user->firstname = explode('@', $email)[0];
            $user->lastname = '';
            $password = $user->applyRandomPassword();
            $this->info(sprintf('Administrator(%s) has been created. Password is %s', $email, $password));
        } else {
            $this->error(sprintf('Administrator(%s) has exists.' , $email));
        }
    }
}
