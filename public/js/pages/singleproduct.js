$(document).ready(function(){
 const baseUrl = window.location.origin;

  function  error(xhr,status,statusTxt) {
      var status = xhr.status;
      switch(status){
          case 500:
              alert("Error on server!");
              break;
          case 404:
              alert("Page not found!");
              break;
          case 400:
              alert("Bad request!");
          default:
              alert("Error: " + status + " - " + statusTxt);
              break;
      }
  }
    var quantitiy=0;
    $('.quantity-right-plus').click(function(e){

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        $('#quantity').val(quantity + 1);


        // Increment

    });





    $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        // Increment
        if(quantity>0){
            $('#quantity').val(quantity - 1);
        }
    });

    $(document).on('click','#btnaddtocart',function (event) {
        event.preventDefault();

        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });

            let  df_id = document.getElementById('dfsingleproduct').value;
            let user_id = document.getElementById('usrsingleproduct').value;
            let quantity = document.getElementById('quantity').value;
            $.ajax({
                url: baseUrl + '/singleproduct/quantity',
                method: 'post',
                data: {
                    dfsingleproduct: df_id,
                    usrsingleproduct: user_id,
                    quantity: quantity,

                },
                success: function (data) {
                   alert("Product is added in cart!");
                    window.location.replace(baseUrl + "/cart");
                    window.location.href = baseUrl + "/cart";
                },
                error: error

            })


    });

});
