
@extends('layouts.front')

@section('title')Menu
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
    <section class="ftco-menu mb-5 pb-5">
        <div class="container">
            <div class="row d-md-flex">
                <div class="col-lg-12 ftco-animate p-md-5">
                    <div class="row">
                        <div class="row justify-content-center mb-5 pb-3">
                            <div class="col-md-7 heading-section ftco-animate text-center">
                                <span class="subheading">So tasty</span>
                                <h2 class="mb-4">OUR MENU</h2>
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                            </div>
                        </div>
                        <div class="col-md-12 nav-link-wrap mb-5" id="categoryDf">
                            <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical" >

                                @isset($categories)
                                    @foreach($categories as $cat)
                                        <a class="nav-link " id="v-pills-{{$loop->index}}-tab" data-id="{{ $cat->cat_id  }}" href="{{ route("menufilter", ["cat" => $cat->cat_id]) }}" > {{$cat->name}} </a>
                                    @endforeach
                                @endisset


                            </div>
                        </div>
                    </div>
                    <div class="row" id="Dfs">

                        @isset($drinks)
                            @foreach($drinks as $f)
                                <div class="blockdf" >
                                    @if($f->dis_id != null)
                                        <div class="discount">{{ $f->percent }}%</div>
                                    @endif
                                    <img class="blockSize" src="{{asset('images/products/'.$f->link)}}" alt="{{ $f->alt }}" />
                                    <div class="text text-center pt-4">
                                        <h3><a href="#">  {{$f->name}} </a></h3>
                                        <p> {{ $f->desc }} </p>

                                        @if( $f->newprice != null)
                                            <p class="price"><span> {{  $f->newprice }} RSD </span></p>
                                            <p class="price"><small>  <del>{{  $f->price }} </del>RSD </small></p>
                                        @else
                                            <p class="price"><span> {{  $f->price }} RSD</span></p>
                                        @endif
                                        <p><a href="{{  route("singleproduct", ["sp" => $f->df_id])  }}" class="btn btn-primary btn-outline-primary">Details</a></p>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                    <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27" id="dfPag">
                                <!--   <ul>
                                       <li><a href="#">&lt;</a></li>
                                       <li class="active"><span>1</span></li>
                                       <li><a href="#">2</a></li>
                                       <li><a href="#">3</a></li>
                                       <li><a href="#">4</a></li>
                                       <li><a href="#">5</a></li>
                                       <li><a href="#">&gt;</a></li>

                                   </ul> -->
                                @if ($drinks->lastPage() > 1)
                                    <ul >
                                        <li class="{{ ($drinks->currentPage() == 1) ? ' disabled' : '' }}">
                                            <a href="{{ $drinks->url(1) }}">Prev</a>
                                        </li>
                                        @for ($i = 1; $i <= $drinks->lastPage(); $i++)
                                            <li class="{{ ($drinks->currentPage() == $i) ? ' active' : '' }}">
                                                <a href="{{ $drinks->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="{{ ($drinks->currentPage() == $drinks->lastPage()) ? ' disabled' : '' }}">
                                            <a href="{{ $drinks->url($drinks->currentPage()+1) }}" >Next</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection


@section('script')
    <script type="text/javascript" src="{{asset('js/pages/drinkfood.js')}}" ></script>
    @if(session()->has('verifymsg'))
    <script type="text/javascript">
        alert('{{ session()->get('verifymsg') }}')
    </script>
    @endif
@endsection

{{     session()->forget('verifymsg') }}




