$(document).ready(function(){
    const baseUrl = window.location.origin;
    var url = baseUrl + '/discount/show'
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


    getDiscountDFs()


    function getDiscountDFs() {

        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {
                console.log(data)
                contentGetDiscountDFs(data)
                pagLinks(data)

                PagValue()
            },
            error: error

        })


    }


    function contentGetDiscountDFs(data) {
          let dataDf = data.data
        let isp = ""
        let session = data.session
        for (let i in dataDf) {
            let img = baseUrl + "/images/products/" + dataDf[i].link
            let loc = baseUrl + "/singleproduct/" + dataDf[i].df_id
            isp += `<div  class="blockdf">
                                 <div class="discount">${dataDf[i].percent}%</div>
                                  <img class="blockSize" src="${img}" alt="${dataDf[i].alt}" />
                                   <div class="text text-center pt-4">
                                            <h3><a href="#"> ${dataDf[i].name} </a></h3>
                                              <p> ${dataDf[i].desc} </p>`
                                              if (dataDf[i].newprice != null) {
                                              isp += `<p class="price"><span> ${dataDf[i].newprice} RSD </span></p>
                                               <p class="price"><small>  <del>${dataDf[i].price} </del>RSD </small></p>`
                                                } else {
                                                  isp += `<p class="price"><span> ${dataDf[i].price} RSD</span></p>`
                                                 }
                                                 if (session != null) {
                                                            isp += `<p><a href="${loc}" class="btn btn-primary btn-outline-primary">Details</a></p>`
                                                      }
                                                     isp += `</div>
                   </div>`
            }
            $('#discountDf').html(isp);
        }


    function PagValue(){
        $('#discountPag').on("click",".pagination_link" , function(e){
            e.preventDefault()
            let numb = $(this).data("value");

            pag(numb)


        })
    }


    function pagLinks(data){
        var br = data.count
        var countPerPage = 3
        var countMatches = parseInt(br);
        var countLink = (Math.ceil(countMatches / countPerPage));
        var isp = '';

        isp +=  '<ul>'
        for(var i = 1; i <= countLink ; i++) {
            //  for(let i = countLink; i >= 1; i--){

            isp += '<li ><a class="pagination_link"  data-value="' + i + '" href="#">' + i + '</a></li>';
        }
        isp += '</ul>'

        $('#discountPag').html(isp);


    }


    function pag(numb){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentGetDiscountDFs(pager)
            },error: error

        })
    }


});

