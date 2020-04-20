<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">Coffeer<small>cafe & restaurant</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">

                @isset($menus)
                @foreach($menus as $m)
                    @if(session()->has('user'))
                            @if($m->session == session()->get('user')->role_id)
                <li class="nav-item {{ ($loop->first)? 'active' : '' }}"><a href="{{ url($m->link)}}" class="nav-link"> {{ $m->name  }} </a></li>
                            @endif
                        @elseif(!session()->has('user'))
                            @if($m->session == 2)
                                <li class="nav-item {{ ($loop->first)? 'active' : '' }}"><a href="{{ url($m->link)}}" class="nav-link"> {{ $m->name  }} </a></li>
                             @endif
                        @endif
                @endforeach
                @endisset
                    @if(session()->has('user'))
                <li class="nav-item cart" id="navcart"><a href="{{route('cart')}}" class="nav-link"><span class="icon icon-shopping_cart"></span><span class="bag d-flex justify-content-center align-items-center"><small></small></span></a></li>
                        @else
                        <li class="nav-item cart" id="navcart"><a href="{{route('cart')}}" class="nav-link"><span class="icon icon-shopping_cart"></span></a></li>
                  @endif

            </ul>
        </div>
         @if(!session()->has('user'))
        <a href="{{route('authorization')}}"  id="navregister" class="nav-link"> Register </a> |    <a href="{{route('authorization')}}" id="navlogin" class="nav-link"> Log In </a>
         @else
            <a href="{{route('logout')}}" class="nav-link"> Logout </a>
        @endif
    </div>

</nav>
<!-- END nav -->
