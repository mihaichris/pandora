$("#generate-wallet-button").click(function () {
    $.ajax({
        url: "generate-wallet",
        type: "POST",
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $("#wallet-private_address").val(response.private_key);
            $("#wallet-public_address").val(response.public_key);

            // $("#card_private-key").children('p').append(response.private_key);
            // $("#card_public-key").children('p').append(response.public_key);

            // $("#card_private-key").append("<p style='word-wrap: break-word; width: 110em;'>"+ response.private_key + "</p>");
            // $("#card_public-key").append("<p style='word-wrap: break-word; width: 110em;'>"+ response.public_key + "</p>");

            $('#confirm-wallet-button').prop('disabled', false);
        },
        error: function (error) {
            console.log(error);
            $.notify({
                icon: 'error',
                message: "Opss, a apărut o eroare, ai grijă ca nodul tău sa fie pornit și conectat la rețea."
            }, {
                // settings
                type: "danger"
            });
        }
    });
});


$("#add-balance-button").click(function () {
    console.log($("#deposit").val());
    $.ajax({
        url: "add-balance",
        type: "POST",
        data: {
            data: $("#deposit").val()
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.type == "success") {
                $.notify({
                    icon: 'check',
                    message: response.message
                }, {
                    // settings
                    type: response.type
                });
                $("#balance").load(" #balance").fadeIn("slow");
                $("#deposit").val('');
            } else {
                $.notify({
                    icon: 'error',
                    message: response.message
                }, {
                    // settings
                    type: response.type
                });
                $("#deposit").val('');
            }

        },
        error: function (error) {
            console.log(error);
        }
    });
});

$(document).ready(function () {
    $('#confirm-wallet-button').prop('disabled', true);
});