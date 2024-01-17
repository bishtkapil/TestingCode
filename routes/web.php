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

Route::get('/loginform', 'Testingcontroller@login');
Route::get('/testingform', 'Testingcontroller@index');
Route::post('/formstore', 'Testingcontroller@formstore');
Route::get('/edit/{id}', 'Testingcontroller@edit');
Route::post('/update/{id}', 'Testingcontroller@update');
Route::get('/delete/{id}', 'Testingcontroller@delete');

Route::get('/table', 'Testingcontroller@table');
Route::post('/save-to-database', 'Testingcontroller@saveToDatabase');
Route::get('/testingcode', 'Testingcontroller@testingcode');








Route::get('/select', 'Dependentcontroller@index');
Route::post('/selectstate', 'Dependentcontroller@selectstate');


Route::get('/login', 'Logincontroller@login');
Route::post('/loginsave', 'Logincontroller@loginsave');

// Route::get('/register', 'Logincontroller@register');
// Route::post('/registersave', 'Logincontroller@registersave');
// Route::get('/home', 'Logincontroller@home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/testingform', 'HomeController@form');
Route::post('/formstore', 'HomeController@formstore');
Route::get('/edit/{id}', 'HomeController@edit');
Route::post('/update/{id}', 'HomeController@update');
Route::get('/delete/{id}', 'HomeController@delete');

Route::get('/display', 'HomeController@display');

Route::get('/show', 'HomeController@show');

Route::get('/ajaxdisplay', 'HomeController@ajaxdisplay');
Route::get('/show', 'HomeController@show');

Route::get('getDatas', 'HomeController@getData');
Route::post('remove','HomeController@remove');
Route::post('getfilterData', 'HomeController@getfilterData');
// routes/web.php

Route::get('/download-pdf', 'HomeController@downloadPdf');

// routes/web.php

Route::get('/multiple', 'HomeController@multiple');
Route::post('/multiplestore', 'HomeController@multiplestore');




    /* Kit Module */

    Route::group(['namespace' => 'KitModule'], function() {


        Route::get('kit', 'KitController@index')->name('kit');
        Route::get('kit/add', 'KitController@create')->name('kit.create');
        Route::post('addmaster', 'KitController@addmaster');
        Route::post('addstore', 'KitController@addstore');

        Route::get('kitdashboard', 'KitController@kitdashboard')->name('kit.kitdashboard');
        Route::get('purchasedashboard', 'KitController@purchasedashboard');
        Route::get('distributedashboard', 'KitController@distributedashboard');
        Route::get('recieveditemsdashboard', 'KitController@recieveditemsdashboard');

        Route::get('getData', 'KitController@getData');
        Route::get('countData', 'KitController@countData');
        Route::post('filterData', 'YourController@filterData');

        // Route::post('filter', 'KitController@filter');

        Route::get('kit/master', 'KitController@master')->name('kit.master');
        Route::post('kit/store', 'KitController@store')->name('kit.store');
        Route::get('kit/display', 'KitController@display')->name('kit.display');

        Route::get('kit/view/{id}','KitController@view');
        Route::get('pagination/fetch_data', 'KitController@fetch_data');


        Route::get('DueList', 'KitController@DueList')->name('kit.DueList');
        Route::post('DueEmpList', 'KitController@DueEmpList')->name('kit.DueEmpList');
        Route::post('duesubmit', 'KitController@duesubmit');


        Route::get('due/{id}', 'KitController@due');

        Route::get('kitdistribution', 'KitController@kitdistribution')->name('kit.kitdistribution');
        Route::get('kitdistributiontable', 'KitController@kitdistributiontable')->name('kit.kitdistributiontable');
        Route::get('kitdistributionpost', 'KitController@kitdistributionpost');
        Route::post('distribution', 'KitController@distribution');


        Route::post('fetchFilteredItems', 'KitController@fetchFilteredItems');
        });
