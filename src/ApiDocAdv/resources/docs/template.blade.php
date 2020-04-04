<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{$page['title']}}</title>

    <link rel="stylesheet" href="css/style.css" />
    <script src="js/all.js"></script>


    @if(isset($page['language_tabs']))
      <script>
        $(function() {
            setupLanguages({!! json_encode($page['language_tabs']) !!});
        });
      </script>
    @endif
  </head>

  <body class="">

    <div class="container z-app-content-light">
      <header
        class="z-app-bar v-sheet v-sheet--tile theme--dark v-toolbar v-app-bar v-app-bar--fixed"
        style="height: 96px; margin-top: 0px; transform: translateY(0px); left: 0px; right: 0px; background-color: rgb(47, 73, 94); border-color: rgb(47, 73, 94);"
        data-booted="true"
      >
        <div class="v-toolbar__content" style="height: 96px;">
          <div class="d-flex align-center z-app-logo">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 312 335"
              width="40"
              height="40"
              class="logo-svg"
            >
              <path
                id="Shape 2"
                d="M0 335C180.51 62.98 167 -94.55 187 64C207 222.55 79.46 227.14 172 225C264.54 222.86 14.02 306.65 115 301C215.98 295.35 437.27 284.27 219 313"
                class="shp0"
              ></path></svg
            ><span>ALPHAZENTO</span>
          </div>
          <div class="spacer"></div>
          <ul class="z-app-bar-menu">
            <li><a href="/guide">Guide</a></li>
            <li><a href="/api" class="">API</a></li>
            <li><a href="/extensions-market">Extensions</a></li>
            <li><a href="/faq">FAQ</a></li>
            <li><a href="/examples">Examples</a></li>
          </ul>
          <div class="spacer"></div>
          <div
            class="v-input z-search-bar v-input--dense theme--dark v-text-field v-text-field--single-line v-text-field--filled v-text-field--is-booted v-text-field--enclosed v-text-field--placeholder v-text-field--rounded"
            style="max-width: 300px;"
          >
            <div class="v-input__control">
              <div class="v-input__slot">
                <div class="v-text-field__slot">
                  <input id="input-6" placeholder="Search..." type="text" />
                </div>
                <div class="v-input__append-inner">
                  <div class="v-input__icon v-input__icon--append">
                    <i
                      aria-hidden="true"
                      class="v-icon notranslate mdi mdi-magnify theme--dark"
                    ></i>
                  </div>
                </div>
              </div>
              <div class="v-text-field__details">
                <div class="v-messages theme--dark">
                  <div class="v-messages__wrapper"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
    </div>

    <a href="#" id="nav-button">
      <span>
        NAV
        <img src="images/navbar.png" />
      </span>
    </a>
    <div class="tocify-wrapper">
        <a href="https://www.alphazento.com" 
          style="font-size:25px;text-decoration-line: none; color: white; margin-left: 15px;">
          <img height="25px" src={{config(\Zento\StoreFront\Consts::LOGO)}} />
          <span>Alphazento</span>
        </a>
        @if(isset($page['language_tabs']))
            <div class="lang-selector">
                @foreach($page['language_tabs'] as $lang)
                  <a href="#" data-language-name="{{$lang}}">{{$lang}}</a>
                @endforeach
            </div>
        @endif
        @if(isset($page['search']))
            <div class="search">
              <input type="text" class="search" id="input-search" placeholder="Search">
            </div>
            <ul class="search-results"></ul>
        @endif
      <div id="toc">
      </div>
        @if(isset($page['toc_footers']))
            <ul class="toc-footer">
                @foreach($page['toc_footers'] as $link)
                  <li>{!! $link !!}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
          {!! $content !!}
      </div>
      <div class="dark-box">
          @if(isset($page['language_tabs']))
              <div class="lang-selector">
                @foreach($page['language_tabs'] as $lang)
                    <a href="#" data-language-name="{{$lang}}">{{$lang}}</a>
                @endforeach
              </div>
          @endif
      </div>
    </div>
  </body>
</html>