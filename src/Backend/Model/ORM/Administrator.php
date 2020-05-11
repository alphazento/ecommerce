<?php

namespace Zento\Backend\Model\ORM;

class Administrator extends \Zento\Passport\Model\User
{
    /**
     * if is admin user, so it can handle other user's resources
     *
     * @param boolean $isMe
     * @return void
     */
    public function crossUserAcl($isMe = false)
    {
        return true;
    }
}
