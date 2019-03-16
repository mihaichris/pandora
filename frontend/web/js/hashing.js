$("#message-input").change(function () {
    $.ajax({
        url: "/pandora/hash/hash-message",
        type: "POST",
        data: {
            data: $("#message-input").val()
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $("#hash_message-input").val(response.message_hash);

            // $("#card_private-key").children('p').append(response.private_key);
            // $("#card_public-key").children('p').append(response.public_key);

            // $("#card_private-key").append("<p style='word-wrap: break-word; width: 110em;'>"+ response.private_key + "</p>");
            // $("#card_public-key").append("<p style='word-wrap: break-word; width: 110em;'>"+ response.public_key + "</p>");

        },
        error: function (error) {
            console.log(error);
        }
    });
});