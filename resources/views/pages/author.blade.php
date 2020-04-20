@extends('layouts.front')

@section('title')Author
@endsection
@section('slider')

    @if(isset($menusname))
        @component('components.slider.slide' , [
                     "slide" => $slide , "menusname" => $menusname
        ]) @endcomponent
    @else
        @component('components.slider.slide' , [
               "slide" => $slide
  ]) @endcomponent
    @endif

@endsection

@section('content')
    <section class="ftco-about d-md-flex">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="{{asset('images/author.jpg')}}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 pl-md-5 marginlr">
                    <h2 class="text-black">About me</h2>
                    <p class="lead">I am a student of a ICT College of Vocational Studies in Belgrade.
                        This site about cafe and restaurant, where users can see details about foods end drinks they can shopping that on the web.
                    </p>

                    <table class="table">
                        <tr>
                            <td scope="col"> Student: Jovan Popović</td>
                        </tr>
                        <tr>
                            <td scope="col"> College: ICT College of Vocational Studies  </td>
                        </tr>
                        <tr>
                            <td scope="col"> City: Belgrade </td>
                        </tr>
                        <tr>
                            <td scope="col"> Country: Serbia </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

