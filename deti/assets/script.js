(function ($) {
    function createConfetti(amount) {
        const colors = ['#ff6fa2', '#ffd93d', '#6bcBef', '#95f9a9', '#c77dff'];

        for (let i = 0; i < amount; i++) {
            const left = Math.random() * 100;
            const delay = Math.random() * 1.6;
            const size = 8 + Math.random() * 8;
            const color = colors[Math.floor(Math.random() * colors.length)];

            const $piece = $('<div class="confetti"></div>').css({
                left: `${left}vw`,
                animationDelay: `${delay}s`,
                width: `${size}px`,
                height: `${size * 1.4}px`,
                backgroundColor: color,
                transform: `rotate(${Math.random() * 180}deg)`
            });

            $('body').append($piece);
            setTimeout(() => $piece.remove(), 4500);
        }
    }

    $(function () {
        if ($('body').hasClass('success-page')) {
            createConfetti(60);
            setInterval(() => createConfetti(16), 2600);
        }

        $('#loginBtn').on('mouseenter', function () {
            $(this).text('Полетели! 🚀');
        }).on('mouseleave', function () {
            $(this).text('Войти в кабинет 🚀');
        });
    });
})(jQuery);
