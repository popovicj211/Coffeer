$(document).ready(function(){
    const baseUrl = window.location.origin;

  /*  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
   */


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
            case 409:
                alert("Email address exist!");
            default:
                alert("Error: " + status + " - " + statusTxt);
                break;
        }
    }



    $('#adminUserUpdateSub').click(function(){

           let name = $('#adminUserUpdateName')
           let username = $('#adminUserUpdateUsername')
           let email = $('#adminUserUpdateEmail')
           let pass = $('#adminUserUpdatePass')
           let role = $('#adminUserUpdateRole')
           let roleOption = $('#adminUserUpdateRole option:selected')
           let active = $('#adminUserUpdateActive')
           let regName = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,15})+$/
           let regUsrName = /^[\.\_\-\w\d\@]{3,15}$/
           let regEmail = /^[\w]+[\.\_\-\w\d]*\@(gmail\.com)$/
           let regPass = /^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/
           let userId = $('#hiddenAdminUsrUpdateUserId')
           let validstar = $('.validstarUp')
           let method = $('#methodp').val()

           let errorsUp = [];
            let withoutPass = "";
           if(!regName.test(name.val())){
               errorsUp.push('Update name is not valid!')
            //   $('').css('display' , 'block')
           }
           if(!regUsrName.test(username.val())){
               errorsUp.push('Update username is not valid!')

           }

           if(!regEmail.test(email.val())){
               errorsUp.push('Update email is not valid!')

           }

           if(pass.val() == ''){
                    withoutPass = true
           }else{
                   withoutPass = false
               if(!regPass.test(pass.val())){
                   errorsUp.push('Update password is not valid!')

               }
           }

           let valList = ""
           $(roleOption ).each(function(){
               valList = $(this).val();
           });

           if(valList == "0"){
               errorsUp.push('Role for update is not selected!')

           }
           if (!active.is(":checked")) {
               errorsUp.push('Active for update is not checked!')
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
               $('#errorsUpdUsrAdm').html(isp)

           }else{
               validstar.css('display' , 'none')

               $.ajaxSetup({
                   headers : {
                       "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                   }
               });

               if(withoutPass == true){

                   $.ajax({
                       url:"/admin/users/update/"+ userId.val(),
                       method:"POST",
                       data:{
                           hiddenAdminUsrUpdateUserId:userId.val(),
                           adminUserUpdateName:name.val(),
                           adminUserUpdateUsername:username.val(),
                           adminUserUpdateEmail:email.val(),
                           adminUserUpdateRole:valList,
                           adminUserUpdateActive:active.val(),
                           adminUserUpdateSub:true,
                           _method:method
                       },
                       success:function (data,status,xhr) {
                           alert('User is successfully updated!')
                           console.log(xhr.status);
                       },
                       error: error
                   });

               }else {

                   $.ajax({
                       url:"/admin/users/update/"+ userId.val(),
                       method:"POST",
                       data:{
                           hiddenAdminUsrUpdateUserId:userId.val(),
                           adminUserUpdateName:name.val(),
                           adminUserUpdateUsername:username.val(),
                           adminUserUpdateEmail:email.val(),
                           adminUserUpdatePass:pass.val(),
                           adminUserUpdateRole:valList,
                           adminUserUpdateActive:active.val(),
                           adminUserUpdateSub:true,
                           _method: method
                       },
                       success:function (data,status,xhr) {
                           alert('User is successfully updated!')
                           console.log(xhr.status);
                       },
                       error: error
                   });

               }




           }

       });



    let yes = "Yes";
    let no = "No"

    HideUpdate()
    function HideUpdate(){
        $('#updateAdmUser').css('display','none')
    }


/*
    function getUpUsersAdmin() {
        let url = baseUrl + ''
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {

            },
            error: error

        })


    }
*/


       $('#tableUsers').on("click" ,"tr td .updateUser", function(e){
            e.preventDefault();
           $('#updateAdmUser').show()
            var id = $(this).data('id');

            console.log(id)
           $.ajax({
                method: 'get',
                url: baseUrl + "/admin/users/edit/" + id,
                dataType: 'json',
                success: function(data,status,xhr){
                    let act = $('input[name="adminUserUpdateActive"]')
                    console.log(data)
                    console.log(xhr.status)
                    $('#adminUserUpdateName').val(data.data.name);
                    $('#adminUserUpdateUsername').val(data.data.username);
                    $('#adminUserUpdateEmail').val(data.data.email);
                    act.removeAttr('checked');
                    if(data.data.active == 1){
                        act.prop('checked',true);
                        act.val(data.data.active);
                    }
                    $('#adminUserUpdateRole').val(data.data.role_id);
                    $('#hiddenAdminUsrUpdateUserId').val(data.data.user_id);
                },
                error: error
            });


        })


    $('#tableUsers').on("click" ,"tr td .deleteUser", function(e){
            e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });
        console.log(id)
        $.ajax({
            method: 'DELETE',
            url: baseUrl + "/admin/users/delete/" + id,
            dataType: 'json',
            success: function(data,status,xhr){
                     alert('User is successfully deleted!')
                location.reload();
            },
            error: error
        });

    });




    getUsersAdmin()

    function getUsersAdmin() {
        let url = baseUrl + '/admin/users/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {

                contentUsers(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }




    function contentUsers(data) {
        let dataUsr = data.data
        let isp = ""
        let br = 1;
        for (let i of dataUsr) {
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
            <td> ${i.username}</td>
            <td>  ${i.email} </td>
            <td>  ${newDateCreated} ${newTimeCreated} </td>
            <td> ${newDateModified} ${newTimeModified} </td>`
        if(i.active == 1) {
            isp += `<td> ${yes} </td>`
        }else{
       isp += `<td> ${no}</td>`
       }
       isp += `<td>  ${i.rolename} </td>
            <td> <a class="btn btn-primary updateUser" data-id="${i.user_id}"  href="#">  Update </a> </td>
            <td> <a  class="btn btn-dark deleteUser"  data-id="${i.user_id}" href="#"> Delete </a>  </td>
            </tr>`
        }
        $('#tableUsers').html(isp);
    }


    function PagValue(url){
        $('#pagUserAdmin').on("click",".pagination_link" , function(e){
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

        $('#pagUserAdmin').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentUsers(pager)
            },error: error

        })
    }


});


function addUsersAdminValidation(){

    let name = $('#adminUserAddName')
    let username = $('#adminUserAddUsername')
    let email = $('#adminUserAddEmail')
    let pass = $('#adminUserAddPass')
    let role = $('#adminUserAddRole')
    let roleOption = $('#adminUserAddRole option:selected')
    let active = $('#adminUserAddActive')
    let regName = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,15})+$/
    let regUsrName = /^[\.\_\-\w\d\@]{3,15}$/
    let regEmail = /^[\w]+[\.\_\-\w\d]*\@(gmail\.com)$/
    let regPass = /^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/

    let  errors = [];

    if(!regName.test(name.val())){
        errors.push('Added name is not valid!')
    }
    if(!regUsrName.test(username.val())){
        errors.push('Added username is not valid!')
    }

    if(!regEmail.test(email.val())){
        errors.push('Added email is not valid!')
    }
    if(!regPass.test(pass.val())){
        errors.push('Added password is not valid!')
    }

    let valList = ""
    $(roleOption ).each(function(){
        valList = $(this).val();
    });

    if(valList == "0"){
        errors.push('Role is not selected!')
    }
    if (!active.is(":checked")) {
           errors.push('Active is not checked!')
    }
    if(errors.length != 0){
        // alert(errors);
        for(let i in errors){
            result = '*';
            document.getElementsByClassName("validstar")[i].innerHTML = result;
        }
       let isp = ""
        isp += "<ul>"
        for(let i in errors){
            isp += "<li style='color:#ff0000'>" + errors[i] + "</li>"
        }
        isp += "</ul>"
         $('#errorsInsUsrAdm').html(isp)
        return false;
    }else{
        return true;
    }

}
