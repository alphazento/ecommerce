<?php

namespace Zento\DesktopTheme\Http\Controllers;

class Web extends \App\Http\Controllers\Controller
{
    public function home() {
        return view('pages.home', ['brands' => [], 'groups' => []]);
    }
}
