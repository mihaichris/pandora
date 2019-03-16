$("#add-node_button").click(function () {
    console.log($("#node-input").val());
    $.ajax({
        url: "add-node",
        type: "POST",
        data: {
            node: $("#node-input").val()
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
                $("#connected-nodes_grid").load(" #connected-nodes_grid");
                $("#transaction-grid").load(" #transaction-grid");
                $("#node-input").val('');
            } else {
                $.notify({
                    icon: 'error',
                    message: response.message
                }, {
                    // settings
                    type: response.type
                });
                $("#node-input").val('');
            }

        },
        error: function (error) {
            console.log(error);
        }
    });
});