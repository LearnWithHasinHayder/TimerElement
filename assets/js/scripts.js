;(function($){
    $(window).on("elementor/frontend/init",function(){
        elementorFrontend.hooks.addAction('frontend/element_ready/TimerWidget.default',function(scope,$){
            var clock = $('.clock').FlipClock({
                clockFace: 'HourlyCounter',
                autoStart:false
            });

            clock.setTime(60*3);
            clock.setCountdown(true);
            clock.start();
        });
    });
})(jQuery);