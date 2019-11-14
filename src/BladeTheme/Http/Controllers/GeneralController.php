<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class GeneralController
{
    use TraitThemeRouteOverwritable;

    public function home() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->view('page.home'));
    }

    public function news() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('web.get.news'), 'News')
            ->view('page.general.news');
    }

    public function aboutUs() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('web.get.aboutus'), 'About Us')
            ->view('page.general.aboutus');
    }

    function contactUs() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('web.get.contactus'), 'Contact Us')
            ->view('page.general.contactus');
    }

    function privacy() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('web.get.pricy'), 'Privacy')
            ->view('page.general.privacy');
    }

    function terms() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('web.get.terms'), 'Terms & Conditions')
            ->view('page.general.terms');
    }
}
