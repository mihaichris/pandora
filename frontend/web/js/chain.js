$("#sync_chain-button").click(function () {
    $.ajax({
      url: "sync-chain",
      type: "POST",
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
            $("#chain-blocks").load(" #chain-blocks");
        } else {
            $.notify({
                icon: 'error',
                message: response.message
            }, {
                // settings
                type: response.type
            });
        }
    },
      
      error: function (error) {
        console.log('A aparut o eroare de la client!')
  
      }
    });
  
  
  });