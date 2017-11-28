/**
 * 睡眠 xx 秒
 */

var interval = 3;

var countdown = setInterval(function () {
    interval--;

    if (interval === 0) {
        clearInterval(countdown);

        window.location.href = '/property';
    };
}, 1000);