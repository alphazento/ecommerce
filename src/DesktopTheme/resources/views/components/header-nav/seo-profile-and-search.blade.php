@if(Route::currentRouteName() === 'home')
    <?php
    $version = Store::getConfig(config("app.node") . Inkstation\Theme\Constants::RESOURCE_VERSION);
    $logoUrl = "https://static.tonercity.com.au/$version/tonercitytheme/assets/img/logo.png";
    ?>
    <script type="application/ld+json">
[
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "TonerCity",
        "url": "https://www.tonercity.com.au/",
        "logo": "{{ $logoUrl }}",
        "sameAs": [
            "https://www.facebook.com/tonercity.com.au/"
        ]
    },
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "https://www.tonercity.com.au",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://www.tonercity.com.au/search?keywords={search_string}",
            "query-input": "required name=search_string"
        }
    }
]
</script>
@endif
