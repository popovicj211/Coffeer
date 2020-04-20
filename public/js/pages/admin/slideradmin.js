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
        $('#updateSlider .form-group label[for="photo"]').hide()
        $('#updateSlider .form-group #btnPhotoUpSld').hide()
        $('#updateSlider .form-group #upPhotoSlide').hide()
    }

    $('#showBtnImgUpSld').change(function () {
        $('#updateSlider .form-group label[for="photo"]').show()
        $('#updateSlider .form-group #btnPhotoUpSld').show()
        $('#showBtnImgUpSld').hide()
        $('#updateSlider .form-group label[for="showphoto"]').hide()
    })







    HideUpdate()
    function HideUpdate(){
        $('#updateAdmSlider').css('display','none')
        $('#updateHeaderSld').css('display' , 'none')
    }




    $('#tableSlider').on("click" ,"tr td .updateSlide", function(e){
        e.preventDefault();
        $('#updateAdmSlider').show()
        $('#updateHeaderSld').show()
        let id = $(this).data('id').split("-");
        let slideId = id[0]
        let imgId = id[1]

        $.ajax({
            method: 'get',
            url: baseUrl + "/admin/slider/edit/" + slideId + "/images/" + imgId,
            dataType: 'json',
            success: function(data,status,xhr){

                console.log(data)
                console.log(xhr.status)
                $('#upPhotoSlideExist').val(data.data.link + '*-*' + data.data.alt)
                $('#adminSlideUpdateName').val(data.data.name);
                $('#adminSlideUpdateText').val(data.data.text);
                $('#hiddenAdminSlideUpdateSlideId').val(data.data.slide_id);
                $('#hiddenAdminSlideUpdateImgId').val(data.data.img_id);
            },
            error: error
        });


    })


    $('#tableSlider').on("click" ,"tr td .deleteSlide", function(e){
        e.preventDefault();
        let id = $(this).data('id').split("-");
        let slideId = id[0]
        let imgId = id[1]
        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });
        console.log(id)
        $.ajax({
            method: 'DELETE',
            url: baseUrl + "/admin/slider/delete/" + imgId,
            dataType: 'json',
            success: function(data,status,xhr){
                alert('Slide is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });



    getSliderAdmin()

    function getSliderAdmin() {
        let url = baseUrl + '/admin/slider/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) { console.log(data)
                contentSlider(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }




    function contentSlider(data) {
        let dataSlider = data.data
        let isp = ""
        let br = 1;
        let slash = "/"
        for (let i of dataSlider) {
            let img = baseUrl + "/images/products/" + i.link


            isp += `<tr>
            <td scope="row"> ${br++}</td>
             <td> <img class="imgAdm" src="${img}" alt="${i.alt}"> </td>
            <td> ${i.name} </td>
            <td><p> ${i.text} </p></td>
            <td> <a class="btn btn-primary updateSlide" data-id="${i.slide_id}-${i.img_id}"  href="#">  Update </a> </td>
            <td> <a  class="btn btn-dark deleteSlide"  data-id="${i.slide_id}-${i.img_id}" href="#"> Delete </a>  </td>
            </tr>`
        }
        $('#tableSlider').html(isp);
    }


    function PagValue(url){
        $('#pagSliderAdmin').on("click",".pagination_link" , function(e){
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

        $('#pagSliderAdmin').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentSlider(pager)
            },error: error

        })
    }


    $('#adminSliderUpdateSub').click(function(e){
        e.preventDefault();

        let photo = $('#upPhotoSlide');
        let photoExist = $('#upPhotoSlideExist');
        let name = $('#adminSlideUpdateName');
        let desc = $('#adminSlideUpdateText');
        let slideId = $('#hiddenAdminSlideUpdateSlideId').val();
        let imgId = $('#hiddenAdminSlideUpdateImgId').val();
        let validstar = $('.validstarUp');
        let regPhoto = /(\.)(jpg|jpeg|png)$/;
        let regName = /^[A-Z][\w\s]{3,50}$/;
        let regDesc = /^[A-Za-z\d\s\.\,\*\+\?\!\-\_\/\'\:\;]{10,}$/;
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
            errorsUp.push('Update text is not valid!')

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
            $('#errorsUpdSlideAdm').html(isp)

        }else{
            validstar.css('display' , 'none')

            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                }
            });



            $.ajax({
                url:"/admin/slider/update/"+ slideId + "/images/" + imgId,
                method:"POST",
                data:{
                    upPhotoSlide:photo.val(),
                    upPhotoSlideExist:photoExist.val(),
                    adminSlideUpdateName:name.val(),
                    adminSlideUpdateText:desc.val(),
                    hiddenAdminSlideUpdateSlideId:slideId,
                    hiddenAdminSlideUpdateImgId:imgId
                },
                success:function (data,status,xhr) {
                    alert('Slide is successfully updated!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



});
