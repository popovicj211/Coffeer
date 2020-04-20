
@extends('layouts.admin')

@section('title')Admin Users  @endsection
@section('content')
<section>
    <div class="container marginadmin">
        <div class="row mb-5">
            <div class="col-md-6 text-center">
                <h2 class="text-black"> Create user </h2>
            </div>
            <div class="col-md-6 text-center">
                <h2 class="text-black"> Update user </h2>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 ">
                <form method="post" id="addUserAdminForm" action="{{ route('users-admin.store') }}"  onsubmit="return addUsersAdminValidation();">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name </label>
                        <input type="text" class="form-control valid" id="adminUserAddName" name="adminUserAddName"  placeholder="Enter name">
                        <span class="validstar text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="username"> Username </label>
                        <input type="text" class="form-control valid" id="adminUserAddUsername" name="adminUserAddUsername" placeholder="Enter username">
                        <span class="validstar text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control valid" id="adminUserAddEmail" name="adminUserAddEmail"  placeholder="Enter email">
                        <span class="validstar text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control valid" id="adminUserAddPass" name="adminUserAddPass" placeholder="Password">
                        <span class="validstar text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="role">Role </label>
                        <select name="adminUserAddRole" id="adminUserAddRole" class="form-control">
                            <option value="0"> Select </option>
                              @foreach($roles as $role)
                                <option value="{{$role->role_id}}"> {{ $role->name }} </option>
                                  @endforeach
                        </select>
                        <span class="validstar text-danger"></span>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" value="1" name="adminUserAddActive" id="adminUserAddActive">
                        <label class="form-check-label" for="active"> Active </label>
                        <span class="validstar text-danger"> </span>
                    </div>
                    <button type="submit" id="adminUserAddSub"  name="adminUserAddSub" class="btn btn-outline-primary">Send</button>
                </form>
                <div id="errorsInsUsrAdm"></div>
                @if(session()->has('messageAddUser'))
                    <div class="alert alert-success">
                        {{session()->get("messageAddUser")}}
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-sm-12 " id="updateAdmUser">
                <form name="updateUsers" id="updateUsers" method="post"  action="#" >
                    <meta name="_token" content="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name </label>
                        <input type="text" class="form-control" id="adminUserUpdateName" name="adminUserUpdateName" placeholder="Enter name" >
                        <span class="validstarUp text-danger"></span>

                    </div>
                    <div class="form-group">
                        <label for="username"> Username </label>
                        <input type="text" class="form-control"   id="adminUserUpdateUsername" name="adminUserUpdateUsername" placeholder="Enter username">
                        <span class="validstarUp text-danger"></span>

                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control"   id="adminUserUpdateEmail" name="adminUserUpdateEmail" placeholder="Enter email" >
                        <span class="validstarUp text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password ( Please you don't enter password if you don't want update it)</label>
                        <input type="password" class="form-control"   id="adminUserUpdatePass" name="adminUserUpdatePass" placeholder="Enter password" >
                        <span class="validstarUp text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="role">Role </label>
                        <select name="adminUserUpdateRole"  id="adminUserUpdateRole" class="form-control">
                            <option value="0"> Select </option>
                                @foreach($roles as $r)
                                <option value="{{$r->role_id}}"> {{ $r->name }} </option>
                                 @endforeach
                        </select>
                        <span class="validstarUp text-danger"></span>
                    </div>
                    <div class="form-check">
                       <input  type="checkbox" class="form-check-input" name="adminUserUpdateActive" id="adminUserUpdateActive">
                        <label class="form-check-label"  for="active"> Active </label>
                        <span class="validstarUp text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="hiddenAdminUsrUpdateUserId" name="hiddenAdminUsrUpdateUserId" />

                    </div>
                    <a type="button" id="adminUserUpdateSub"  name="adminUserUpdateSub"  class="btn btn-outline-primary">Send</a>
                </form>
                <div id="errorsUpdUsrAdm"></div>
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
                        <th scope="col"> Username </th>
                        <th scope="col"> Email </th>
                        <th scope="col"> Created</th>
                        <th scope="col"> Modified</th>
                        <th scope="col"> Active  </th>
                        <th scope="col"> Role  </th>
                        <th scope="col">  Update </th>
                        <th scope="col">  Delete </th>
                    </tr>
                    </thead>
                    <tbody id="tableUsers">

                      @isset($users)
                          @foreach($users as $user)
                    <tr>
                        <td scope="row"> {{ $loop->iteration }}</td>
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->username }}</td>
                        <td>  {{ $user->email }} </td>
                        <td>  {{ date("d-M-Y H:i:s", strtotime($user->created))  }} </td>
                        <td>  {{ date("d-M-Y H:i:s", strtotime($user->modified))  }} </td>
                             @if($user->active == 1)
                                <td>  {{ "Yes" }} </td>
                                 @else
                            <td>  {{ "No" }} </td>
                              @endif
                        <td>  {{ $user->rolename }} </td>
                        <td> <a class="btn btn-primary updateUser" data-id="{{ $user->user_id }}"  href="#">  Update </a> </td>
                        <td> <a  class="btn btn-dark deleteUser"  data-id="{{ $user->user_id }}" href="#"> Delete </a>  </td>
                    </tr>
                         @endforeach
                     @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center m-5">
                <div class="block-27" id="pagUserAdmin" >
                    @isset($users)
                    @if ($users->lastPage() > 1)
                        <ul >
                            <li class="{{ ($users->currentPage() == 1) ? ' disabled' : '' }}">
                                <a href="{{ $users->url(1) }}">Prev</a>
                            </li>
                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                                <li class="{{ ($users->currentPage() == $i) ? ' active' : '' }}">
                                    <a href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="{{ ($users->currentPage() == $users->lastPage()) ? ' disabled' : '' }}">
                                <a href="{{ $users->url($users->currentPage()+1) }}" >Next</a>
                            </li>
                        </ul>
                    @endif
                    @endisset
                </div>
            </div>
        </div>
      </div>
</section>

@endsection

@section('script')
       <script type="text/javascript" src="{{asset('js/pages/admin/useradmin.js')}}" charset="utf-8"></script>
       @if(session()->has('messageAddUser'))

               <script type="text/javascript">
                   alert('{{session()->get("messageAddUser")}}')
               </script>
       @endif

@endsection
