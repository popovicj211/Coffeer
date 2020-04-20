
@extends('layouts.front')

@section('title')Home
    @endsection

@section('slider')
    @component('components.slider.slider' , [
                  "slides" => $slides
    ]) @endcomponent

@endsection

@section('content')

              @component('components.home.reservation') @endcomponent
              @component('components.home.bestcoffee' , [
                       "discount" => $discount
]) @endcomponent
              @component('components.home.services') @endcomponent
              @component('components.home.numbers') @endcomponent
              @component('components.about.about') @endcomponent
              @component('components.home.contact') @endcomponent
@endsection

@section('script')

    <script src="{{ asset('js/pages/discountdf.js') }}" type="text/javascript" ></script>
     <script type="text/javascript" src="{{asset('js/pages/reservation.js')}}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXAp3giH_ocpIODOLn0nnmcKNnB5y9aTU&callback=initMap"
            type="text/javascript"></script>

    <script type="text/javascript" >
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

    </script>
@endsection
