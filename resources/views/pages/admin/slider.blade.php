@extends('layouts.admin')

@section('title')Admin Slider  @endsection
@section('content')
    <section>
        <div class="container marginadmin">
            <div class="row mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="text-black"> Add slide </h2>
                </div>
                <div class="col-md-6 text-center" id="updateHeaderSld">
                    <h2 class="text-black"> Update slide </h2>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <form method="post" id="addSlideAdminForm" name="addSlideAdminForm" action="{{route('slider-admin.store') }}"  enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group">
                            <label for="photo">  Slide photo </label>
                            <button type="button" class="btn btn-light form-control" id="btnPhotoInsSld"  onclick="document.getElementById('insPhotoSlide').click()" >Add slide image</button>
                            <input type="file" name="insPhotoSlide" id="insPhotoSlide" style="display:none;" onchange="document.getElementById('InsertImageValueSld').innerHTML=this.value;" /> <div id="InsertImageValueSld"> </div>

                        </div>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control valid" id="adminSlideAddName" name="adminSlideAddName"  placeholder="Enter name">
                            <span class="validstar text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="text"> Text </label>
                            <textarea  cols="30" rows="3" class="form-control valid" id="adminSlideAddDesc" name="adminSlideAddDesc" placeholder="Enter text" ></textarea>
                            <span class="validstar text-danger"></span>
                        </div>
                        <button type="submit" id="adminSlideAddSub"  name="adminSlideAddSub" class="btn btn-outline-primary">Send</button>
                    </form>
                    <div id="errorsInsSlideAdm"></div>
                    @if(session()->has('messageAddSlide'))
                        <div class="alert alert-success">
                            {{session()->get("messageAddSlide")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12 " id="updateAdmSlider">
                    <form name="updateSlider" id="updateSlider" method="post"  action="#" >
                        <meta name="_token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="showphoto">  Show photo button </label>
                            <input type="checkbox" name="showBtnImgUpSld" id="showBtnImgUpSld" value="1">
                        </div>
                        <div class="form-group">
                            <label for="photo"> Slide photo </label>
                            <button type="button" class="btn btn-light form-control" id="btnPhotoUpSld"  onclick="document.getElementById('upPhotoSlide').click()" >Add slide image</button>
                            <input type="file" name="upPhotoSlide" id="upPhotoSlide" style="display:none;" onchange="document.getElementById('UpdateImageValueSld').innerHTML=this.value;" /> <div id="UpdateImageValueSld"> </div>
                            <input type="hidden" id="upPhotoSlideExist" name="upPhotoSlideExist">
                        </div>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control" id="adminSlideUpdateName" name="adminSlideUpdateName"  placeholder="Enter name" >
                            <span class="validstarUp text-danger"></span>

                        </div>
                        <div class="form-group">
                            <label for="text"> Text </label>
                            <textarea  cols="30" rows="3" class="form-control" id="adminSlideUpdateText" name="adminSlideUpdateText" placeholder="Enter text" ></textarea>
                            <span class="validstarUp text-danger"></span>

                        </div>
                        <div class="form-group">
                            <input type="hidden" id="hiddenAdminSlideUpdateSlideId" name="hiddenAdminSlideUpdateSlideId" />
                            <input type="hidden" id="hiddenAdminSlideUpdateImgId" name="hiddenAdminSlideUpdateImgId" />
                        </div>
                        <a type="button" id="adminSliderUpdateSub"  name="adminSliderUpdateSub"  class="btn btn-outline-primary">Send</a>
                    </form>
                    <div id="errorsUpdSlideAdm"></div>
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
                        <th scope="col"> Text </th>
                        <th scope="col">  Update </th>
                        <th scope="col">  Delete </th>
                    </tr>
                    </thead>
                    <tbody id="tableSlider">

                    @isset($slider)
                        @foreach($slider as $p)
                            <tr>
                                <td scope="row"> {{ $loop->iteration }}</td>
                                <td><img class="imgAdm" src="{{asset('images/products/'.$p->link)}}" alt="{{ $p->alt }}"></td>
                                <td> {{ $p->name }} </td>
                                <td> <p> {{ $p->text }} </p></td>
                                <td> <a class="btn btn-primary updateSlide" data-id="{{ $p->slide_id}}-{{$p->img_id}}"  href="#">  Update </a> </td>
                                <td> <a  class="btn btn-dark deleteSlide"  data-id="{{ $p->slide_id}}-{{$p->img_id}}" href="#"> Delete </a>  </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center m-5">
                <div class="block-27" id="pagSliderAdmin" >
                    @isset($slider)
                        @if ($slider->lastPage() > 1)
                            <ul >
                                <li class="{{ ($slider->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{ $slider->url(1) }}">Prev</a>
                                </li>
                                @for ($i = 1; $i <= $slider->lastPage(); $i++)
                                    <li class="{{ ($slider->currentPage() == $i) ? ' active' : '' }}">
                                        <a href="{{ $slider->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="{{ ($slider->currentPage() == $slider->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $slider->url($slider->currentPage()+1) }}" >Next</a>
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
    <script type="text/javascript" src="{{asset('js/pages/admin/slideradmin.js')}}" charset="utf-8"></script>

@endsection
