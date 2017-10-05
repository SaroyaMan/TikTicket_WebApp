$("document").ready(function() {

    var alertBox = $("#alert"), loader = $("#loaderContent");
    $("#loginForm").submit(function() {
        alertBox.hide();
        loader.fadeIn(300);
        var userMail = $("#mail").val(), userPassword = $("#password").val();
        var dataString = 'mail=' + userMail + "&password=" + userPassword;
        $.ajax({
            type: "POST",
            url: "includes/process.php",
            data: dataString,
            cache: true,
            success: function(){
                loader.fadeOut(300);
            }
        }).done(function (data, textStatus, xhr) {
            var isValidated = xhr.getResponseHeader('verify');
            if(isValidated == -1) alertBox.show();
            else window.location.replace("index.php");
        });
        return false;
    });
});