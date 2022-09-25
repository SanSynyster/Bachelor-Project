$ = jQuery;
$(".login button").on("click", () => {
    console.log($("#infos").attr("data-url"));

    $(".alert").slideUp();

    $.post(
        {
            url: $("#infos").attr("data-url"),
            data: {
                action: "login",
                email: $(".email").val(),
                password: $(".password").val(),
            },
        },
        function (jsonResponse) {
            console.log(jsonResponse);
            $(".alert").slideDown();
            if (jsonResponse.success) {
                $(".alert").addClass("alert-success");
                $(".alert").removeClass("alert-danger");
                window.location.replace(
                    "https://" +
                        window.location.hostname +
                        ":" +
                        window.location.port
                );
            } else {
                $(".alert").removeClass("alert-success");
                $(".alert").addClass("alert-danger");
            }
            $(".alert").text(jsonResponse.data.message);
        }
    );
});

$(".logout").on("click", () => {
    $.post(
        {
            url: $("#infos-header").attr("data-url"),
            data: {
                action: "logout",
            },
        },
        function (jsonResponse) {
            if (jsonResponse.success) {
                window.location.replace(
                    "https://" +
                        window.location.hostname +
                        ":" +
                        window.location.port
                );
            } else {
            }
        }
    );
});
