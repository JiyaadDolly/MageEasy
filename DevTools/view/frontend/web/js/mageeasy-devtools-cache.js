require(["jquery", "mage/url"], function($, url) {

    $(document).ready(function() {

        $("#refresh-cache").click(function() {

            url.setBaseUrl(BASE_URL);
            let query_url = url.build('developer/query/cache');

            $("body").loader("show");

            $.ajax({
                url: query_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    key: "refresh_cache"
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

        $(".refresh-cache-single").click(function() {

            let cacheElement = $(this);

            url.setBaseUrl(BASE_URL);
            let query_url = url.build('developer/query/cache');

            $("body").loader("show");

            $.ajax({
                url: query_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    key: "refresh_cache_single",
                    value: $(this).data("id")
                },
                complete: function(response)
                {
                    if(response.responseJSON.data.success === true)
                    {
                        console.log("success");
                        console.log(response.responseJSON.data.message);

                        $(cacheElement).closest('.cache-item').find('.invalidated').removeClass('invalidated')
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

        $(document).on("change","input.cache-type", function() {

            let cacheElement = $(this);

            url.setBaseUrl(BASE_URL);
            let query_url = url.build('developer/query/cache');

            $("body").loader("show");

            $.ajax({
                url: query_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    key: "toggle_status",
                    type: $(this).attr('name'),
                    value: $(this).is(":checked")
                },
                complete: function(response)
                {
                    if(response.responseJSON.data.success === true)
                    {
                        console.log("success");
                        console.log(response.responseJSON.data.message);

                        if($(cacheElement).is(":checked")) {
                            $(cacheElement).closest('.cache-item').find('.invalidated').removeClass('invalidated')
                        }
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

    });
});
