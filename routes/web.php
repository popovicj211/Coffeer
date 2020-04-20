<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/404' , function (){
        return view('pages.404');
});
Route::get('/500' , function (){
        return view('pages.500');
});

Route::get('/nav/cart',  'FrontendController@ajaxCartCount');
//Route::get('/nav/cart/{usr}',  'Pages\AuthorController@CountsCrt')->where(['usr'=>'[1-9]+'])->name('cartcount');

Route::get('/home',  'Pages\HomeController@Index')->name('home');
Route::get('/discount/show',  'Pages\HomeController@ajaxDfspag');

Route::get('/drinkfood',  'Pages\DrinkfoodController@Index')->name('menu');
Route::get('/drinkfood/filter/{cat}',  'Pages\DrinkfoodController@MenuDrinkFoodFilter')->where(['cat'=>'[1-9][0-9]*'])->name('menufilter');
Route::get('/drinkfood/pagination/{pag}',  'Pages\DrinkfoodController@getAllDrinksFoods')->where(['pag'=>'[1-9][0-9]*'])->name('menupagination');
Route::get('/drinkfood/show',  'Pages\DrinkFoodController@ajaxDfspag');
Route::get('/drinkfood/show/filter',  'Pages\DrinkFoodController@ajaxDfspagFilter');
Route::get('/drinkfood/show/category',  'Pages\DrinkFoodController@ajaxshowcat');

Route::get('/about',  'Pages\AboutController@Index')->name('about');


Route::get('/contact',  'Pages\ContactController@Index')->name('contact');
Route::post('/contact',  'Pages\ContactController@doContact')->name('do-contact');

Route::get('/authorization',  'User\LoginController@authorizationFormsShow')->name('authorization');
Route::post('/register',  'User\LoginController@doRegister')->name('do-register');


Route::post('/login',  'User\LoginController@doLogin')->name('do-login');

Route::get('/logout',  'User\LoginController@Logout')->name('logout');

Route::get('/activate/{token}',  'User\LoginController@Act')->where(['token' => '[a-z0-9]{32,35}'])->name('activate');

Route::group(['middleware' =>'checkAuth'], function () {

    Route::post('/reservation', 'Pages\HomeController@Reservation')->name('reservation');
    Route::post('/singleproduct/quantity', 'Pages\SingleProductController@addToCart')->name('quantity');

  //  Route::get('/cart/show', 'Pages\CartController@ajaxCartDfspag');
 //   Route::delete('/cart/delete/{id}', 'Pages\CartController@destroy')->where(['id' => '[1-9][0-9]*'])->name('cartdelete');
});

Route::get('/singleproduct/{sp}', 'Pages\SingleProductController@Index')->where(['sp' => '[1-9][0-9]*'])->name('singleproduct');
Route::get('/cart', 'Pages\CartController@Index')->name('cart');
Route::get('/deleteFromCart/{id}',"Pages\CartController@deleteFromCart")->name("deleteFromCart");
Route::post('/addtocart',  'Pages\CartController@addCartData')->name('addToCart');

//Route::get('/showcart',  'Pages\CartController@ajaxCartDfs');


Route::get('/author', 'Pages\AuthorController@Index')->name('author');


Route::get('/checkout',  'Pages\CheckoutController@Index')->name('checkout');
Route::post('/checkout',  'Pages\CheckoutController@doChechout')->name('do-checkout');





Route::group(['middleware' =>'adminAuth'], function (){



// Admin
//users
Route::get('/admin/users',  'Admin\UserController@index')->name('users-admin.index');
Route::post('/admin/users',  'Admin\UserController@store')->name('users-admin.store');
Route::get('/admin/users/show',  'Admin\UserController@ajaxIndex');
Route::get("/admin/users/edit/{id}","Admin\UserController@edit")->where(['id'=>'[1-9][0-9]*'])->name('users-admin.edit');
Route::post('/admin/users/update/{id}',  'Admin\UserController@update')->where(['id'=>'[1-9][0-9]*'])->name('users-admin.update');
Route::delete("/admin/users/delete/{id}","Admin\UserController@destroy")->where(['id'=>'[1-9][0-9]*'])->name('users-admin.delete');

//products
Route::get('/admin/products',  'Admin\ProductController@index')->name('products-admin.index');
Route::post('/admin/products',  'Admin\ProductController@store')->name('products-admin.store');
Route::get('/admin/products/show',  'Admin\ProductController@ajaxIndex');
Route::get('/admin/products/edit/{id}/image/{img}',  'Admin\ProductController@edit')->where(['id'=>'[1-9][0-9]*' , 'img' => '[1-9][0-9]*'])->name('products-admin.edit');
Route::post('/admin/products/update/{id}/image/{img}',  'Admin\ProductController@update')->where(['id'=>'[1-9][0-9]*' , 'img' => '[1-9][0-9]*'])->name('products-admin.update');
Route::delete("/admin/products/delete/{id}","Admin\ProductController@destroy")->where(['id'=>'[1-9][0-9]*'])->name('products-admin.delete');


//cart
Route::get('/admin/cart',  'Admin\CartController@index')->name('cart-admin.index');
Route::get('/admin/cart/filter/{user}',  'Admin\CartController@indexFilter')->where(['user' => '[1-9][0-9]*'])->name('cart-admin.indexfilter');
Route::post('/admin/cart',  'Admin\CartController@store')->name('cart-admin.store');
Route::get('/admin/cart/show',  'Admin\CartController@ajaxIndex');
Route::get('/admin/cart/show/filter',  'Admin\CartController@ajaxIndexFilter');
Route::get('/admin/cart/edit/{id}',  'Admin\CartController@edit')->where(['id' => '[1-9][0-9]*'])->name('cart-admin.edit');
Route::post('/admin/cart/update/{id}',  'Admin\CartController@update')->where(['id' => '[1-9][0-9]*'])->name('cart-admin.update');
Route::delete('/admin/cart/delete/{id}',  'Admin\CartController@destroy')->where(['id' => '[1-9][0-9]*'])->name('cart-admin.delete');

// contact
Route::get('/admin/contact',  'Admin\ContactController@index')->name('contact-admin.index');
Route::get('/admin/contact/show',  'Admin\ContactController@ajaxIndex');
Route::post('/admin/contact',  'Admin\ContactController@store')->name('contact-admin.store');
Route::get('/admin/contact/edit/{id}',  'Admin\ContactController@edit')->where(['id' => '[1-9][0-9]*'])->name('contact-admin.edit');
Route::post('/admin/contact/update/{id}',  'Admin\ContactController@update')->where(['id' => '[1-9][0-9]*'])->name('contact-admin.update');
Route::delete('/admin/contact/delete/{id}',  'Admin\ContactController@destroy')->where(['id' => '[1-9][0-9]*'])->name('contact-admin.delete');
Route::post('/admin/contact/response',  'Admin\ContactController@response')->name('contact-admin.response');


//reservation

Route::get('/admin/reservation',  'Admin\ReserationController@index')->name('reservation-admin.index');
Route::get('/admin/reservation/show',  'Admin\ReserationController@ajaxIndex');
Route::post('/admin/reservation',  'Admin\ReserationController@store')->name('reservation-admin.store');
Route::get('/admin/reservation/edit/{id}',  'Admin\ReserationController@edit')->where(['id' => '[1-9][0-9]*'])->name('reservation-admin.edit');
Route::post('/admin/reservation/update/{id}',  'Admin\ReserationController@update')->where(['id' => '[1-9][0-9]*'])->name('reservation-admin.update');
Route::delete('/admin/reservation/delete/{id}',  'Admin\ReserationController@destroy')->where(['id' => '[1-9][0-9]*'])->name('reservation-admin.delete');
Route::post('/admin/reservation/response',  'Admin\ReserationController@response')->name('reservation-admin.response');

//logs
Route::get('admin/log/{id}' , 'Admin\LogController@getLogs')->where(['id' => '[0-9]*'])->name('logs');

//slider
Route::get('/admin/slider',  'Admin\SliderController@index')->name('slider-admin.index');
Route::get('/admin/slider/show',  'Admin\SliderController@ajaxIndex');
Route::post('/admin/slider',  'Admin\SliderController@store')->name('slider-admin.store');
Route::get('/admin/slider/edit/{id}/images/{img}',  'Admin\SliderController@edit')->where(['id' => '[1-9][0-9]*' ,  'img' => '[1-9][0-9]*'])->name('slider-admin.edit');
Route::post('/admin/slider/update/{id}/images/{img}',  'Admin\SliderController@update')->where(['id' => '[1-9][0-9]*' , 'img' => '[1-9][0-9]*'])->name('slider-admin.update');
Route::delete('/admin/slider/delete/{id}',  'Admin\SliderController@destroy')->where(['id' => '[1-9][0-9]*'])->name('slider-admin.delete');

});


Route::get('/rt',  'Pages\SingleProductController@rt')->name('rt');
