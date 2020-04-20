<!DOCTYPE html>
<html>
         @include('inc.head')
<body>
@include('inc.nav')

@yield('content')

@include('inc.admin.footer')

</body>
<script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
 @yield('script')
</html>
