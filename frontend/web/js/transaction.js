$(document).ready(function () {
  if (!$('#wallet-public_address').val() && !$('#wallet-private_address').val() || !$('#receiver_address').val()) {
    $('#generate-transaction-button').prop('disabled', true);
  }
});

$("#generate-transaction-button").click(function () {

  $.ajax({
    url: "sign-transaction",
    type: "POST",
    data: {
      sender: $("#wallet-public_address").val(),
      sender_private_key: $("#wallet-private_address").val(),
      receiver_id: $("#receiver_address").val(),
      amount: $("#amount").val(),
    },
    dataType: 'json',
    success: function (response) {
      console.log(response);

      $("#receiver_name").val($("#receiver_address option:selected").text());
      $("#value-disp").val($("#amount-disp").val());
      $("#signature").val(response.signature);
    },
    error: function (error) {
      $('#confirm-transaction-modal').modal('toggle');
      console.log(error);
      $.notify({
        icon: 'error',
        message: "Server-ul a întampinat o problema, ai grijă ca nodul tău să fie pornit și conectat la rețea.",
      }, {
        // settings
        type: "danger",
        placement: {
          from: "top",
          align: "center"
        },
      });

    }
  });


});


$("#receiver_address").change(function () {
  if ($("#receiver_address").val() == "") {
    $('#user-card').fadeOut("slow");
    $('#generate-transaction-button').attr('disabled', true);
  } else {
    $.ajax({
      url: "change-receiver",
      type: "POST",
      data: {
        data: $("#receiver_address").val()
      },
      dataType: 'json',
      success: function (response) {
        console.log(response);
        $('#change-user_avatar').attr("src", "/pandora/frontend/web/img/" + response.username + "_avatar.jpg");
        $('#change-user_name').html(response.name);
        $('#change-user_role').html(response.item_name);
        $('#change-user_public_email').html(response.location);
        $('#change-user_bio').html(response.bio);
        $('#user-card').fadeIn("slow");
        $('#generate-transaction-button').attr('disabled', false);
      },
      error: function (error) {
        console.log(error);

      }
    });
  }

});

$("#confirm-transaction-button").click(function () {
  $.ajax({
    url: "confirm-transaction",
    type: "POST",
    data: {
      sender: $("#wallet-public_address").val(),
      signature: $("#signature").val(),
      receiver_id: $("#receiver_address").val(),
      amount: $("#amount").val(),
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
        $("#amount-disp").val("");

      } else {
        $.notify({
          icon: 'error',
          message: response.message
        }, {
          // settings
          type: response.type,

        });
      }

    },
    error: function (error) {
      console.log(error);
      $.notify({
        icon: 'error',
        message: "A apărut o eroare. Anumite noduri nu sunt conectate la rețea în acest moment !"
      }, {
        // settings
        type: "danger",
        placement: {
          from: "top",
          align: "center"
        },
      });
    }
  });
});