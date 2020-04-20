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
        $('#updateAdmContact').css('display','none')
        $('#updateHeaderContact').css('display' , 'none')
    }




    $('#tableContact').on("click" ,"tr td .updateContact", function(e){
        e.preventDefault();
        $('#updateAdmContact').show()
        $('#updateHeaderContact').show()
        let id = $(this).data('id');

        $.ajax({
            method: 'get',
            url: baseUrl + "/admin/contact/edit/" + id,
            dataType: 'json',
            success: function(data,status,xhr){

                console.log(data)
                console.log(xhr.status)
                $('#adminContactUpdateName').val(data.data.name);
                $('#adminContactUpdateEmail').val(data.data.email);
                $('#adminContactUpdateSubject').val(data.data.subject);
                $('#adminContactUpdateMessage').val(data.data.message);
                $('#hiddenAdminUpdateContId').val(data.data.cont_id);
            },
            error: error
        });


    })


    $('#tableContact').on("click" ,"tr td .deleteContact", function(e){
        e.preventDefault();
        let id = $(this).data('id')

        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });
        console.log(id)
        $.ajax({
            method: 'DELETE',
            url: baseUrl + "/admin/contact/delete/" + id,
            dataType: 'json',
            success: function(data,status,xhr){
                alert('Contact is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });



    getProductsAdmin()

    function getProductsAdmin() {
        let url = baseUrl + '/admin/contact/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) { console.log(data)
                contentContact(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }




    function contentContact(data) {
        let dataProduct = data.data
        let isp = ""
        let br = 1;
        for (let i of dataProduct) {

            let dateTimeCreated = new Date(i.created)
            let month = ["Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Okt" , "Nov" ,"Dec"]
            let newDateCreated = dateTimeCreated.getDate() + "-" + month[dateTimeCreated.getMonth()] + "-" + dateTimeCreated.getFullYear()
            let newTimeCreated = dateTimeCreated.getHours() + ":" + dateTimeCreated.getMinutes() + ":" + dateTimeCreated.getSeconds();
            let dateTimeModified = new Date(i.modified)
            let newDateModified = dateTimeModified.getDate() + "-" + month[dateTimeModified.getMonth()] + "-" + dateTimeModified.getFullYear()
            let newTimeModified = dateTimeModified.getHours() + ":" + dateTimeModified.getMinutes() + ":" + dateTimeModified.getSeconds();

            isp += `<tr>
            <td scope="row"> ${br++}</td>
            <td> ${i.name} </td>
            <td>  ${i.email} </td>
            <td>  ${i.subject} </td>
            <td><p class="textDesc"> ${i.message} </p></td>
            <td>  ${newDateCreated} ${newTimeCreated} </td>
            <td> ${newDateModified} ${newTimeModified} </td>
            <td> <a class="btn btn-primary updateContact" data-id="${i.cont_id}"  href="#">  Update </a> </td>
            <td> <a  class="btn btn-dark deleteContact"  data-id="${i.cont_id}" href="#"> Delete </a>  </td>
            </tr>`
        }
        $('#tableContact').html(isp);
    }


    function PagValue(url){
        $('#pagContactAdmin').on("click",".pagination_link" , function(e){
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

        $('#pagContactAdmin').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentContact(pager)
            },error: error

        })
    }


    $('#adminContactUpdateSub').click(function(e){
        e.preventDefault();

        let name = $('#adminContactUpdateName');
        let email = $('#adminContactUpdateEmail');
        let subject = $('#adminContactUpdateSubject');
        let message = $('#adminContactUpdateMessage');
        let contId = $('#hiddenAdminUpdateContId').val();
        let validstar = $('.validstarUp');
        let regName = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,13})$/;
        let regEmail = /^[\w]+[\.\_\-\w\d]*\@(gmail\.com)$/;
        let regMessage = /^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/;
        let  regSubj = /^[\w\s]{3,30}$/;
        let errorsUp = [];



        if(!regName.test(name.val())){
            errorsUp.push('Update name is not valid!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(!regEmail.test(email.val())){
            errorsUp.push('Update email is not valid!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(!regSubj.test(subject.val())){
            errorsUp.push('Update subject is not valid!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(!regMessage.test(message.val())){
            errorsUp.push('Update message is not valid!');
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }


        if(errorsUp.length != 0){
            // alert(errors);
          /*  validstar.css('display' , 'block')
            for(let i in errorsUp){
                result = '*';
                document.getElementsByClassName("validstarUp")[i].innerHTML = result;
            }*/
            let isp = ""
            isp += "<ul>"
            for(let i in errorsUp){
                isp += "<li style='color:#ff0000'>" + errorsUp[i] + "</li>"
            }
            isp += "</ul>"
            $('#errorsUpdContAdm').html(isp)

        }else{
           // validstar.css('display' , 'none')

            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                }
            });



            $.ajax({
                url:"/admin/contact/update/"+ contId,
                method:"POST",
                data:{

                    adminContactUpdateName:name.val(),
                    adminContactUpdateEmail:email.val(),
                    adminContactUpdateSubject:subject.val(),
                    adminContactUpdateMessage:message.val(),
                    hiddenAdminUpdateContId:contId,
                },
                success:function (data,status,xhr) {
                    alert('Contact is successfully updated!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



    $('#adminContactResponseSub').click(function(e){
        e.preventDefault();

        let email = document.getElementById("adminContactResponseEmail");
        let emailOpt = email.options[email.selectedIndex].value
        let message = $('#adminContactResponseMessage');
        let validstar = $('.validstarRe');
        let regMessage = /^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/;


        let errorsRe = [];


         if(emailOpt == "0"){
             errorsRe.push('Response email is not valid!');
             validstar.append("*")
         }else{
             validstar.css('display' , 'none')
         }


        if(!regMessage.test(message.val())){
            errorsRe.push('Response message is not valid!');
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }


        if(errorsRe.length != 0){
            // alert(errors);
            /*  validstar.css('display' , 'block')
              for(let i in errorsUp){
                  result = '*';
                  document.getElementsByClassName("validstarUp")[i].innerHTML = result;
              }*/
            let isp = ""
            isp += "<ul>"
            for(let i in errorsRe){
                isp += "<li style='color:#ff0000'>" + errorsRe[i] + "</li>"
            }
            isp += "</ul>"
            $('#errorsRespContAdm').html(isp)

        }else{
            // validstar.css('display' , 'none')

            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                }
            });



            $.ajax({
                url:"/admin/contact/response",
                method:"POST",
                data:{

                    adminContactResponseEmail:emailOpt,
                    adminContactResponseMessage:message.val(),
                },
                success:function (data,status,xhr) {
                    alert('Response contact message is successfully send!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



});



