
//initMap()
function initMap() {
    var location = {lat: 44.815178, lng: 20.4847208 };

    var map = new google.maps.Map(document.getElementById('map'),
        {
            zoom: 17,
            center: location
        });

    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
}
