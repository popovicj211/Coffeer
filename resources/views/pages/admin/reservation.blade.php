@extends('layouts.admin')

@section('title')Admin Reservation @endsection
@section('content')
    <section>
        <div class="container marginadmin">
            <div class="row mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="text-black"> Add reservation </h2>
                </div>
                <div class="col-md-6 text-center" id="updateHeaderRes">
                    <h2 class="text-black"> Update reservation </h2>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <form method="post" id="addResAdminForm" action="{{ route('reservation-admin.store') }}"   >
                        @csrf
                        <div class="form-group">
                            <label for="user">User </label>
                            <select id="adminResAddUser" name="adminResAddUser" class="form-control">
                                <option value="0"> Select </option>
                                @foreach($users as $u)
                                    <option value="{{$u->user_id}}"> {{ $u->email }} </option>
                                @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group ml-md-4">
                                <input type="date" name="adminResAddDate"  id="adminResAddDate" class="form-control " >
                                <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="time" name="adminResAddTime"  id="adminResAddTime" class="form-control " >
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="mobile"> Mobile </label>
                            <input type="text" class="form-control valid" id="adminResAddMobile" name="adminResAddMobile"  placeholder="Enter mobile">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="message"> Message </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminResAddMessage" name="adminResAddMessage" placeholder="Enter message" ></textarea>
                            <span class="validstar text-danger"></span>
                        </div>
                        <button type="submit" id="adminResAddSub"  name="adminResAddSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div id="errorsInsResAdm"></div>
                    @if(session()->has('messageAddRes'))
                        <div class="alert alert-success">
                            {{session()->get("messageAddRes")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12 " id="updateAdmRes">
                    <form name="updateRes" id="updateRes" method="post"  action="#" >
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="user">User </label>
                            <select id="adminResUpUser" name="adminResUpUser" class="form-control">
                                <option value="0"> Select </option>
                                 @foreach($users as $u)
                                    <option value="{{$u->user_id}}"> {{ $u->email }} </option>
                                  @endforeach
                            </select>
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group ml-md-4">
                                <input type="date" name="adminResUpDate" id="adminResUpDate" class="form-control " >
                                <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="time" name="adminResUpTime" id="adminResUpTime" class="form-control " >
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="mobile"> Mobile </label>
                            <input type="text" class="form-control valid" id="adminResUpMobile" name="adminResUpMobile"  placeholder="Enter mobile">
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="message"> Message </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminResUpMessage" name="adminResUpMessage" placeholder="Enter message" ></textarea>
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="hiddenAdminUpResId" name="hiddenAdminUpResId" />
                        </div>
                        <a type="button" id="adminResUpSub"  name="adminResUpSub"  class="btn btn-outline-primary">Send</a>
                    </form>
                    <div id="errorsUpdResAdm"></div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                @if ($errors->any())
                    <div class="alert alert-danger" >
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

        </div>
        <div class="row " >
            <div class="col-md-12 table-responsive marginadmin" >
                <table class="table mt-4">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Email </th>
                        <th scope="col"> Datetime reservation</th>
                        <th scope="col"> Subject</th>
                        <th scope="col"> Message </th>
                        <th scope="col"> Created</th>
                        <th scope="col"> Modified </th>
                        <th scope="col">  Update </th>
                        <th scope="col">  Delete </th>
                    </tr>
                    </thead>
                    <tbody id="tableResservation">

                    @isset($reservation)
                        @foreach($reservation as $r)
                            <tr>
                                <td scope="row"> {{ $loop->iteration }}</td>
                                <td> {{ $r->name }} </td>
                                <td> {{ $r->email }} </td>
                                <td>  {{ date("d-M-Y H:i" ,strtotime($r->date)) }} </td>
                                <td>  {{ $r->mobile }} </td>
                                <td> <p class="textDesc">  {{ $r->message }} </p></td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($r->created))  }} </td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($r->modified))  }} </td>
                                <td> <a class="btn btn-primary updateRes" data-id="{{ $r->res_id}}"  href="#">  Update </a> </td>
                                <td> <a  class="btn btn-dark deleteRes"  data-id="{{ $r->res_id}}" href="#"> Delete </a>  </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center m-5">
                <div class="block-27" id="pagResAdmin" >
                    @isset($reservation)
                        @if ($reservation->lastPage() > 1)
                            <ul >
                                <li class="{{ ($reservation->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{ $reservation->url(1) }}">Prev</a>
                                </li>
                                @for ($i = 1; $i <= $reservation->lastPage(); $i++)
                                    <li class="{{ ($reservation->currentPage() == $i) ? ' active' : '' }}">
                                        <a href="{{ $reservation->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="{{ ($reservation->currentPage() == $reservation->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $reservation->url($reservation->currentPage()+1) }}" >Next</a>
                                </li>
                            </ul>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        </div>
        <div class="container marginadmin">
            <div class="row justify-content-cente">
                <h2 class="text-center"> Response message to email  </h2>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <form  method="post" id="responeResAdminForm"  name="responeResAdminForm" action="#">
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="email">User email </label>
                            <select id="adminResResponseEmail" name="adminResResponseEmail" class="form-control">
                                <option value="0"> Select</option>
                                   @foreach($users as $u)
                                    <option value="{{$u->user_id}}-{{$u->email}}"> {{ $u->email }}</option>
                                       @endforeach
                            </select>
                            <span class="validstarRe text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="message"> Message </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminResResponseMessage" name="adminResResponseMessage" placeholder="Enter message" ></textarea>
                            <span class="validstarRe text-danger"></span>
                        </div>
                        <button type="button" id="adminResResponseSub"  name="adminResResponseSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div class="errorsRespResAdm"></div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/admin/reservation.js')}}" charset="utf-8"></script>

@endsection


