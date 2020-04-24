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

    /**
     * Render home page
     * @group Web Pages
     */
    public function home() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->view('page.home');
    }

    /**
     * Render news page
     * @group Web Pages
     */
    public function news() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('news.page'), 'News')
            ->view('page.general.news');
    }

    /**
     * Render about us page
     * @group Web Pages
     */
    public function aboutUs() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('aboutus.page'), 'About Us')
            ->view('page.general.aboutus');
    }

    /**
     * Render contact us page
     * @group Web Pages
     */
    function contactUs() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('contactus.page'), 'Contact Us')
            ->view('page.general.contactus');
    }

    /**
     * Render privacy page
     * @group Web Pages
     */
    function privacy() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('privacy.page'), 'Privacy')
            ->view('page.general.privacy');
    }

    /**
     * Render terms page
     * @group Web Pages
     */
    function terms() {
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('terms.page'), 'Terms & Conditions')
            ->view('page.general.terms');
    }
}
