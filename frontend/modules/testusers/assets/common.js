if (timer) {
    var i = 10 * timer; // timer from view 
    var t = i;
    var btn_click = false;
    var counterBack = setInterval(function () {
        i--;
        $('#loader').hide();
        if (i >= 0) {
            $('.progress-bar').css('width', 100 * i / t + '%');
            if (100 * i / t < 10) {
                $('.progress-bar').addClass('progress-bar-danger').removeClass('progress-bar-warning');
                $('.timer').addClass('text-danger');
            } else if (100 * i / t < 30) {
                $('.progress-bar').addClass('progress-bar-warning');
            }
            m = Math.floor(i / 10 / 60) ^ 0;
            s = (i / 10 % 60) ^ 0;
            $('.timer').text((m < 10 ? "0" + m : m) + ':' + (s < 10 ? "0" + s : s));
            btn_click = false;
        } else {
            $('#loader').show();
            clearInterval(counterBack);
            $('button[type="submit"]').val('0').submit();
        }
    }, 100);
    $(document).click(function(){
    	btn_click = true;
    });
    $('button[type="submit"]').one('click', function(){
        $('#loader').show();
        $.post('total', {totaltime:(t-i)/10});
        btn_click = true;
    });
    $('body').mouseleave(function(e){
        var strGET = window.location.search; 
        console.log('click: '+btn_click);
        if (e.relatedTarget === null && btn_click === false && (t-i) > 5) {
            $('#loader').show();
            clearInterval(counterBack);
            $.post('total' + strGET, {out:true});
            console.log('the mouse left the window');
        }
    });
}

var _href = $('#test-modal').find('.modal-footer a').attr('href');
$('li a').click(function(){
    var id_test = $(this).attr('id_test');
    var name = $(this).attr('data-name');
    $('#test-modal').find('.modal-header').append('<span>Тест: ' + name + '</span>');
    $('#test-modal').find('.modal-footer a').attr('href', _href + '?id_test=' + id_test);
});
$('h4 a[data-name]').click(function(){
    var id_theme = $(this).attr('id_theme');
    var name = $(this).attr('data-name');
    $('#test-modal').find('.modal-header').append('<span>Тема: ' + name + '</span>');
    $('#test-modal').find('.modal-footer a').attr('href', _href + '?id_theme=' + id_theme);
});