;(function ($) {
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/TimerWidget.default", function (scope, $) {
            var clockElement = $(scope).find(".clock");
            var displayType = clockElement.data('display-type');
            var clockFormat = clockElement.data('clock-format');
            if ('clock' == displayType) {
                clockFace = '12' == clockFormat ? 'TwelveHourClock' : 'TwentyFourHourClock';
                clockElement.FlipClock({
                    clockFace: clockFace
                });
            }
        });
    })
})(jQuery);

