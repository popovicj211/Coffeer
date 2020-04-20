$(document).ready(function() {

    $('#resmob').focus(function () {
                  $(this).val('+381 ');
        })


})
function Reservation(){

    let date = $('#resdate')
    let time = $('#restime')
    let mob = $('#resmob')
    let msg = $('#resmsg')
     let icon = $('.resValid');
  //  let regDate = /^(((1)[0-2])|[1-9])(\/)(([1-3][0-9])|[1-9])(\/)(20)[0-3][0-9]$/;
//    let regTime = /^(1[0-2]|[1-9])(\:)([0-5][0-9])([ap](m))$/
    let regMob = /^(\+381)((\s)?|(\-)?|(\/)?)(6)[0-69]((\s)?|(\-)?|(\/)?)[\d]{3}((\s)?|(\-)?|(\/)?)[\d]{3,4}$/
    let regMsg = /^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/
    let  errors = [];


    /*  if (!regDate.test(date.val())) {
          errors.push('Date is not valid!')
          icon.css('color', '#ff0000')
      } else {
          icon.css('color', '#fff')
      }

      if (!regTime.test(time.val())) {
          errors.push('Time is not validd!')
          icon.css('color', '#ff0000')
      } else {
          icon.css('color', '#fff')
      }*/

      if(date.val() == ""){
        errors.push('Date is not valid!')
        icon.css('color', '#ff0000')
    }else {
        icon.css('color', '#fff')
    }

    if(time.val() == ""){
        errors.push('Time is not valid!')
        icon.css('color', '#ff0000')
    }else {
        icon.css('color', '#fff')
    }

      if (!regMob.test(mob.val())) {
          errors.push('Mobile is not valid!')
          icon.css('color', '#ff0000')
      } else {
          icon.css('color', '#fff')
      }

      if (!regMsg.test(msg.val())) {
          errors.push('Message is not valid!')
          icon.css('color', '#ff0000')
      } else {
          icon.css('color', '#fff')
      }



    if(errors.length != 0){

        let isp = ""
        isp += "<ul>"
        for(let i in errors){
            isp += "<li style='color:#ff0000'>" + errors[i] + "</li>"
        }
        isp += "</ul>"
        $('#errorsResList').html(isp)
        return false;
    }else{
        return true;
    }


}
