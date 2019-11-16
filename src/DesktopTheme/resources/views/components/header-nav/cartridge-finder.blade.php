<div class="level-top-box">
    <a class="btn-close" href="javascript:;"></a>
    <a href="javascript:;" class="level0 has-children">
        <span>Cartridge Finder</span>
    </a>
    @if(Request::getUri() != route('home') . '/')
        <div class="box-menu header-cartrigefinder">
            <div class="col pad-mob-0 header-cartrigefinder-div">
                <section class="cartrigefinder">
                    @includecache('', 'components.main-cartridge-finder-component',['brands'=>PrinterCategory::getCommonBrands(['url_rewrite'])])
                </section>
            </div>
        </div>
    @endif
</div>
