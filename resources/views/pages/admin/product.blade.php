@extends('layouts.admin')

@section('title')Admin Products  @endsection
@section('content')
    <section>
        <div class="container marginadmin">
            <div class="row mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="text-black"> Add product </h2>
                </div>
                <div class="col-md-6 text-center" id="updateHeader">
                    <h2 class="text-black"> Update product </h2>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <form method="post" id="addProductAdminForm" action="{{route('products-admin.store') }}"  enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group">
                            <label for="photo">  Product photo </label>
                            <button type="button" class="btn btn-light form-control" id="btnPhotoIns"  onclick="document.getElementById('insPhotoProduct').click()" >Add product image</button>
                            <input type="file" name="insPhotoProduct" id="insPhotoProduct" style="display:none;" onchange="document.getElementById('InsertImageValue').innerHTML=this.value;" /> <div id="InsertImageValue"> </div>

                        </div>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control valid" id="adminProductAddName" name="adminProductAddName"  placeholder="Enter name">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="description"> Description </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminProductAddDesc" name="adminProductAddDesc" placeholder="Enter description" ></textarea>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="price"> Price </label>
                            <input type="text" class="form-control valid" id="adminProductAddPrice" name="adminProductAddPrice"  placeholder="Enter price">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount </label>
                            <select name="adminProductAddDiscount" id="adminProductAddDiscount" class="form-control">
                                <option value="0"> No percent </option>
                                @foreach($discount as $d)
                                    <option value="{{$d->dis_id}}"> {{ $d->percent }} %</option>
                                @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="category">Category </label>
                            <select name="adminProductAddCat" id="adminProductAddCat" class="form-control">
                                <option value="0"> Select </option>
                                @foreach($category as $c)
                                    <option value="{{$c->cat_id}}"> {{ $c->name }} </option>
                                @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <button type="submit" id="adminProductAddSub"  name="adminProductAddSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div id="errorsInsProAdm"></div>
                    @if(session()->has('messageAddProduct'))
                        <div class="alert alert-success">
                            {{session()->get("messageAddProduct")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12 " id="updateAdmProduct">
                    <form name="updateProducts" id="updateProducts" method="post"  action="#" >
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="showphoto">  Show photo button </label>
                            <input type="checkbox" name="showBtnImgUp" id="showBtnImgUp" value="1">
                        </div>
                        <div class="form-group">
                            <label for="photo">  Product photo </label>
                            <button type="button" class="btn btn-light form-control" id="btnPhotoUp"  onclick="document.getElementById('upPhotoProduct').click()" >Add product image</button>
                            <input type="file" name="upPhotoProduct" id="upPhotoProduct" style="display:none;" onchange="document.getElementById('UpdateImageValue').innerHTML=this.value;" /> <div id="UpdateImageValue"> </div>
                           <input type="hidden" id="upPhotoProductExist" name="upPhotoProductExist">
                        </div>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control" id="adminProductUpdateName" name="adminProductUpdateName"  placeholder="Enter name" >
                            <span class="validstarUp text-danger"></span>

                        </div>
                        <div class="form-group">
                            <label for="description"> Description </label>
                            <textarea  cols="30" rows="3" class="form-control" id="adminProductUpdateDesc" name="adminProductUpdateDesc" placeholder="Enter description" ></textarea>
                            <span class="validstarUp text-danger"></span>

                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control"   id="adminProductUpdatePrice" name="adminProductUpdatePrice" placeholder="Enter price"  >
                            <span class="validstarUp text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount </label>
                            <select name="adminProductUpdateDiscount" id="adminProductUpdateDiscount" class="form-control">
                                <option value="0"> No percent </option>
                                @foreach($discount as $d)
                                    <option value="{{$d->dis_id}}"> {{ $d->percent }} %</option>
                                @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="category">Category </label>
                            <select name="adminProductUpdateCat" id="adminProductUpdateCat" class="form-control">
                                <option value="0"> Select </option>
                                @foreach($category as $c)
                                    <option value="{{$c->cat_id}}"> {{ $c->name }} </option>
                                @endforeach
                            </select>
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="hiddenAdminProUpdateDfId" name="hiddenAdminProUpdateDfId" />
                            <input type="hidden" id="hiddenAdminProUpdateImgId" name="hiddenAdminProUpdateImgId" />
                        </div>
                        <a type="button" id="adminProductUpdateSub"  name="adminProductUpdateSub"  class="btn btn-outline-primary">Send</a>
                    </form>
                    <div id="errorsUpdProAdm"></div>
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
                        <th scope="col"> Image </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Description </th>
                        <th scope="col"> Price </th>
                        <th scope="col"> New price</th>
                        <th scope="col"> Discount </th>
                        <th scope="col"> Category  </th>
                        <th scope="col"> Created  </th>
                        <th scope="col"> Modified  </th>
                        <th scope="col">  Update </th>
                        <th scope="col">  Delete </th>
                    </tr>
                    </thead>
                    <tbody id="tableProducts">

                    @isset($products)
                        @foreach($products as $p)
                            <tr>
                                <td scope="row"> {{ $loop->iteration }}</td>
                                <td><img class="imgAdm" src="{{asset('images/products/'.$p->link)}}" alt="{{ $p->alt }}"></td>
                                <td> {{ $p->name }} </td>
                                <td> <p class="textDesc"> {{ $p->desc }} </p></td>
                                <td>  {{ $p->price }} RSD </td>
                                     @if(isset($p->newprice))
                                <td>  {{ $p->newprice }} RSD</td>
                                         @else
                                    <td> / </td>
                                     @endif
                                      @if(isset($p->percent))
                                <td>  {{ $p->percent }}% </td>
                                @else
                                    <td> / </td>
                                          @endif
                                <td>  {{ $p->catname }} </td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($p->created))  }} </td>
                                <td>  {{ date("d-M-Y H:i:s", strtotime($p->modified))  }} </td>
                                <td> <a class="btn btn-primary updateProduct" data-id="{{ $p->df_id}}-{{$p->img_id}}"  href="#">  Update </a> </td>
                                <td> <a  class="btn btn-dark deleteProduct"  data-id="{{ $p->df_id}}-{{$p->img_id}}" href="#"> Delete </a>  </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center m-5">
                <div class="block-27" id="pagProductAdmin" >
                    @isset($products)
                        @if ($products->lastPage() > 1)
                            <ul >
                                <li class="{{ ($products->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{ $products->url(1) }}">Prev</a>
                                </li>
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="{{ ($products->currentPage() == $i) ? ' active' : '' }}">
                                        <a href="{{ $products->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="{{ ($products->currentPage() == $products->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $products->url($products->currentPage()+1) }}" >Next</a>
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
    <script type="text/javascript" src="{{asset('js/pages/admin/productadmin.js')}}" charset="utf-8"></script>

@endsection
