<header>
    <a id="rwd_nav" href="#nav"></a>
    <div id="logo">
        <a href="/"><img src=@asset("/baicy_desktoptheme/image/logo.png")></a>
    </div>
    <div id="m_nav">
        <nav id="nav">
            <a href="/" {{ $nav_page == 'home' ? 'class=nav_on' : '' }} >Home </a>
            <a href="/about" {{ $nav_page == 'about' ? 'class=nav_on' : '' }}>About Baicytek </a>
            <a href="/products" {{ $nav_page == 'product' ? 'class=nav_on' : '' }}>Products</a>
            <a href="/cooperation" {{ $nav_page == 'cooperation' ? 'class=nav_on' : '' }}>Cooperation </a>
            <a href="/news" {{ $nav_page == 'news' ? 'class=nav_on' : '' }}>News</a>
            <a href="/contact" {{ $nav_page == 'contact' ? 'class=nav_on' : '' }}>Contact us</a>
            <a href="/shoppingcart" {{ $nav_page == 'shoppingcart' ? 'class=nav_on' : '' }}>Shopping Cart</a>
        </nav>
        <a class="search_icon inline_auto cboxElement" href="#search"></a>
    </div>
    <div style="display: none">
        <div id="search">
            <form name="" id="" method="t" action="#" onsubmit="">
                <input name="search_word" type="text" id="search_word" class="search_in" value="">
                <input type="submit" name="button" id="button" value="Search" class="search_b">
                <input name="search_field" type="hidden" value="all_field">
            </form>
        </div>
    </div>
</header>