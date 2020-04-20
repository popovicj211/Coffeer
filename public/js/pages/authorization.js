$(document).ready(function(){
    hideRegister()
    $('#registerlink').click(showRegister)
    $('#loginlink').click(showLogin)

    function hideRegister() {
              $('#registerblock').hide()
        $('#loginnow').hide()
    }

    function showRegister(e) {
        e.preventDefault();
        $('#registerblock').fadeIn();
        $('#loginnow').fadeIn();
        $('#createaccount').fadeOut();
        $('#loginblock').fadeOut();
    }
    function showLogin(e) {
        e.preventDefault();
        $('#registerblock').fadeOut();
        $('#loginnow').fadeOut();
        $('#createaccount').fadeIn();
        $('#loginblock').fadeIn();
    }

 /*   let p =  window.location.origin ;
    let pr = window.location.pathname ;
    let prs  = window.location.href ;
   let t = prs.split('/');
    console.log(p);
    console.log(pr);
    console.log(t)*/
});

function  register() {

    let name = $('#name')
    let username = $('#username')
    let email = $('#email')
    let password = $('#password')
    let regName = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,15})+$/
    let regUsrname = /^[\.\_\-\w\d\@]{3,15}$/
    let regEmail = /^[\w]+[\.\_\-\w\d]*\@(gmail\.com)$/
    let regPass = /^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/
    let icon = $('.validreg')
     let errors = [];
      if(!regName.test(name.val())){
             icon.css('color' , '#ff0000')
          errors.push('Name is not valid!')
      }else{
          icon.css('color' , '#fff')
      }
    if(!regUsrname.test(username.val())){
        icon.css('color' , '#ff0000')
        errors.push('Username is not valid!')
    }else{
        icon.css('color' , '#fff')
    }
    if(!regEmail.test(email.val())){
        icon.css('color' , '#ff0000')
        errors.push('Email is not valid!')
    }else{
        icon.css('color' , '#fff')
    }
    if(!regPass.test(password.val())){
        icon.css('color' , '#ff0000')
        errors.push('Password is not valid!')
    }else{
        icon.css('color' , '#fff')
    }
    if(errors.length != 0){
        let isp = ""
        isp += "<ul>"
        for (let i in errors){
            isp += "<li style='color:#ff0000'>" + errors[i] + "</li>"
        }
        isp += "</ul>"
        $('#listregerrors').html(isp)
        return false;
    }else{
        return true;
    }
}

function login() {

    let username = $('#loginusername')
    let password = $('#loginpassword')
    let regUsrname = /^[\.\_\-\w\d\@]{3,15}$/
    let regPass = /^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/
    let icon = $('.validlog')

   let errors = [];

    if(!regUsrname.test(username.val())){
        icon.css('color' , '#ff0000')
        errors.push('Username is not valid!')
    }else{
        icon.css('color' , '#fff')
    }
    if(!regPass.test(password.val())){
        icon.css('color' , '#ff0000')
        errors.push('Password is not valid!')
    }else{
        icon.css('color' , '#fff')
    }
    if(errors.length != 0){
        let isp = ""
        isp += "<ul>"
        for (let i in errors){
          isp += "<li style='color:#ff0000'>" + errors[i] + "</li>"
        }
        isp += "</ul>"
        $('#listlogerrors').html(isp)
        return false;
    }else{
        return true;
    }
}
