<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading">Discount</span>
                <h2 class="mb-4">Best Coffee Sellers</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
        </div>
        <div class="row" id="discountDf">
            @isset($discount)
                @foreach($discount as $value)
                    <div  class="blockdf">
                        <div class="discount">{{ $value->percent }}%</div>
                        <img  class="blockSize" src="{{asset('images/products/'.$value->link)}}" alt="{{ $value->alt }}" />
                        <div class="text text-center pt-4">
                            <h3><a href="#">  {{$value->name}} </a></h3>
                            <p> {{ $value->desc }} </p>
                            @if( $value->newprice != null)
                                <p class="price"><span> {{  $value->newprice }} RSD </span></p>
                                <p class="price"><small>  <del>{{  $value->price }} </del>RSD </small></p>
                            @else
                                <p class="price"><span> {{  $value->price }} RSD</span></p>
                            @endif
                            @if(session()->has('user'))
                            <p><a href="{{  route("singleproduct", ["sp" => $value->df_id])  }}" class="btn btn-primary btn-outline-primary">Details</a></p>
                             @endif
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27" id="discountPag">

                    @if ($discount->lastPage() > 1)
                        <ul >
                            <li class="{{ ($discount->currentPage() == 1) ? ' disabled' : '' }}">
                                <a href="{{ $discount->url(1) }}">Prev</a>
                            </li>
                            @for ($i = 1; $i <= $discount->lastPage(); $i++)
                                <li class="{{ ($discount->currentPage() == $i) ? ' active' : '' }}">
                                    <a href="{{ $discount->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="{{ ($discount->currentPage() == $discount->lastPage()) ? ' disabled' : '' }}">
                                <a href="{{ $discount->url($discount->currentPage()+1) }}" >Next</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


