if (timer) {
    var i = 10 * timer; // timer from view 
    var t = i;
    var counterBack = setInterval(function () {
        i--;
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
        } else {
            clearInterval(counterBack);
            $('button[type="submit"]').val('0').submit();
        }
    }, 100);
    $('button[type="submit"]').click(function(){
        $.post('total', {totaltime:(t-i)/10});
    });
    
    $(window).mouseout(function(e){
//        var params = window.location.search.replace('?','').split('&').reduce(
//            function(p,e){
//                var a = e.split('=');
//                p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
//                return p;
//            },
//        );
        var strGET = window.location.search.replace( '?', ''); 
//        var data = [];
//        if (params['id_test']){
//            data['id_test'] = params['id_test'];
//        } else {
//            data['id_theme'] = params['id_theme'];
//        }
        var out = false;
            if (e.toElement === null ) {
                clearInterval(counterBack);
                $.post('total?' + strGET, {out:true});
                //console.log('the mouse left the window'); 
            }
    });
}
//window.onbeforeunload = function() {alert("пока");};
//window.onbeforeunload = function() {
//    return 'You have unsaved changes!';
//};
//function fullscreen(element) {
//  if(element.requestFullScreen) {
//    element.requestFullScreen();
//  } else if(element.mozRequestFullScreen) {
//    element.mozRequestFullScreen();
//  } else if(element.webkitRequestFullScreen) {
//    element.webkitRequestFullScreen();
//  }
//}
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