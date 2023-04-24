require(["jquery"], function($) {
    $(document).ready(function() {

        const username = $("#username");
        const password = $("#login");
        username.change(function(){
            password.val($(this).find(":selected").data("password").trim());
        });
    });
});
