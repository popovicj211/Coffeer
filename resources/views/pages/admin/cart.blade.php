@extends('layouts.admin')

@section('title')Admin Cart  @endsection
@section('content')
    <section>
        <div class="container marginadmin">
            <div class="row mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="text-black"> Add product to cart </h2>
                </div>
                <div class="col-md-6 text-center" id="updateHeaderCart">
                    <h2 class="text-black"> Update product of cart </h2>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <form method="post" id="addCartAdminForm" action="{{ route('cart-admin.store') }}"   >
                        @csrf
                        <div class="form-group">
                            <label for="user"> User </label>
                            <select name="adminCartAddUser" id="adminCartAddUser" class="form-control">
                                <option value="0"> Select </option>
                                @isset($users)
                                    @foreach($users as $u)
                                        <option value="{{ $u->user_id }}">{{ $u->name }} - {{ $u->email }} </option>
                                    @endforeach
                                @endisset
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="product">Product </label>
                            <select id="adminCartAddProduct" name="adminCartAddProduct" class="form-control">
                                <option value="0"> Select </option>
                                @foreach($products as $p )
                                    <option value="{{$p->df_id}}-{{isset($p->newprice) ? $p->newprice : $p->price}}"> {{ $p->name }} - {{ isset($p->newprice) ? $p->newprice : $p->price }} RSD </option>
                                    @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity </label>
                            <select id="adminCartAddQuantity" name="adminCartAddQuantity" class="form-control">
                                <option value="0"> Select </option>
                                 @for($i = 0; $i < count($quantity); $i++ )
                                    <option value="{{ $i + 1 }}"> {{ $quantity[$i] }} </option>
                                 @endfor
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>

                        <button type="submit" id="adminCartAddSub"  name="adminCartAddSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div id="errorsInsCartAdm"></div>
                    @if(session()->has('messageAddCart'))
                        <div class="alert alert-success">
                            {{session()->get("messageAddCart")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12 " id="updateAdmCart">
                    <form name="updateCart" id="updateCart" method="post"  action="#" >
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="user"> User </label>
                            <select id="adminCartUpdateUser" name="adminCartUpdateUser" class="form-control">
                                <option value="0"> Select </option>
                                @isset($users)
                                    @foreach($users as $u)
                                        <option value="{{ $u->user_id }}">{{ $u->name }} - {{ $u->email }} </option>
                                    @endforeach
                                @endisset
                            </select>
                            <span class="validstarUp text-danger"></span>

                        </div>
                        <div class="form-group">
                            <label for="product">Product </label>
                            <select id="adminCartUpdateProduct" name="adminCartUpdateProduct" class="form-control">
                                <option value="0"> Select </option>
                                @foreach($products as $p )
                                    <option value="{{$p->df_id}}-{{isset($p->newprice) ? $p->newprice : $p->price}}"> {{ $p->name }} - {{ isset($p->newprice) ? $p->newprice : $p->price }} RSD </option>
                                @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="quantity"> Quabtity</label>
                            <select id="adminCartUpdateQuantity" name="adminCartUpdateQuantity" class="form-control">
                                <option value="0"> Select </option>
                                @for($i = 0; $i < count($quantity); $i++ )
                                    <option value="{{ $i + 1 }}"> {{ $quantity[$i] }} </option>
                                @endfor
                            </select>
                            <span class="validstarUp text-danger"></span>

                        </div>
                        <div class="form-group">
                            <input type="hidden" id="hiddenAdminCartUpdateCartId" name="hiddenAdminCartUpdateCartId" />
                            <input type="hidden" id="hiddenAdminCartUpdateUserId" name="hiddenAdminCartUpdateUserId" />
                        </div>
                        <a type="button" id="adminCartUpdateSub"  name="adminCartUpdateSub"  class="btn btn-outline-primary">Send</a>
                    </form>
                    <div id="errorsUpdCartAdm"></div>
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
        <div class="container">
          <div class="row d-flex justify-content-center marginadmin">
              <h3> Filter user: </h3>
              <select  class="form-control" id="filterListUser" name="filterListUser">
                  <option value="0">Select </option>
                  @isset($showfiltusers)
                      @foreach($showfiltusers as $u)
                          <option value="{{ $u->user_id }}">{{ $u->nameuser }} - {{ $u->email }} </option>
                      @endforeach
                  @endisset
              </select>
              <a type="button" id="filterListUserSub"  name="filterListUserSub"  class="btn btn-outline-primary marginlr">Filter</a>
          </div>
        </div>
        <div class="row " >
            <div class="col-md-12 table-responsive marginadmin" >
                <table class="table mt-4">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> Name of user </th>
                        <th scope="col"> Email </th>
                        <th scope="col"> Image </th>
                        <th scope="col"> Product </th>
                        <th scope="col"> Price </th>
                        <th scope="col"> New price </th>
                        <th scope="col"> Quantity</th>
                        <th scope="col"> Total </th>
                        <th scope="col"> Created  </th>
                        <th scope="col"> Modified  </th>
                        <th scope="col">  Update </th>
                        <th scope="col">  Delete </th>
                    </tr>
                    </thead>
                    <tbody id="tableCartAdm">

                    @isset($showcart)
                        @foreach($showcart as $p)
                            <tr>
                                <td scope="row"> {{ $loop->iteration }}</td>
                                <td> {{ $p->nameuser }} </td>
                                <td> {{ $p->email }} </td>
                                <td><img class="imgAdm" src="{{asset('images/products/'.$p->link)}}" alt="{{ $p->alt }}"></td>
                                <td> {{ $p->name }} </td>
                                <td>  {{ $p->price }} RSD </td>
                                @if(isset($p->newprice))
                                    <td>  {{ $p->newprice }} RSD</td>
                                @else
                                    <td> / </td>
                                @endif
                                <td>  {{ $p->quantity }} </td>
                                <td> {{ $p->total }} </td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($p->created))  }} </td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($p->modified))  }} </td>
                                <td> <a class="btn btn-primary updateCart" data-id="{{ $p->cart_id}}"  href="#">  Update </a> </td>
                                <td> <a  class="btn btn-dark deleteCart"  data-id="{{ $p->cart_id}}" href="#"> Delete </a>  </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center m-5">
                <div class="block-27" id="pagCartAdmin" >
                    @isset($showcart)
                        @if ($showcart->lastPage() > 1)
                            <ul >
                                <li class="{{ ($showcart->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{ $showcart->url(1) }}">Prev</a>
                                </li>
                                @for ($i = 1; $i <= $showcart->lastPage(); $i++)
                                    <li class="{{ ($showcart->currentPage() == $i) ? ' active' : '' }}">
                                        <a href="{{ $showcart->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="{{ ($showcart->currentPage() == $showcart->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $showcart->url($showcart->currentPage()+1) }}" >Next</a>
                                </li>
                            </ul>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        </div>
        <div class="container" id="totalsSum">
            <div class="row d-flex justify-content-center marginadmin blockSize">
                <div class="cart-total mb-3" id="cartTotals">
                    <h3>Cart Totals</h3>
                    <hr>
                    <p class="d-flex total-price">
                        <span>Total</span>
                            @isset($sumtotals)
                            <span> {{ $sumtotals }}</span>
                            @endisset
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/pages/admin/cartadmin.js')}}" charset="utf-8"></script>

@endsection

