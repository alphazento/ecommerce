define(function () {
    return {
        isMobile: function () {
            return window.matchMedia("only screen and (max-width: 760px)").matches;
        }
    };
});
