
$(document).ready(function(){
    'use strict'
    checkChain();
});

function checkChain() {
    $('#chain-valid-message').hide();
    $.ajax({
        url: "check-chain-validation",
        type: "GET",
        dataType: 'json',
        success: function (response) {
            // $('#loader').hide();
            $('#chain-valid-message').show();
            if(response.code === 'success')
            {
                $('#chain-valid-message').text(response.message);
                $('#icon-chain-valid-message').html("<i class='material-icons text-success'>check_circle</i>");
            }
            else
            {
                $('#chain-valid-message').text(response.message);
                $('#icon-chain-valid-message').html("<i class ='material-icons text-danger'>report_problem</i>");
            }
        },

        error: function (error) {
            console.log('A aparut o eroare de la client!');

        }
    });
}