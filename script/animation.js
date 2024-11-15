$(document).ready(function() {
    function checkVisibility() {
        $('.box').each(function() {
            var boxTop = $(this).offset().top;
            var windowBottom = $(window).scrollTop() + $(window).height();

            if (boxTop < windowBottom - 100) { // Активируем за 100px до нижнего края окна
                $(this).addClass('show');
            }
        });
    }

    $(window).on('scroll', checkVisibility);
    checkVisibility(); // Проверяем видимость сразу при загрузке
});
