$("document").ready(function() {

    var alertBox = $("#alert"), loader = $("#loaderContent"), verifyBox = $("#verifyBox");
    $("#registerForm").submit(function() {
        alertBox.hide();    verifyBox.hide();
        loader.fadeIn(300);
        var userMail = $("#mail").val(), userPassword = $("#password").val(), userFullName = $("#fullName").val();
        var dataString = 'mail=' + userMail + "&password=" + userPassword + "&fullName=" + userFullName;
        console.log(dataString);
        $.ajax({
            type: "POST",
            url: "includes/process_register.php",
            data: dataString,
            cache: true,
            success: function(){
                loader.fadeOut(300);
            }
        }).done(function (data, textStatus, xhr) {
            var isValidated = xhr.getResponseHeader('verify');
            if(isValidated == -1) alertBox.show();
            else verifyBox.show();
        });
        return false;
    });
});