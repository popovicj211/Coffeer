@extends('layouts.front')

@section('title')Cart
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

    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                @if(session()->has('user'))
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">

                        <table class="table">
                            <thead class="thead-primary">
                            <tr class="text-center">
                                <th> #</th>
                                <th></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Delete </th>
                            </tr>
                            </thead>

                            @if(isset($products) && \Illuminate\Support\Facades\Session::has('cart'))
                              <tbody>

                                            @foreach($products as $product)
                                                <tr class="text-center">
                                                      <td> {{ $loop->iteration }} </td>
                                                  <!--  <td class="product-remove"><a class="deleteCart" data-id="{{--!! $cart->cart_id !!--}}" href="#"><span class="icon-close"></span></a></td> -->
                                                      <td class="image-prod"><div class="img" style="background-image:url({{ asset('images/products/'.$product['item']->link) }});"></div></td>

                                                    <td class="product-name">
                                                        <h3> {{ $product['item']->name }}</h3>
                                                        <!-- <p>Far far away, behind the word mountains, far from the countries</p> -->
                                                    </td>
                                                        <td class="price"> {{ $product['price'] }} RSD</td>
                                                    <td class="quantity">

                                                        <div   class="quantitycart text-white" > {{ $product['qty'] }}</div>

                                                    </td>
                                                    <td class="text-white"> {{ date( "d-M-Y H:i:s" , strtotime($product['item']->created)) }}</td>
                                                    <td>
                                                        <a href="{{route('deleteFromCart',['id'=>$product['item']->df_id])}}">
                                                            <i class="icon-close"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                             @endforeach

                              </tbody>
                        </table>
                             @else
                                <div class="alert alert-danger">
                                    <p> Cart is empty </p>
                                </div>
                            @endif
                    </div>
                </div>
                @else

                    <div class="alert alert-danger">
                        <p> If you want to add to cart this product , please login  </p>
                    </div>
                @endif
            </div>
            <div class="row marginlr">
                <div class="col text-center">
                    <div class="block-27" id="pagshowcart">

                    </div>
                </div>
            </div>
            @if(session()->has('user'))
            <div class="row justify-content-end">
                <div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate" id="cartTotal">
                    <div class="cart-total mb-3">
                        <h3>Cart Totals</h3>
                        <hr>
                        <p class="d-flex total-price">
                            <span>Total</span>
                            @isset($totals)
                                <span> {{ $totals }} RSD</span>
                            @endisset
                        </p>
                    </div>
                     @if(isset($products))
                        <meta name="_token" content="{{ csrf_token() }}">
                    <p class="text-center"><a type="button" href="#" id="checkoutBtn" name="checkoutBtn" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
                         @else
                        <p class="text-center"><a type="button" href="#" id="checkoutBtn" name="checkoutBtn" class="btn btn-primary py-3 px-4 disabled">Proceed to Checkout</a></p>
                       @endif
                </div>
            </div>
            @endif
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/cart.js') }}">
    </script>
@endsection
