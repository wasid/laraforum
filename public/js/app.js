$(document).ready(function() {

    $("#form_submit").click(function() {
        $("#target_form").submit();
    });

    $("#category_submit").click(function() {
        $("#category_form").submit();
    });

    $(".new_category").click(function(e) {
        var id = e.target.id;
        var pieces = id.split("-");
        $("#category_form").prop('action', '/forum/category/' + pieces[2] + '/new');

    });

    $(".delete_group").click(function(event) {
        var _this = $(this);

        $("#btn_delete_group").prop('href', '/forum/group/' + event.target.id + '/delete');

    });

    $(".delete_category").click(function(event) {
        var _this = $(this);

        $("#btn_delete_category").prop('href', '/forum/category/' + event.target.id + '/delete');

    });

    $(".delete_thread").click(function(event) {
        var _this = $(this);

        $("#btn_delete_thread").prop('href', '/forum/thread/' + event.target.id + '/delete');

    });

    $(".delete_comment").click(function(event) {
        var _this = $(this);

        $("#btn_delete_comment").prop('href', '/forum/comment/' + event.target.id + '/delete');

    });

       $("#post_comment").click(function() {

        var forum_comment = $('#forum_comment').serializeArray();
        var url = $('#forum_comment').attr('action');

        $.post(url, forum_comment, function(data) {
            window.location.reload();
        });

    });

});