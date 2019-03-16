function mempoolDetails(id){
    $.ajax({
        url: "mempool-details",
        type: "POST",
        data: {
          id: id
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
        $('#mempool_profile').fadeOut("slow"); 
        
          $('#change-user_avatar').attr("src",response.user_avatar);
          $('#change-user_role').html(response.role);
          $('#change-user_name').html(response.name);
          $('#change-user_amount').html(response.amount);
          $('#change-user_created_at').html(response.created_at);

          $('#mempool_profile').fadeIn("slow");  
        
      },
        error: function (error) {
          console.log(error);
          
        }
      });
}
$("#dismiss-mempool-details_button").click(function(){
  $('#mempool_profile').fadeOut("slow"); 
});