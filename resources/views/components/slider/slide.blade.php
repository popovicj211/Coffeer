<div class="slider-item" style="background-image: url({{asset('images/'.$slide->link)}});" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
                @isset($menusname)
                <h1 class="mb-3 mt-5 bread">{{ $menusname->name }}</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home</a></span> <span>  {{ $menusname->name }}</span></p>
                  @endisset
            </div>

        </div>
    </div>
</div>
