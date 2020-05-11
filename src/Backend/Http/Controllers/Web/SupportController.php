<?php

namespace Zento\Backend\Http\Controllers\Web;

use Zento\Kernel\Http\Controllers\ApiBaseController;

class SupportController extends ApiBaseController
{
    public function index()
    {
        return view('admin.page.home');
    }
}
