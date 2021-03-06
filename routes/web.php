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

Route::get('/inschrijven%C2%A0', 'PagesController@inschrijven');
Route::get('/inschrijven', 'PagesController@inschrijven');
Route::get('/faq', 'FaqController@index');
Route::get('/particulier', 'PagesController@particulier');
Route::get('/voorwaarden', 'PagesController@voorwaarden');

Route::get('/', 'PagesController@home');

//Route::get('maakpdf', 'PdfController@maakpdf');


Route::get('/register/verify/{token}', 'Auth\RegisterController@verify'); 

//Auth::routes();

        // Authentication Routes...
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

		Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/faq/toevoegen', 'FaqController@create');
Route::post('/faq/store', 'FaqController@store');
Route::post('/faq/update', 'FaqController@update');
Route::get('/faq/edit/{id}', 'FaqController@edit');
Route::get('/faq/destroy/{id}', 'FaqController@destroy');

Route::get('/intermediairtypes/', 'IntermediairtypeController@index');
Route::get('/intermediairtypes/toevoegen', 'IntermediairtypeController@create');
Route::post('/intermediairtypes/store', 'IntermediairtypeController@store');
Route::post('/intermediairtypes/update', 'IntermediairtypeController@update');
Route::get('/intermediairtypes/edit/{id}', 'IntermediairtypeController@edit');
Route::get('/intermediairtypes/destroy/{id}', 'IntermediairtypeController@destroy');


Route::post('/search', 'SearchController@index');
Route::get('/search', 'SearchController@index');

Route::get('/blacklist', 'BlacklistController@index');
Route::get('/blacklist/toevoegen/', 'BlacklistController@create');
Route::post('/blacklist/store', 'BlacklistController@store');
Route::post('/blacklist/update', 'BlacklistController@update');
Route::get('/blacklist/edit/{id}', 'BlacklistController@edit');
Route::get('/blacklist/destroy/{id}', 'BlacklistController@destroy');

Route::get('contacts/index', 'ContactController@index')->middleware('auth');
Route::get('contacts/show/{id}', 'ContactController@show')->middleware('auth');
Route::get('contacts/edit/{id}', 'ContactController@edit')->middleware('auth');

Route::get('users', 'UserController@index')->middleware('auth');
Route::get('users/index', 'UserController@index')->middleware('auth');
Route::get('users/downloads/{id}', 'UserController@downloads')->middleware('auth');
Route::get('user/toggleactive/{id}', 'UserController@toggleactive')->middleware('auth');
Route::get('user/manualemailverification/{id}', 'UserController@manualemailverification')->middleware('auth');
Route::get('user/show/{id}', 'UserController@show')->middleware('auth');
Route::get('user/edit/{id}', 'UserController@edit')->middleware('auth');
Route::post('user/updatename/', 'UserController@updatename')->middleware('auth');
Route::post('user/updateemail/', 'UserController@updateemail')->middleware('auth');
Route::post('user/updatepassword/', 'UserController@updatepassword')->middleware('auth');
Route::get('user/destroy/{id}', 'UserController@destroy')->middleware('auth');
Route::get('user/redirecttointermediair/{id}', 'UserController@redirecttointermediair')->middleware('auth');
Route::get('user/onhold/{id}', 'UserController@onhold')->middleware('auth');
Route::get('user/outhold/{id}', 'UserController@outhold')->middleware('auth');

Route::get('/home', 'HomeController@index')->middleware('auth');
Route::get('/redeemed', 'RedeemedController@index')->middleware('auth');
Route::get('/docs', 'HomeController@docs')->middleware('auth');

/*
Route::get('intermediairs', 'IntermediairController@index')->middleware('auth');
Route::post('intermediairs', 'IntermediairController@store')->middleware('auth');
Route::get('/intermediairs/create', 'IntermediairController@create')->middleware('auth');
Route::get('/intermediairs/show/{id}', 'IntermediairController@show')->middleware('auth');
Route::get('/intermediairs/destroy/{id}', 'IntermediairController@destroy')->middleware('auth');
Route::get('/intermediair/edit/{id}', 'IntermediairController@edit')->middleware('auth');
Route::get('/intermediair/downloads/', 'IntermediairController@downloads')->middleware('auth');
Route::post('intermediairs/update', 'IntermediairController@update')->middleware('auth');
Route::get('intermediairs/zonderdownloads', 'IntermediairController@zonderdownloads')->middleware('auth');
 */

Route::get('/familie/toevoegen/{id}', 'FamilyController@create')->middleware('auth');
Route::post('familys/store', 'FamilyController@store')->middleware('auth');
Route::get('/family/show/{id}', 'FamilyController@show')->middleware('auth');
Route::get('/family/edit/{id}', 'FamilyController@edit')->middleware('auth');
Route::post('/family/update/', 'FamilyController@update')->middleware('auth');
Route::get('/family/destroy/{id}', 'FamilyController@destroy')->middleware('auth');
Route::get('/family/goedkeuren/{id}', 'FamilyController@goedkeuren')->middleware('auth');
Route::get('family/aanmelden/{id}', 'FamilyController@aanmelden')->middleware('auth');
Route::get('family/afkeuren/{id}', 'FamilyController@afkeuren')->middleware('auth');
Route::post('family/afkeuren/', 'FamilyController@setafkeurtext')->middleware('auth');
Route::get('family/intrekken/{id}', 'FamilyController@aanmeldingintrekken')->middleware('auth');
Route::get('family/onhold/{id}', 'FamilyController@onhold')->middleware('auth');
Route::get('family/outhold/{id}', 'FamilyController@outhold')->middleware('auth');

Route::get('/kids/toevoegen/{id}', 'KidController@create')->middleware('auth');
Route::get('/kids/destroy/{id}', 'KidController@destroy')->middleware('auth');
Route::get('/kids/show/{id}', 'KidController@show')->middleware('auth');
Route::get('/kids/edit/{id}', 'KidController@edit')->middleware('auth');
Route::post('/kids/update/', 'KidController@update')->middleware('auth');
Route::post('kids/store', 'KidController@store')->middleware('auth');

Route::get('/barcodes/', 'BarcodeController@index')->middleware('auth');
Route::post('barcodes/upload', 'BarcodeController@store')->middleware('auth');
Route::get('/extrabarcodes', 'BarcodeController@extrabarcodes')->middleware('auth');
Route::get('/barcodereview', 'BarcodeController@barcodereview')->middleware('auth');
Route::post('barcodes/eindlijst_upload', 'BarcodeController@eindlijst_upload')->middleware('auth');
Route::post('barcodes/claimlossebarcodes', 'BarcodeController@claimlossebarcodes')->middleware('auth');
Route::get('barcodes/ongebruikt/{id}', 'BarcodeController@nietgebruiktperintermediair')->middleware('auth');
Route::get('barcodes/tabelongebruikt/{id}', 'BarcodeController@tabelnietgebruiktperintermediair')->middleware('auth');
Route::post('barcodes/doorgeven_reden_nietgebruik/', 'BarcodeController@doorgeven_reden_nietgebruik')->middleware('auth');
Route::get('/barcodereview/datums', 'BarcodeController@barcodereviewopdatum')->middleware('auth');
Route::get('/barcodereview/intermediairsmetongebruiktecodes', 'BarcodeController@nabeschouwingperintermediair')->middleware('auth');




Route::get('settings', 'SettingsController@index')->middleware('auth');
Route::post('settings/update/{id}', 'SettingsController@update')->middleware('auth'); 

Route::get('/postcode-nl/address/{postcode}/{houseNumber}/{houseNumberAddition?}', 'AddressController@get')->middleware('auth');

Route::get('/download/pdfvoorkind/{id}', 'DownloadController@pdfvoorkind')->middleware('auth');
Route::get('/download/extrapdf/{id}', 'DownloadController@extrapdf')->middleware('auth');

Route::get('/download/kidpdf/{id}', 'DownloadController@barcodefetcher')->middleware('auth');


Route::get('/template/', 'SettingsController@emailpreview')->middleware('auth');
Route::get('/sendmailform/', 'SettingsController@sendmailform')->middleware('auth');
Route::post('/sendmail/', 'SettingsController@sendmail')->middleware('auth');


Route::get('/tellingen/', 'HomeController@tellingen')->middleware('auth');
Route::get('/kinderlijst/', 'HomeController@kinderlijst')->middleware('auth'); 
Route::get('/gezinnenlijst/', 'HomeController@gezinnenlijst')->middleware('auth'); 
Route::get('/gezinnenlijst_goedgekeurd/', 'HomeController@gezinnenlijst_goedgekeurd')->middleware('auth'); 

Route::get('/gezinnenlijst_nogaantemelden/', 'HomeController@gezinnenlijst_nogaantemelden')->middleware('auth'); 

Route::get('/emailtest/', 'SettingsController@sendMailToIntermediairs')->middleware('auth');

Route::get('/maillijsten/', 'MaillijstenController@index')->middleware('auth');

Route::get('/exporteren/', 'ExportController@index')->middleware('auth');
Route::get('/exportselector/{selector}', 'ExportController@exportselector')->middleware('auth');


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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
