$(document).ready(function(){
    const baseUrl = window.location.origin;


    function spinner() {
        $(document).ajaxStart(function () {
            $('#spinner').show();
            $('.btn').attr('disabled' , true)
        })

        $(document).ajaxComplete(function () {
            $('#spinner').hide();
        })

    }


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



    HideUpdate()
    function HideUpdate(){
        $('#updateAdmCart').css('display','none')
        $('#updateHeaderCart').css('display' , 'none')
    }

    $("#filterListUser option").each(function() {
        $('#filterListUser option:first-child').hide()

    });



    $('#filterListUserSub').click(function (e) {
        e.preventDefault();
        let user =  $('#filterListUser').val()
        var url = baseUrl + '/admin/cart/show/filter'
        $.ajax({
            url: url,
            method: 'get',
            data:{
                filterListUser:user
            },
            success: function (data) {
                   console.log(data)
                contentCart(data)
                pagLinks(data)
                PagValue(url)
                $('#totalsSum').show();
                sumTotals(data)
            },
            error: error

        })
    })


    $('#tableCartAdm').on("click" ,"tr td .updateCart", function(e){
        e.preventDefault();
        $('#updateAdmCart').show()
        $('#updateHeaderCart').show()
        let id = $(this).data('id');

        $.ajax({
            method: 'get',
            url: baseUrl + "/admin/cart/edit/" + id,
            dataType: 'json',
            success: function(data,status,xhr){

                $('#adminCartUpdateUser').val(data.data.user_id);
                  if(data.data.newprice != null) {
                      $('#adminCartUpdateProduct').val(data.data.df_id + "-" + data.data.newprice);
                  }else{
                      $('#adminCartUpdateProduct').val(data.data.df_id + "-" + data.data.price);
                  }
                $('#adminCartUpdateQuantity').val(data.data.quantity);
                $('#hiddenAdminCartUpdateCartId').val(data.data.cart_id);
                $('#hiddenAdminCartUpdateUserId').val(data.data.user_id);
            },
            error: error
        });


    })


    $('#tableCartAdm').on("click" ,"tr td .deleteCart", function(e){
        e.preventDefault();
        let id = $(this).data('id')

        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });

        $.ajax({
            method: 'DELETE',
            url: baseUrl + "/admin/cart/delete/" + id,
            dataType: 'json',
            success: function(data,status,xhr){
                alert('Cart is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });



    getCartAdmin()

    function getCartAdmin() {
        let url = baseUrl + '/admin/cart/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) { console.log(data)
                contentCart(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }

    hideTotalCart()
    function hideTotalCart() {
         $('#totalsSum').css('display' , 'none');
    }


    function contentCart(data) {
        let dataProduct = data.data
        let isp = ""
        let br = 1;
        let slash = "/"
        for (let i of dataProduct) {
            let img = baseUrl + "/images/products/" + i.link

            let dateTimeCreated = new Date(i.created)
            let month = ["Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Okt" , "Nov" ,"Dec"]
            let newDateCreated = dateTimeCreated.getDate() + "-" + month[dateTimeCreated.getMonth()] + "-" + dateTimeCreated.getFullYear()
            let newTimeCreated = dateTimeCreated.getHours() + ":" + dateTimeCreated.getMinutes() + ":" + dateTimeCreated.getSeconds();
            let dateTimeModified = new Date(i.modified)
            let newDateModified = dateTimeModified.getDate() + "-" + month[dateTimeModified.getMonth()] + "-" + dateTimeModified.getFullYear()
            let newTimeModified = dateTimeModified.getHours() + ":" + dateTimeModified.getMinutes() + ":" + dateTimeModified.getSeconds();

            isp += `<tr>
            <td scope="row"> ${br++}</td>
              <td> ${i.nameuser} </td>
                <td> ${i.email} </td>
             <td> <img class="imgAdm" src="${img}" alt="${i.alt}"> </td>
            <td> ${i.name} </td>
            <td>  ${i.price} RSD</td>`
            if(i.newprice != null){
                isp += `<td> ${i.newprice} RSD </td>`
            }else{
                isp += `<td> ${slash} </td>`
            }
            isp += `<td> ${i.quantity} </td>
                     <td> ${i.total} </td>
            <td>  ${newDateCreated} ${newTimeCreated} </td>
            <td> ${newDateModified} ${newTimeModified} </td>
            <td> <a class="btn btn-primary updateCart" data-id="${i.cart_id}"  href="#">  Update </a> </td>
            <td> <a  class="btn btn-dark deleteCart"  data-id="${i.cart_id}" href="#"> Delete </a>  </td>
            </tr>`
        }
        $('#tableCartAdm').html(isp);
    }

    function sumTotals(data) {
        let sum = data.sum;
        isp = ""
  isp += `<h3>Cart Totals</h3>
        <hr>
        <p class="d-flex total-price">
            <span>Total:</span>`
            if(sum !=  null) {
                isp += `<span> ${sum} RSD</span>`
            }
   isp += `</p>`
        $('#cartTotals').html(isp)
    }


    function PagValue(url){
        $('#pagCartAdmin').on("click",".pagination_link" , function(e){
            e.preventDefault()
            let numb = $(this).data("value");

            pag(numb , url)


        })
    }



    function pagLinks(data){
        var br = data.counts
        var countPerPage = 5
        var countMatches = parseInt(br);
        var countLink = (Math.ceil(countMatches / countPerPage));
        var isp = '';

        isp +=  '<ul>'
        for(var i = 1; i <= countLink ; i++) {
            //  for(let i = countLink; i >= 1; i--){

            isp += '<li ><a class="pagination_link"  data-value="' + i + '" href="#">' + i + '</a></li>';

        }
        isp += '</ul>'

        $('#pagCartAdmin').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                console.log(data)
                let pager = data
                contentCart(pager)
            },error: error

        })
    }




    $('#adminCartUpdateSub').click(function(e){
        e.preventDefault();

        let user = document.getElementById('adminCartUpdateUser');
        let userOpt = user.options[user.selectedIndex].value;
        let product = document.getElementById('adminCartUpdateProduct');
        let productOpt = product.options[product.selectedIndex].value;
        let quantity = document.getElementById('adminCartUpdateQuantity');
        let quantityOpt = quantity.options[quantity.selectedIndex].value;
        let cartId = $('#hiddenAdminCartUpdateCartId').val();
        let validstar = $('.validstarUp');

        let errorsUp = [];



        if(userOpt == "0"){
            errorsUp.push('User for update is not selected!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(productOpt == "0"){
            errorsUp.push('Product for update is not selected!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(quantityOpt == "0"){
            errorsUp.push('Quantity for update is not selected!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }


        if(errorsUp.length != 0){

            let isp = ""
            isp += "<ul>"
            for(let i in errorsUp){
                isp += "<li style='color:#ff0000'>" + errorsUp[i] + "</li>"
            }
            isp += "</ul>"
            $('#errorsUpdCartAdm').html(isp)

        }else{
           // validstar.css('display' , 'none')

            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                }
            });



            $.ajax({
                url:"/admin/cart/update/"+ cartId ,
                method:"POST",
                data:{

                    adminCartUpdateUser:userOpt,
                    adminCartUpdateProduct:productOpt,
                    adminCartUpdateQuantity:quantityOpt,
                    hiddenAdminCartUpdateCartId:cartId,

                },
                success:function (data,status,xhr) {
                    alert('Cart is successfully updated!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



});

