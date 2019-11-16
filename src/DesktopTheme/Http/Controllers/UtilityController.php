<?php

namespace Zento\DesktopTheme\Http\Controllers;

use BladeTheme;

class UtilityController extends \App\Http\Controllers\Controller
{
    public function returns() {
        return BladeTheme::breadcrumb(route('returns'), 'Returns')
            ->view('pages.returns');
    }

    public function terms_conditions() {
        return BladeTheme::breadcrumb(route('terms-conditions'), 'Terms & Conditions')
            ->view('pages.terms-conditions');
    }
}
