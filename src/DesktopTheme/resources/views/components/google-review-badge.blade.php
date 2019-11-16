@push('footer')
<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>
<script>
    window.renderBadge = function () {
        var ratingBadgeContainer = document.createElement("div");
        document.body.appendChild(ratingBadgeContainer);
        window.gapi.load('ratingbadge', function () {
            window.gapi.ratingbadge.render(
                ratingBadgeContainer, {
                    "merchant_id": 117234785,
                    "position": "BOTTOM_LEFT"
                });
        });
    };
    // BEGIN GCR Language Code
    window.___gcfg = {
        lang: 'en_AU'
    };
</script>
@endpush
