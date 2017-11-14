<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*
Route::get('/', function () {
    return redirect('home');
});
Route::get('/inschrijven', function () {
    return view('inschrijven');
});

Route::get('/particulier', function () {
    return view('particulier');
});

Route::get('/voorwaarden', function () {
    return view('voorwaarden');
});
*/
Route::get('/inschrijven', 'PagesController@inschrijven');
Route::get('/particulier', 'PagesController@particulier');
Route::get('/voorwaarden', 'PagesController@voorwaarden');
Route::get('/', 'PagesController@home');

//Route::get('maakpdf', 'PdfController@maakpdf');


Route::get('/register/verify/{token}', 'Auth\RegisterController@verify'); 


        /*
            Hieronder de profisorische oplossing om de inschrijvingen tegen te houden. Dit moet worden opgelost. 
        */
			Route::get('/register/', 'Auth\RegisterController@register'); 
            

        /*
            ---
        */  

Auth::routes();

Route::get('contacts/index', 'ContactController@index')->middleware('auth');
Route::get('contacts/show/{id}', 'ContactController@show')->middleware('auth');
Route::get('contacts/edit/{id}', 'ContactController@edit')->middleware('auth');

Route::get('users/index', 'UserController@index')->middleware('auth');
Route::get('user/toggleactive/{id}', 'UserController@toggleactive')->middleware('auth');
Route::get('user/manualemailverification/{id}', 'UserController@manualemailverification')->middleware('auth');
Route::get('user/show/{id}', 'UserController@show')->middleware('auth');
Route::get('user/edit/{id}', 'UserController@edit')->middleware('auth');
Route::post('user/updatename/', 'UserController@updatename')->middleware('auth');
Route::post('user/updateemail/', 'UserController@updateemail')->middleware('auth');
Route::post('user/updatepassword/', 'UserController@updatepassword')->middleware('auth');
Route::get('user/destroy/{id}', 'UserController@destroy')->middleware('auth');
Route::get('user/redirecttointermediair/{id}', 'UserController@redirecttointermediair')->middleware('auth');

Route::get('/home', 'HomeController@index')->middleware('auth');

Route::get('/docs', 'HomeController@docs')->middleware('auth');

Route::get('intermediairs', 'IntermediairController@index')->middleware('auth');
Route::post('intermediairs', 'IntermediairController@store')->middleware('auth');
Route::get('/intermediairs/create', 'IntermediairController@create')->middleware('auth');
Route::get('/intermediairs/show/{id}', 'IntermediairController@show')->middleware('auth');
Route::get('/intermediairs/destroy/{id}', 'IntermediairController@destroy')->middleware('auth');
Route::get('/intermediair/edit/{id}', 'IntermediairController@edit')->middleware('auth');
Route::get('/intermediair/downloads/', 'IntermediairController@downloads')->middleware('auth');
Route::post('intermediairs/update', 'IntermediairController@update')->middleware('auth');

Route::get('/familie/toevoegen/{id}', 'FamilyController@create')->middleware('auth');
Route::post('familys/store', 'FamilyController@store')->middleware('auth');
Route::get('/family/show/{id}', 'FamilyController@show')->middleware('auth');
Route::get('/family/edit/{id}', 'FamilyController@edit')->middleware('auth');
Route::post('/family/update/', 'FamilyController@update')->middleware('auth');
Route::get('/family/destroy/{id}', 'FamilyController@destroy')->middleware('auth');
Route::get('/family/toggleok/{id}', 'FamilyController@toggleok')->middleware('auth');
Route::get('family/aanmelden/{id}', 'FamilyController@aanmelden')->middleware('auth');
Route::get('family/afkeuren/{id}', 'FamilyController@afkeuren')->middleware('auth');
Route::post('family/afkeuren/', 'FamilyController@setafkeurtext')->middleware('auth');
Route::get('family/intrekken/{id}', 'FamilyController@aanmeldingintrekken')->middleware('auth');

Route::get('/kids/toevoegen/{id}', 'KidController@create')->middleware('auth');
Route::get('/kids/destroy/{id}', 'KidController@destroy')->middleware('auth');
Route::get('/kids/show/{id}', 'KidController@show')->middleware('auth');
Route::get('/kids/edit/{id}', 'KidController@edit')->middleware('auth');
Route::post('/kids/update/', 'KidController@update')->middleware('auth');
Route::post('kids/store', 'KidController@store')->middleware('auth');

Route::get('/barcodes/', 'BarcodeController@index')->middleware('auth');
Route::post('barcodes/upload', 'BarcodeController@store')->middleware('auth');

Route::get('settings', 'SettingsController@index')->middleware('auth');
Route::post('settings/update/{id}', 'SettingsController@update')->middleware('auth');

Route::get('/postcode-nl/address/{postcode}/{houseNumber}/{houseNumberAddition?}', 'AddressController@get')->middleware('auth');

Route::get('/download/pdfvoorkind/{id}', 'DownloadController@pdfvoorkind')->middleware('auth');

Route::get('/download/kidpdf/{id}', 'DownloadController@barcodefetcher')->middleware('auth');

Route::get('/template/', 'SettingsController@emailpreview')->middleware('auth');
Route::get('/sendmailform/', 'SettingsController@sendmailform')->middleware('auth');
Route::post('/sendmail/', 'SettingsController@sendmail')->middleware('auth');


Route::get('/tellingen/', 'HomeController@tellingen')->middleware('auth');; 
Route::get('/kinderlijst/', 'HomeController@kinderlijst')->middleware('auth');; 
Route::get('/gezinnenlijst/', 'HomeController@gezinnenlijst')->middleware('auth');; 
Route::get('/gezinnenlijst_goedgekeurd/', 'HomeController@gezinnenlijst_goedgekeurd')->middleware('auth');; 

Route::get('/gezinnenlijst_nogaantemelden/', 'HomeController@gezinnenlijst_nogaantemelden')->middleware('auth');; 

Route::get('/emailtest/', 'SettingsController@sendMailToIntermediairs')->middleware('auth');; 

/*
*
* Opschonen (depricated)
*
 
	Route::get('/download/verzendlijst/', 'DownloadController@verzendlijst'); 
	Route::get('/download/intertoyslijst/', 'DownloadController@intertoyslijst'); 

*
* --einde opschonen
*
*/