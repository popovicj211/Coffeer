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

    $('#adminResAddMobile').focus(function () {
        $(this).val('+381 ');
    })


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
        $('#updateAdmRes').css('display','none')
        $('#updateHeaderRes').css('display' , 'none')
    }




    $('#tableResservation').on("click" ,"tr td .updateRes", function(e){
        e.preventDefault();
        $('#updateAdmRes').show()
        $('#updateHeaderRes').show()
        let id = $(this).data('id');

        $.ajax({
            method: 'get',
            url: baseUrl + "/admin/reservation/edit/" + id,
            dataType: 'json',
            success: function(data,status,xhr){

                let datetime = data.data.date
                let newDatetime = datetime.split(" ");

                console.log(data)
                console.log(xhr.status)
                $('#adminResUpUser').val(data.data.user_id);
                $('#adminResUpDate').val(newDatetime[0]);
                $('#adminResUpTime').val(newDatetime[1]);
                $('#adminResUpMobile').val(data.data.mobile);
                $('#adminResUpMessage').val(data.data.message);
                $('#hiddenAdminUpResId').val(data.data.res_id);
            },
            error: error
        });


    })


    $('#tableResservation').on("click" ,"tr td .deleteRes", function(e){
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
            url: baseUrl + "/admin/reservation/delete/" + id,
            dataType: 'json',
            success: function(data,status,xhr){
                alert('Reservation is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });



    getResAdmin()

    function getResAdmin() {
        let url = baseUrl + '/admin/reservation/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) { console.log(data)
                contentRes(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }




    function contentRes(data) {
        let dataR = data.data
        let isp = ""
        let br = 1;
        for (let i of dataR) {

            let dateTimeCreated = new Date(i.created)
            let month = ["Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Okt" , "Nov" ,"Dec"]
            let newDateCreated = dateTimeCreated.getDate() + "-" + month[dateTimeCreated.getMonth()] + "-" + dateTimeCreated.getFullYear()
            let newTimeCreated = dateTimeCreated.getHours() + ":" + dateTimeCreated.getMinutes() + ":" + dateTimeCreated.getSeconds();
            let dateTimeModified = new Date(i.modified)
            let newDateModified = dateTimeModified.getDate() + "-" + month[dateTimeModified.getMonth()] + "-" + dateTimeModified.getFullYear()
            let newTimeModified = dateTimeModified.getHours() + ":" + dateTimeModified.getMinutes() + ":" + dateTimeModified.getSeconds();

            let dateTimeRes = new Date(i.date)
            let dateRes = dateTimeRes.getDate() + "-" + month[dateTimeRes.getMonth()] + "-" + dateTimeRes.getFullYear()
            let  timeRes = dateTimeRes.getHours() + ":" + dateTimeRes.getMinutes() ;

            isp += `<tr>
            <td scope="row"> ${br++}</td>
            <td> ${i.name} </td>
            <td>  ${i.email}</td>
             <td>  ${dateRes} ${timeRes}</td>
              <td>  ${i.mobile} </td>
            <td><p class="textDesc"> ${i.message} </p></td>
            <td>  ${newDateCreated} ${newTimeCreated} </td>
            <td> ${newDateModified} ${newTimeModified} </td>
            <td> <a class="btn btn-primary updateRes" data-id="${i.res_id}"  href="#">  Update </a> </td>
            <td> <a  class="btn btn-dark deleteRes"  data-id="${i.res_id}" href="#"> Delete </a>  </td>
            </tr>`
        }
        $('#tableResservation').html(isp);
    }


    function PagValue(url){
        $('#pagResAdmin').on("click",".pagination_link" , function(e){
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

        $('#pagResAdmin').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentRes(pager)
            },error: error

        })
    }


    $('#adminResUpSub').click(function(e){
        e.preventDefault();

        let user = document.getElementById('adminResUpUser');
         let userOpt = user.options[user.selectedIndex].value;
        let date = $('#adminResUpDate');
        let time = $('#adminResUpTime');
        let mob = $('#adminResUpMobile');
        let message = $('#adminResUpMessage');
        let resId = $('#hiddenAdminUpResId').val();
        let validstar = $('.validstarUp');

        let regMob = /^(\+381)((\s)|(\-)|(\/))?(6)[0-69]((\s)|(\-)|(\/))?[\d]{3}((\s)|(\-)|(\/))?[\d]{3,4}$/;
        let regMessage  = /^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/;
        let errorsUp = [];


        if(userOpt == "0"){
            errorsUp.push('Update user is not valid!')
            validstar.append("*")
        }else {
            validstar.css('display' , 'none')
        }

        if(date == ""){
            errorsUp.push('Update date is not valid!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(time == ""){
            errorsUp.push('Update time is not valid!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(!regMob.test(mob.val())){
            errorsUp.push('Update mobile is not valid!')
            validstar.append("*")
        }else{
            validstar.css('display' , 'none')
        }

        if(!regMessage.test(message.val())){
            errorsUp.push('Update message is not valid!')
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
            $('#errorsUpdResAdm').html(isp)

        }else{
            // validstar.css('display' , 'none')

            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                }
            });



            $.ajax({
                url:"/admin/reservation/update/"+ resId,
                method:"POST",
                data:{

                    adminResUpUser:userOpt,
                    adminResUpDate:date.val(),
                    adminResUpTime:time.val(),
                    adminResUpMobile:mob.val(),
                    adminResUpMessage:message.val(),
                    hiddenAdminUpResId:resId,
                },
                success:function (data,status,xhr) {
                    alert('Reservation is successfully updated!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



    $('#adminResResponseSub').click(function(e){
        e.preventDefault();

        let email = document.getElementById("adminResResponseEmail");
        let emailOpt = email.options[email.selectedIndex].value
        let message = $('#adminResResponseMessage');
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
                url:"/admin/reservation/response",
                method:"POST",
                data:{

                    adminResResponseEmail:emailOpt,
                    adminResResponseMessage:message.val(),
                },
                success:function (data,status,xhr) {
                    alert('Response reservation message is successfully send!')
                    console.log(xhr.status);
                },
                error: error
            });
        }

    });



});

