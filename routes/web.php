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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'ProductsController@index')->name('index');
Route::get('/FiltrarProductos', 'ProductsController@FiltrarProductos')->name('FiltrarProductos');
 
Route::get('cart', 'ProductsController@cart')->name('cart');
 
Route::get('add-to-cart/{id}', 'ProductsController@addToCart');

Route::patch('update-cart', 'ProductsController@update');
 
Route::delete('remove-from-cart', 'ProductsController@remove');

// Trabajando con CRUD de productos

Route::get('product', 'ProductsController@ListarProductos')->name('product');
//Route::get('add-to-product', 'addProduct');
Route::get('product/add', 'ProductsController@add')->name('AddProduct');
Route::get('delete/{id}', 'ProductsController@delete')->name('delete');
Route::get('product/modify/{id}', 'ProductsController@modify')->name('modificar');
//Route::get('updateProduct/{id}', 'ProductsController@updateProducto')->name('updateProduct');
Route::get('update/{id}', 'ProductsController@update')->name('update');

Route::post('create', 'ProductsController@create');
Route::post('modify/{id}', 'ProductsController@updateProd');

//Route::get('add-to-product', 'ProductsController@create');

Route::get('payment',array(
    'as' => 'payment',
    'uses' => 'PaypalController@postPayment',
));

Route::get('paymentStatus',array(
    'as' => 'paymentStatus',
    'uses' => 'PaypalController@getPaymentStatus',
));