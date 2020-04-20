<!DOCTYPE html>
<html>
         @include('inc.admin.head')
    <body>

              @yield('content')
    </body>
   <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
          @section('script')
            @show
</html>
