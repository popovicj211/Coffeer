<footer class="ftco-footer ftco-section img">
    <div class="overlay"></div>
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">About Us</h2>
                    <p>Coffeer is a cafe and restaurant offering delicious fast food and relaxing coffee. We are located at 16 Zdravka Celara street in Belgrade.</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                        <li class="ftco-animate"><a href="https://twitter.com/"><span class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.facebook.com/"><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.instagram.com/"><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Recent Blog</h2>
                    <div class="block-21 mb-4 d-flex">
                        <a class="blog-img mr-4" style="background-image: url({{asset('images/image_1.jpg')}});"></a>
                        <div class="text">
                            <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="icon-calendar"></span> Sept 15, 2018</a></div>
                                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-21 mb-4 d-flex">
                        <a class="blog-img mr-4" style="background-image: url({{asset('images/image_2.jpg')}});"></a>
                        <div class="text">
                            <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="icon-calendar"></span> Sept 15, 2018</a></div>
                                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-5 mb-md-5">
                <div class="ftco-footer-widget mb-4 ml-md-4">
                    <h2 class="ftco-heading-2">Pages</h2>
                    <ul class="list-unstyled">
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
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Contact</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="footericon icon-map-marker"></span><span class="text">Zdravka Celara 16,Belgrade , Serbia</span></li>
                            <li><a href="#"><span class="footericon icon-phone"></span><span class="text">+381 111 1111</span></a></li>
                            <li><a href="#"><span class="footericon icon-envelope"></span><span class="text">coffeer@gmail.com</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

          @include('components.footer.copyright')
    </div>
</footer>
