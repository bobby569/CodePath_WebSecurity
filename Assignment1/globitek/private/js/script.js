$("#submit").keypress(function (event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#form").submit();
    }
});