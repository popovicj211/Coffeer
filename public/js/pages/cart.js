$(document).ready(function(){
    const baseUrl = window.location.origin;
    var url = baseUrl + '/cart/show'
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


    $('#checkoutBtn').click(function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });

        $.ajax({
            method: 'post',
            url: baseUrl + "/addtocart",
            dataType: 'json',
            data:{ checkoutBtn: true },
            success: function(data){
                alert('More products added in cart!')
           
            },
            error: error
        });


    })



/*
    getCartsDFs()

 function getCartsDFs() {

        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {
               console.log(data.data)
                contentGetCartsDFs(data.data)
                pagLinks(data)
                PagValue()
                contentGetCartsDFTotal(data)
            },
            error: error

        })


    }


    function contentGetCartsDFs(data) {
        let isp = ""
        for(let i of data){
            let datetime = new Date(i.created)
            let month = ["Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Okt" , "Nov" ,"Dec"]
            let newDate = datetime.getDate() + " " + month[datetime.getMonth()] + " " + datetime.getFullYear()
            let newTime = datetime.getHours() + ":" + datetime.getMinutes() + ":" + datetime.getSeconds();
            let img = baseUrl + "/images/products/" + i.link


            isp += `<tr class="text-center">
                    <td class="product-remove"><a class="deleteCart" data-id="${i.cart_id}" href="#"><span class="icon-close"></span></a></td>

                <td class="image-prod"><div class="img" style="background-image:url(${img});"></div></td>

                <td class="product-name">
                    <h3>Creamy Latte Coffee ${i.name} </h3>

                </td>`

            if( i.newprice != null) {
                isp += `<td class="price"> ${i.newprice } RSD</td>`
            } else {
                isp += `<td class = "price" >  ${i.price} RSD </td>`
            }
            isp += `<td class="quantity">

                    <div   class="quantitycart text-white" > ${ i.quantity }</div>

                <td class="total"> ${i.total} RSD</td>
                <td class="text-white"> ${newDate} ${newTime} </td>
                </tr>`
        }
        $('#showCarts').html(isp);
    }



    function contentGetCartsDFTotal(data) {
        let loc = baseUrl + "/checkout"
    let isp = ""
   isp +=  `<div class="cart-total mb-3">
                          <h3>Cart Totals</h3>
                          <hr>
                          <p class="d-flex total-price">
                                    <span>Total</span>
                                    <span> ${data.sum} RSD</span>
                         </p>
         </div>`
              if(data.counts != 0) {
                  isp += `<p class="text-center"><a href="${loc}" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>`
              }

        $('#cartTotal').html(isp);
    }


    function PagValue(){
        $('#pagshowcart').on("click",".pagination_link" , function(e){
            e.preventDefault()
            let numb = $(this).data("value");

            pag(numb)


        })
    }



    function pagLinks(data){
        var br = data.counts
        var countPerPage = 6
        var countMatches = parseInt(br);
        var countLink = (Math.ceil(countMatches / countPerPage));
        var isp = '';

        isp +=  '<ul>'

        for(var i = 1; i <= countLink ; i++) {
            //  for(let i = countLink; i >= 1; i--){

                 isp += '<li ><a class="pagination_link"  data-value="' + i + '" href="#">' + i + '</a></li>';
        }
        isp += '</ul>'

        $('#pagshowcart').html(isp);


    }


    function pag(numb){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                console.log(numb)
                console.log(data)
                let pager = data.data
                contentGetCartsDFs(pager)
            },error: error

        })
    }
*/
/*
    $('#showCarts').on("click" ,"tr td .deleteCart", function(e){
        e.preventDefault();
        let id = $(this).data('id')

        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });

        $.ajax({
            method: 'DELETE',
            url: baseUrl + "/cart/delete/" + id,
            dataType: 'json',
            success: function(data,status,xhr){
                alert('Cart is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });
*/

});
