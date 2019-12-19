<?php

namespace Zento\Backend\Http\Controllers\Web;

use Route;
use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Catalog\Providers\Facades\ProductService;
use Zento\Catalog\Providers\Facades\CategoryService;

class SupportController extends ApiBaseController
{
    public function index() {
        return view('admin.page.home');
    }
}
