$ = jQuery;
$(".register button").on("click", () => {
    console.log($("#infos").attr("data-url"));

    $(".alert").slideUp();

    $.post(
        {
            url: $("#infos").attr("data-url"),
            data: {
                action: "register",
                name: $(".name").val(),
                email: $(".email").val(),
                password: $(".password").val(),
                age: $(".age").val(),
                gender: $(".gender").val(),
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
