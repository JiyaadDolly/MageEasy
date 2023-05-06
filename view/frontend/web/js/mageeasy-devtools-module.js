require(["jquery", "mage/url"], function($, url) {

    $(document).ready(function() {

        // DEVELOPER OPTIONS CONTAINER
        var developerOptionsWidth = $(".container-developer-options").outerWidth();
        $(".container-developer-options").css("right", -developerOptionsWidth);
        $(".container-developer-options").show();

        $(".container-developer-options .toggler").click(function() {
            var developerOptionsWidth = $(".container-developer-options").outerWidth();

            if($(".container-developer-options").css("right") == "0px")
            {
                $(".container-developer-options").css("right", -developerOptionsWidth);
                $(".toggler").css("right",0);
            }
            else
            {
                $(".container-developer-options").css("right", 0);
                $(".toggler").css("right",developerOptionsWidth);

            }
        });

        // CUSTOMER LOGIN
        $(".container-developer-options #customer-login").change(function(){

            if($(this).val() && $(this).find(":selected").data("password")) {

                var isAuthenticated = $(".container-customer-login").data("iscustomerauthenticated");

                if(isAuthenticated == true) {

                    var username = $(".container-developer-options #customer-login").val().trim();
                    var password = $(".container-developer-options #customer-login").find(":selected").data("password").trim();

                    var logoutUrl = BASE_URL + "customer/account/logout/";

                    $("body").loader("show");

                    $.ajax({
                        url: logoutUrl,
                        type: 'post',
                        async: false,
                        data: { developerLogout: true },
                        success: function(data) {

                            $("body").loader("hide");
                            console.log("Logout Successful");

                            const redirectParams = new URL(BASE_URL);
                            redirectParams.searchParams.append('auto-login', true);
                            redirectParams.searchParams.append('email', btoa(username));
                            redirectParams.searchParams.append('password', btoa(password));
                            redirectParams.searchParams.append('refer', btoa(location.href));
                            location.href = redirectParams.href;
                        },
                        error: function (xhr, status, errorThrown)
                        {
                            console.log('Error happens. Try again.');
                            console.log(xhr);
                            console.log(status);
                            console.log(errorThrown);

                            $("body").loader("hide");
                        }
                    });
                }
                else {

                    var loginUrl = BASE_URL + "customer/account/loginPost/";
                    var username = $(".container-developer-options #customer-login").val().trim();
                    var password = $(".container-developer-options #customer-login").find(":selected").data("password").trim();

                    $.ajax({
                        url: loginUrl,
                        type: 'post',
                        async: false,
                        data:  {
                            "login[username]": username,
                            "login[password]": password,
                            "login[developer]": true,
                        },
                        success: function() {

                            console.log("Login Successful");
                            location.reload();
                        }
                    });

                }
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const autoLogin = urlParams.get("auto-login");

        if(autoLogin) {

            var loginUrl = BASE_URL + "customer/account/loginPost/";
            var username = atob(urlParams.get("email"));
            var password = atob(urlParams.get("password"));
            var refer = atob(urlParams.get("refer"));

            $(".container-customer-login").find("form #dev-login-username").val(username);
            $(".container-customer-login").find("form #dev-login-password").val(password);

            var form = $(".container-customer-login").find("form").serialize();

            $.ajax({
                url: loginUrl,
                type: 'post',
                async: false,
                data:  form,
                success: function() {

                    console.log("Login Successful");
                    location.href = refer;
                }
            });
        }

        // NAVIGATE TO ADMIN
        $(".container-developer-options #navigate-to-admin").click(function() {
            let uri = $("#navigate-to-admin").data("uri");
            window.open(uri, '_blank');
        });

        $(document).on("change","input[name='toggle_path_hints']", function() {

            url.setBaseUrl(BASE_URL);
            let query_url = url.build('developer/query');

            $("body").loader("show");

            $.ajax({
                url: query_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    toggle: "path_hints",
                    value: $(this).is(":checked")
                },
                complete: function(response)
                {
                    if(response.responseJSON.data.success === true)
                    {
                        console.log("success");
                        console.log(response.responseJSON.data.message);
                    }
                    else
                    {
                        console.log("fail");
                    }

                    $("body").loader("hide");
                },
                error: function (xhr, status, errorThrown)
                {
                    console.log('Error happens. Try again.');
                    console.log(xhr);
                    console.log(status);
                    console.log(errorThrown);

                    $("body").loader("hide");
                }
            });

        });

        $(document).on("change","input[name='toggle_layout_logger']", function() {

            url.setBaseUrl(BASE_URL);
            let query_url = url.build('developer/query');

            $("body").loader("show");

            $.ajax({
                url: query_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    toggle: "layout_logger",
                    value: $(this).is(":checked")
                },
                complete: function(response)
                {
                    if(response.responseJSON.data.success === true)
                    {
                        console.log("success");
                        console.log(response.responseJSON.data.message);
                    }
                    else
                    {
                        console.log("fail");
                    }

                    $("body").loader("hide");
                },
                error: function (xhr, status, errorThrown)
                {
                    console.log('Error happens. Try again.');
                    console.log(xhr);
                    console.log(status);
                    console.log(errorThrown);

                    $("body").loader("hide");
                }
            });

        });

        $(document).on("change","input[name='less_compilation']", function() {

            url.setBaseUrl(BASE_URL);
            let query_url = url.build('developer/query');

            $("body").loader("show");

            $.ajax({
                url: query_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    toggle: "less_compilation",
                    value: $(this).is(":checked")
                },
                complete: function(response)
                {
                    if(response.responseJSON.data.success === true)
                    {
                        console.log(response.responseJSON.data.message);
                    }
                    else
                    {
                        console.log("fail");
                    }

                    $("body").loader("hide");
                },
                error: function (xhr, status, errorThrown)
                {
                    console.log('Error happens. Try again.');
                    console.log(xhr);
                    console.log(status);
                    console.log(errorThrown);

                    $("body").loader("hide");
                }
            });

        });

        // ADD PATH HINT VALUE TO ANCHOR TAG
        const templateHints = $('.template-hints-activate');
        const pathHintValue = templateHints.data('pathintvalue');
        templateHints.attr('href', window.location.href  + "?templatehints=" + pathHintValue);

        // ACCORDION
        $(document).on('click', ".debug-toolkit .section .heading", function() {

            if($(this).closest('.section').find('.body').css('display') == 'none')
            {
                $(this).closest('.section').find('.body').show();
                $(this).find('img.chevron').attr('src',
                    $(this).find('img.chevron').data('chevronup')
                );
            }
            else
            {
                $(this).closest('.section').find('.body').hide();
                $(this).find('img.chevron').attr('src',
                    $(this).find('img.chevron').data('chevrondown')
                );
            }
        });
    });
});
