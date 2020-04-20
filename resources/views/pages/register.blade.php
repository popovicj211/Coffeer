@extends('layouts.user')

@section('title')Register
@endsection

@section('content')

        <section class=" marginlr">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_box_img" id="loginnow">
                            <div class="hover">
                                <h4>Already have an account?</h4>
                                <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                                <a class="button button-account" id="loginlink" href="#">Login Now</a>
                            </div>
                        </div>

                        <h2> {{ session()->get('verify') }}</h2>
                        <div class="login_form_inner" id="loginblock">
                            <h3>Log in to enter</h3>
                            <form class="row login_form" method="POST" action="{{ route('do-login') }}" onsubmit="return login()" id="login_form" >
                                <div class="col-md-12 form-group">
                                    @csrf
                                </div>
                                <div class="col-md-12 form-group">
                                    <span class="icon-user mr-3 icon validlog"> </span>
                                    <input type="text" class="form-control" id="loginusername" name="loginusername" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
                                </div>
                                <div class="col-md-12 form-group">
                                    <span class="icon-lock mr-3 icon validlog"></span>
                                    <input type="password" class="form-control" id="loginpassword" name="loginpassword" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                </div>

                                <div class="col-md-12 form-group">
                                    <button type="submit" name="btnlogin"  class=" w-100 btn-outline-primary">Log In</button>

                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger ">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div id="listlogerrors"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login_box_img" id="createaccount">
                            <div class="hover">
                                <h4>New to our website?</h4>
                                <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                                <a class="button button-account" id="registerlink" href="#">Create an Account</a>
                            </div>
                        </div>
                        <div class="login_form_inner register_form_inner" id="registerblock">
                            <h3>Create an account</h3>
                            <form class="row login_form" method="POST" action="{{route('do-register')}}" onsubmit="return register()" id="register_form" >
                                @csrf
                                <div class="col-md-12 form-group">
                                    <span class="icon-user-o mr-3 icon validreg"> </span>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                </div>
                                <div class="col-md-12 form-group">
                                    <span class="icon-user mr-3 icon validreg"> </span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">

                                </div>
                                <div class="col-md-12 form-group">
                                    <span class="icon-envelope mr-3 icon validreg"></span>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
                                </div>
                                <div class="col-md-12 form-group">
                                    <span class="icon-lock mr-3 icon validreg"></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                </div>

                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" name="subreg" class=" w-100 btn-outline-primary">Register</button>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger ">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div id="listregerrors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{asset('js/pages/authorization.js')}}"></script>
 @endsection
