$("#submit").keypress(function (event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#form").submit();
    }
});

$("#uninput").keydown(function () {
    $("#usr_err_msg").hide();
});