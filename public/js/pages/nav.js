$(document).ready(function(){
    const baseUrl = window.location.origin;
    var url = baseUrl + '/nav/cart'
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


    getCartNav()

    function getCartNav() {
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {
                contentCartNav(data)
           
            },
            error: error

        })


    }

    function contentCartNav(data) {
        let isp = ""
        let navdata = data.data
        let loc = baseUrl + "/cart"
              if(data.session != null)
         isp = `<a href="${loc}" class="nav-link"><span class="icon icon-shopping_cart"></span><span class="bag d-flex justify-content-center align-items-center"><small>${navdata}</small></span></a>`
             else
                   isp = `<a href="${loc}" class="nav-link"><span class="icon icon-shopping_cart"></span></a>`

        $('#navcart').html(isp);
    }





});
