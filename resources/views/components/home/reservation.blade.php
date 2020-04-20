<section class="ftco-intro">
    <div class="container-wrap">
        <div class="wrap d-md-flex align-items-xl-end">
            <div class="info">
                <div class="row no-gutters">
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="icon"><span class="icon-phone"></span></div>
                        <div class="text">
                            <h3>+381 111 1111
                            </h3>
                            <p>A small river named Duden flows by their place and supplies.</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="icon"><span class="icon-my_location"></span></div>
                        <div class="text">
                            <h3>Zdravka Celara 16,Belgrade , Serbia</h3>
                            <p>11000 Belgrade, Serbia</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="icon"><span class="icon-clock-o"></span></div>
                        <div class="text">
                            <h3>Open Monday-Friday</h3>
                            <p>8:00am - 9:00pm</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="book p-4">
                <h3>Reservation</h3>
                @if(session()->has('user'))
                @if(session()->has('msgReservation'))
                    <div class="alert alert-info">
                        {{session()->get("msgReservation")}}
                    </div>
                @endif
                <form action="{{route('reservation')}}" method="POST"  onsubmit="return Reservation()">
                     @csrf

                    <div class="d-md-flex">
                        <div class="form-group posRel">
                                <!--<div class="icon"><span class="ion-md-calendar resValidIcon"></span></div> -->
                                <span class="ion-md-calendar mr-3 resValid"> </span>
                                <input type="date" name="resdate" id="resdate" class="form-control" >
                        </div>
                        <div class="form-group ml-md-4 posRel">
                             <!--   <div class="icon"><span class="ion-ios-clock resValidIcon"></span></div>-->
                                <span class="ion-ios-clock resValid mr-3 "> </span>
                                <input type="time" name="restime" id="restime" class="form-control" >
                        </div>
                        <div class="form-group ml-md-4  posRel">
                        <!--    <div class="icon"><span class="icon-mobile-phone resValidIcon"></span></div>-->
                            <span class="icon-mobile-phone mr-3 resValid"> </span>
                            <input type="text" name="resmob" id="resmob" class="form-control" placeholder="Phone">
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group posRel">
                       <!--     <div class="icon"><span class="icon-message resValidIcon"></span></div>-->
                            <span class="icon-message mr-3 resValid"> </span>
                            <textarea name="resmsg" id="resmsg" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="submit" name="btnres" id="btnres" value="Appointment" class="btn btn-white py-3 px-4">
                        </div>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="errorsResList"></div>
                 @else
                          <p> Please log in on our website and reservation a table.</p>
                @endif
            </div>
        </div>
    </div>
</section>

