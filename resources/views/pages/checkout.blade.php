@extends('layouts.front')

@section('title') Checkout
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

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <form action="{{ route('do-checkout') }}" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
                     @csrf
                    <div class="col-xl-12 ftco-animate">
                        <div class="col-xl-8 ftco-animate float-left">
                            <h3 class="mb-4 billing-heading">Billing Details</h3>
                            <div class="row align-items-end">
                                <!--    <div class="w-100" ></div> -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="country">City</label>
                                        <div class="select-wrap">
                                            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                            <select name="city" id="city" class="form-control" >
                                                <option value="0">Select</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->city_id }}"> {{ $city->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--   <div class="w-100"></div> -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="streetaddress">Street Address</label>
                                        <input type="text"  name="street"  id="street" class="form-control" placeholder="Zdravka Celara 16">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Place</label>
                                        <div class="select-wrap">
                                            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                            <select name="place" id="place" class="form-control">
                                                <option value="0">Select</option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->plc_id }}"> {{ $place->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postcodezip">Postcode / ZIP (BG or NS) </label>
                                        <input type="text" name="postcode" id="postcode" class="form-control" placeholder="*****">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="mobile"  name ="mobile" class="form-control" placeholder="06* *** ****">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sidebar-box ftco-animate cart-detail ftco-bg-dark float-right">

                            <h3 class="billing-heading mb-4">Type of credit card</h3>
                            @foreach($paymethod as $pay)
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input type="radio" name="paymethod" value="{{ $pay->pa_id }}" class="mr-2"> {{ $pay->name }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label for="creditcardnumb">Credit card number</label>
                                <input type="text" name="creditcardnumber" id="creditcardnumber" class="form-control" placeholder="**** **** **** ****">
                            </div>
                            <button type="submit" name="btncheckout" id="btncheckout" class="btn btn-primary py-3 px-5"  > Place an order</button>
                        </div>
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
    </section>

@endsection
