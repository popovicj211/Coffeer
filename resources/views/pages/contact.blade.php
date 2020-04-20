@extends('layouts.front')

@section('title')Contact
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
    <section class="ftco-section contact-section">
        <div class="container mt-5">
            <div class="row block-9">
                <div class="col-md-4 contact-info ftco-animate">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h2 class="h4">Contact Information</h2>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p><span>Address:</span> Zdravka Celara 16</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p><span>City:</span> Belgrade </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p><span>Phone:</span> <a href="#">+381 111 1111</a></p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p><span>Email:</span> <a href="#">coffeer@gmail.com</a></p>
                        </div>

                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6 ftco-animate">
                    <form action="{{route('do-contact')}}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="contactname" class="form-control" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="contactemail" class="form-control" placeholder="Your Email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="contactsubject" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="contactmsg"  cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btncontact" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@endsection

