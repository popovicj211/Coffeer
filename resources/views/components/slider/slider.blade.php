@isset($slides)
    @foreach($slides as $slide)
        <div class="slider-item" style="background-image: url({{asset('images/'.$slide->link)}});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-md-8 col-sm-12 text-center ftco-animate">
                        <span class="subheading">Welcome</span>
                        <h1 class="mb-4">{{ $slide->name }}</h1>
                        <p class="mb-4 mb-md-5">{{ $slide->text }}</p>
                        <p> <a href="{{route('menu')}}" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endisset



