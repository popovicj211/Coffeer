@extends('layouts.front')

@section('title')Single product
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
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="{{ asset('images/products/'. $singleproduct->link) }}"  class="image-popup"><img  src="{{asset('images/products/'.$singleproduct->link)}}"  class="img-fluid" alt="{{ $singleproduct->alt}}"></a>
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3> {{  $singleproduct->name }}</h3>
                    @if( $singleproduct->newprice != null)
                        <p class="price"><span> {{  $singleproduct->newprice }} RSD </span></p>
                        <p class="price"><small><del> {{  $singleproduct->price }} </del>RSD</small></p>
                    @else
                        <p class="price"><span> {{  $singleproduct->price }} RSD</span></p>
                    @endif
                    <p> {{  $singleproduct->desc }} </p>

                    <form>
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="row mt-4">
                            <div class="w-100"></div>
                            <div class="input-group col-md-6 d-flex mb-3">
	             	<span class="input-group-btn mr-2">
	                	   <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
	                                 <i class="icon-minus"></i>
	                	    </button>
                    </span>
                                 <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">

                                <span class="input-group-btn ml-2">
	                          	<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
	                             <i class="icon-plus"></i>
	                            </button>
	             	</span>
                            </div>
                        </div>
                        <input type="hidden" name="dfsingleproduct" id="dfsingleproduct" value="{{ $singleproduct->df_id }}" />
                        @if(session()->has('user'))
                            <input type="hidden" name="usrsingleproduct" id="usrsingleproduct" value="{{ session()->get('user')->user_id }}" />
                            <a type="button" href="#" name="btnaddtocart" id="btnaddtocart" class="btn btn-primary py-3 px-5"  > Add to Cart</a>
                            @else
                            <a type="submit" href="#" name="btnaddtocart2" id="btnaddtocart2" class="btn btn-primary py-3 px-5 disabled"  > Add to Cart</a>
                            <div class="alert alert-danger marginlr">
                                <p> If you want to add to cart this product , please login  </p>
                            </div>
                    @endif
                    <!--   <input type="hidden" name="usrsingleproduct" id="usrsingleproduct" value="1" /> -->


                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/singleproduct.js') }}">
    </script>
@endsection
