function showAccess(){
    $.ajax({
        url: 'ajax-list',
        type: 'post',
        data: {id_user:$('[name="id_user"]').val()},
        success: function (html) {
            $("#list-access").html(html);
        }
    });
};
$('#link-show-hide').click(function(){
    if ($(this).text() === 'свернуть'){
        $(this).text('развернуть');
    } else {
        $(this).text('свернуть');
    }
});
$('#authmodules-name').focus();