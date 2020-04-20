$(document).ready(function(){
    const baseUrl = window.location.origin;
 //   window.addEventListener('load' , showCat)

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


    showCat()
    function showCat(){
        let url = baseUrl + '/drinkfood/show/category'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {
                console.log(data.data)
                let catData = data.data
                let isp = ""
                  isp += `<div  class="nav nav-pills justify-content-center"  >`
                    for(let i of catData){
                 isp +=  `<a class="nav-link "  data-id="${i.cat_id}" href="#" > ${i.name} </a>`
                    }
                   isp += `</div>`
                    $('#categoryDf').html(isp)

                $('#categoryDf div').on("click","a" , filter)
            },
            error: error

        })

            // $('#categoryDf a').click(filter)
    }



    getDFs()


function filter(e) {
           e.preventDefault()
    let type = $(this).data("id");
    getCatDFs(type)
    }



    function getDFs() {
        let url = baseUrl + '/drinkfood/show'
        $.ajax({
            url: url,
            method: 'get',
            success: function (data) {

                contentGetDFs(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }

    function getCatDFs(cat) {
        var url = baseUrl + '/drinkfood/show/filter'
        $.ajax({
            url: url,
            method: 'get',
            data:{
                 cat:cat
            },
            success: function (data) {

                contentGetDFs(data)
                pagLinks(data)

                PagValue(url)
            },
            error: error

        })


    }



    function contentGetDFs(data) {
        let dataDf = data.data
        let isp = ""
        let session = data.session
        for (let i of dataDf) {
            let img = baseUrl + "/images/products/" + i.link
            let loc = baseUrl + "/singleproduct/" + i.df_id
            isp += `<div  class="blockdf">`
                                 if(i.newprice != null) {
                                     isp += `<div class="discount">${i.percent}%</div>`
                                 }
                              isp +=  `<img class="blockSize" src="${img}" alt="${i.alt}" />
                                   <div class="text text-center pt-4">
                                            <h3><a href="#"> ${i.name} </a></h3>
                                              <p> ${i.desc} </p>`
            if (i.newprice != null) {
                isp += `<p class="price"><span> ${i.newprice} RSD </span></p>
                                               <p class="price"><small>  <del>${i.price} </del>RSD </small></p>`
            } else {
                isp += `<p class="price"><span> ${i.price} RSD</span></p>`
            }
                isp += `<p><a href="${loc}" class="btn btn-primary btn-outline-primary">Details</a></p>`

            isp += `</div>
                   </div>`
        }
        $('#Dfs').html(isp);
    }


    function PagValue(url){
        $('#dfPag').on("click",".pagination_link" , function(e){
            e.preventDefault()
            let numb = $(this).data("value");

            pag(numb , url)


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

        $('#dfPag').html(isp);


    }


    function pag(numb , url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data : { numb : numb},
            success:function(data){
                let pager = data
                contentGetDFs(pager)
            },error: error

        })
    }


});


