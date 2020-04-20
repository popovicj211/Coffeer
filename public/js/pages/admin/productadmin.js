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

hideBtnPhoto()
    function hideBtnPhoto(){
        $('#updateProducts .form-group label[for="photo"]').hide()
        $('#updateProducts .form-group #btnPhotoUp').hide()
        $('#updateProducts .form-group #upPhotoProduct').hide()
    }

    $('#showBtnImgUp').change(function () {
        $('#updateProducts .form-group label[for="photo"]').show()
        $('#updateProducts .form-group #btnPhotoUp').show()
        $('#showBtnImgUp').hide()
        $('#updateProducts .form-group label[for="showphoto"]').hide()
    })







    HideUpdate()
    function HideUpdate(){
        $('#updateAdmSlider').css('display','none')
        $('#updateHeader').css('display' , 'none')
    }




    $('#tableProducts').on("click" ,"tr td .updateProduct", function(e){
        e.preventDefault();
        $('#updateAdmSlider').show()
        $('#updateHeader').show()
        let id = $(this).data('id').split("-");
        let dfId = id[0]
        let imgId = id[1]

       $.ajax({
            method: 'get',
           url: baseUrl + "/admin/products/edit/" + dfId + "/image/" + imgId,
            dataType: 'json',
            success: function(data,status,xhr){

                console.log(data)
                console.log(xhr.status)
                $('#upPhotoProductExist').val(data.data.link + '-' + data.data.alt)
                $('#adminProductUpdateName').val(data.data.name);
                $('#adminProductUpdateDesc').val(data.data.desc);
                $('#adminProductUpdatePrice').val(data.data.price);
                $('#adminProductUpdateDiscount').val(data.data.dis_id);
                $('#adminProductUpdateCat').val(data.data.cat_id);
                $('#hiddenAdminProUpdateDfId').val(data.data.df_id);
                $('#hiddenAdminProUpdateImgId').val(data.data.img_id);
            },
            error: error
        });


    })


    $('#tableProducts').on("click" ,"tr td .deleteProduct", function(e){
        e.preventDefault();
        let id = $(this).data('id').split("-");
        let dfId = id[0]
        let imgId = id[1]
        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });
        console.log(id)
        $.ajax({
            method: 'DELETE',
            url: baseUrl + "/admin/products/delete/" + imgId,
            dataType: 'json',
            success: function(data,status,xhr){
                alert('Product is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });



    getProductsAdmin()

    function getProductsAdmin() {
        let url = baseUrl + '/admin/products/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) { console.log(data)
                contentProduct(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }




    function contentProduct(data) {
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
             <td> <img class="imgAdm" src="${img}" alt="${i.alt}"> </td>
            <td> ${i.name} </td>
            <td><p class="textDesc"> ${i.desc} </p></td>
            <td>  ${i.price} RSD</td>`
                if(i.newprice != null){
                    isp += `<td> ${i.newprice} RSD </td>`
                }else{
                    isp += `<td> ${slash} </td>`
                }
            if(i.percent != null){
                isp += `<td> ${i.percent}% </td>`
            }else{
                isp += `<td> ${slash} </td>`
            }
            isp += `<td> ${i.catname} </td>
            <td>  ${newDateCreated} ${newTimeCreated} </td>
            <td> ${newDateModified} ${newTimeModified} </td>
            <td> <a class="btn btn-primary updateProduct" data-id="${i.df_id}-${i.img_id}"  href="#">  Update </a> </td>
            <td> <a  class="btn btn-dark deleteProduct"  data-id="${i.df_id}-${i.img_id}" href="#"> Delete </a>  </td>
            </tr>`
        }
        $('#tableProducts').html(isp);
    }


    function PagValue(url){
        $('#pagProductAdmin').on("click",".pagination_link" , function(e){
            e.preventDefault()
            let numb = $(this).data("value");

            pag(numb , url)


        })
    }



    function pagLinks(data){
        var br = data.count
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

        $('#pagProductAdmin').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentProduct(pager)
            },error: error

        })
    }


    $('#adminProductUpdateSub').click(function(e){
        e.preventDefault();

        let photo = $('#upPhotoProduct');
        let photoExist = $('#upPhotoProductExist');
        let name = $('#adminProductUpdateName');
        let desc = $('#adminProductUpdateDesc');
        let price = $('#adminProductUpdatePrice');
        let discount = $('#adminProductUpdateDiscount option');
        let cat = document.getElementById('adminProductUpdateCat');
        let catOpt = cat.options[cat.selectedIndex].value;
        let dfId = $('#hiddenAdminProUpdateDfId').val();
        let imgId = $('#hiddenAdminProUpdateImgId').val();
        let validstar = $('.validstarUp');
        let regPhoto = /(\.)(jpg|jpeg|png)$/;
        let regName = /^[A-Z][\w\s]{3,50}$/;
        let regDesc = /^[A-Za-z\d\s\.\,\*\+\?\!\-\_\/\'\:\;]{10,}$/;
        let  regPrice = /^[\d]{1,5}(\.)[\d]{2}$/;
        let errorsUp = [];



        if(photo.val() != "") {

            if (!regPhoto.test(photo.val())) {
                errorsUp.push('Update photo is not valid!')
            }
        }

        if(!regName.test(name.val())){
            errorsUp.push('Update name is not valid!')

        }

        if(!regDesc.test(desc.val())){
            errorsUp.push('Update description is not valid!')

        }


        if(!regPrice.test(price.val())){
            errorsUp.push('Update price is not valid!');
        }


       /* let valList = ""
        $(cat).each(function(){
            valList = $(this).val();
        });

        if(valList == "0"){
            errorsUp.push('Category for update is not selected!')

        }*/

           if(catOpt == "0"){
               errorsUp.push('Category for update is not selected!')
           }


        if(errorsUp.length != 0){
            // alert(errors);
            validstar.css('display' , 'block')
            for(let i in errorsUp){
                result = '*';
                document.getElementsByClassName("validstarUp")[i].innerHTML = result;
            }
            let isp = ""
            isp += "<ul>"
            for(let i in errorsUp){
                isp += "<li style='color:#ff0000'>" + errorsUp[i] + "</li>"
            }
            isp += "</ul>"
            $('#errorsUpdProAdm').html(isp)

        }else{
            validstar.css('display' , 'none')

            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                }
            });



            $.ajax({
                url:"/admin/products/update/"+ dfId + "/image/" + imgId,
                method:"POST",
                data:{
                    upPhotoProduct:photo.val(),
                    upPhotoProductExist:photoExist.val(),
                    adminProductUpdateName:name.val(),
                    adminProductUpdateDesc:desc.val(),
                    adminProductUpdatePrice:price.val(),
                    adminProductUpdateDiscount:discount.val(),
                    adminProductUpdateCat:catOpt,
                    hiddenAdminProUpdateDfId:dfId,
                    hiddenAdminProUpdateImgId:imgId
                },
                success:function (data,status,xhr) {
                    alert('Product is successfully updated!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



});




