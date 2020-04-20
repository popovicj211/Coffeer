@extends('layouts.admin')

@section('title')Admin Contact @endsection
@section('content')
    <section>
        <div class="container marginadmin">
            <div class="row mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="text-black"> Add contact </h2>
                </div>
                <div class="col-md-6 text-center" id="updateHeaderContact">
                    <h2 class="text-black"> Update contact </h2>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <form method="post" id="addContactAdminForm" action="{{ route('contact-admin.store') }}"   >
                        @csrf
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control valid" id="adminContactAddName" name="adminContactAddName"  placeholder="Enter name">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="email"> Email </label>
                            <input type="text" class="form-control valid" id="adminContactAddEmail" name="adminContactAddEmail"  placeholder="Enter email">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="subject"> Subject </label>
                            <input type="text" class="form-control valid" id="adminContactAddSubject" name="adminContactAddSubject"  placeholder="Enter subject">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="message"> Message </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminContactAddMessage" name="adminContactAddMessage" placeholder="Enter message" ></textarea>
                            <span class="validstar text-danger"></span>
                        </div>
                        <button type="submit" id="adminContactAddSub"  name="adminContactAddSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div id="errorsInsProAdm"></div>
                    @if(session()->has('messageAddCont'))
                        <div class="alert alert-success">
                            {{session()->get("messageAddCont")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12 " id="updateAdmContact">
                    <form name="updateProducts" id="updateContact" method="post"  action="#" >
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control" id="adminContactUpdateName" name="adminContactUpdateName"  placeholder="Contact name" >
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="text" class="form-control" id="adminContactUpdateEmail" name="adminContactUpdateEmail"  placeholder="Contact email" >
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject </label>
                            <input type="text" class="form-control" id="adminContactUpdateSubject" name="adminContactUpdateSubject"  placeholder="Contact subject" >
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="message"> Message </label>
                            <textarea  cols="30" rows="3" class="form-control" id="adminContactUpdateMessage" name="adminContactUpdateMessage" placeholder="Enter message" ></textarea>
                            <span class="validstarUp text-danger"></span>

                        </div>

                        <div class="form-group">
                            <input type="hidden" id="hiddenAdminUpdateContId" name="hiddenAdminUpdateContId" />
                        </div>
                        <a type="button" id="adminContactUpdateSub"  name="adminContactUpdateSub"  class="btn btn-outline-primary">Send</a>
                    </form>
                    <div id="errorsUpdContAdm"></div>
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
                        <th scope="col"> Subject</th>
                        <th scope="col"> Message </th>
                        <th scope="col"> Created</th>
                        <th scope="col"> Modified </th>
                        <th scope="col">  Update </th>
                        <th scope="col">  Delete </th>
                    </tr>
                    </thead>
                    <tbody id="tableContact">

                    @isset($contact)
                        @foreach($contact as $c)
                            <tr>
                                <td scope="row"> {{ $loop->iteration }}</td>
                                <td> {{ $c->name }} </td>
                                <td> {{ $c->email }} </td>
                                <td>  {{ $c->subject }} </td>
                                <td> <p class="textDesc">  {{ $c->message }} </p></td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($c->created))  }} </td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($c->modified))  }} </td>
                                <td> <a class="btn btn-primary updateContact" data-id="{{ $c->cont_id}}"  href="#">  Update </a> </td>
                                <td> <a  class="btn btn-dark deleteContact"  data-id="{{ $c->cont_id}}" href="#"> Delete </a>  </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center m-5">
                <div class="block-27" id="pagContactAdmin" >
                    @isset($contact)
                        @if ($contact->lastPage() > 1)
                            <ul >
                                <li class="{{ ($contact->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{ $contact->url(1) }}">Prev</a>
                                </li>
                                @for ($i = 1; $i <= $contact->lastPage(); $i++)
                                    <li class="{{ ($contact->currentPage() == $i) ? ' active' : '' }}">
                                        <a href="{{ $contact->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="{{ ($contact->currentPage() == $contact->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $contact->url($contact->currentPage()+1) }}" >Next</a>
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
                    <form  method="post" id="responeContactAdminForm"  name="responeContactAdminForm" action="#">
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="email">User email </label>
                            <select id="adminContactResponseEmail" name="adminContactResponseEmail" class="form-control">
                                    <option value="0"> Select</option>
                                @foreach($users as $u)
                                    <option value="{{$u->cont_id}}-{{$u->email}}"> {{ $u->email }}</option>
                                   @endforeach
                            </select>
                            <span class="validstarRe text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="message"> Message </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminContactResponseMessage" name="adminContactResponseMessage" placeholder="Enter message" ></textarea>
                            <span class="validstarRe text-danger"></span>
                        </div>
                        <button type="button" id="adminContactResponseSub"  name="adminContactResponseSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div class="errorsRespContAdm"></div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/pages/admin/contactadmin.js')}}" charset="utf-8"></script>

@endsection

