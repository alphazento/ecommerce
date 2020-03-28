<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class GeneralController  extends \App\Http\Controllers\Controller
{
    use TraitThemeRouteOverwritable;

    public function home() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->view('page.home');
    }

    public function news() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('news.page'), 'News')
            ->view('page.general.news');
    }

    public function aboutUs() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('aboutus.page'), 'About Us')
            ->view('page.general.aboutus');
    }

    function contactUs() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('contactus.page'), 'Contact Us')
            ->view('page.general.contactus');
    }

    function privacy() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('privacy.page'), 'Privacy')
            ->view('page.general.privacy');
    }

    function terms() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('terms.page'), 'Terms & Conditions')
            ->view('page.general.terms');
    }
}
