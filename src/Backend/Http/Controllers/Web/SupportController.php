<?php

namespace Zento\Backend\Http\Controllers\Web;

use Zento\BladeTheme\Facades\BladeTheme;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\StoreFront\Consts as StoreFrontConsts;

class SupportController extends ApiBaseController
{
    public function index()
    {
        $logo = config(StoreFrontConsts::LOGO);
        return BladeTheme::addGlobalViewData(
            [
                'appData' => [
                    'theme' => compact('logo'),
                ],
            ]
        )->view('admin.page.home');
    }
}
