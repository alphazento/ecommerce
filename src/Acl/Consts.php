<?php

namespace Zento\Acl;

abstract class Consts {
    const DB = 'acl_db';

    const GUEST_SCOPE = 0;
    const ADMIN_SCOPE = 1;
    const FRONTEND_SCOPE = 2;
    const BOTH_SCOPE = 3;
}
