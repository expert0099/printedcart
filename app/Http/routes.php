<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::auth();
/* Route::group(['domain' => '{account_alias}.'.env('APP_URL_NAME')], function () {
    Route::group([ 'prefix' => 'app', 'middleware' => 'auth', 'middleware' => 'auth.manager' ], function() {
        Route::get('dashboard', 'DashController@index');
	}
} */
Route::group(['domain' => '{subdomain}.printedcart.com'], function(){
	Route::get('/', 'SubdomainedController@index');
	Route::post('/change_picture', 'SubdomainedController@change_picture');
	Route::post('/add_event', 'SubdomainedController@add_event');
	Route::post('/upload_pictures', 'SubdomainedController@upload_pictures');
	Route::post('/upload_videos', 'SubdomainedController@upload_videos');
});
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/user/login', 'Auth\AuthController@showLoginForm');
Route::get('/user/register', 'Auth\AuthController@showRegistrationForm');
Route::get('/user/my_photos', 'UserController@my_photos');
Route::get('/user/my_projects/{slug}', 'UserController@my_projects');
Route::get('/user/delete_project/{project_id}/{slug}', 'UserController@delete_project');
Route::get('/user/logout', 'Auth\AuthController@logout');
/* Route::get('/user/logout', function(){
   Auth::logout();
   return Redirect::to('/user/logout_verify');
}); */
Route::get('/user/logout_verify','HomeController@logout_verify');
Route::get('/user/section', 'UserController@section');
Route::get('/user/section/pdfview/{prj_id}', 'UserController@pdfview');
Route::get('/user/section/pdfview/{prj_id}/{order_id}', 'UserController@download_pdf');
Route::post('/user/add_album', 'UserController@add_album');
Route::post('/user/add_photo', 'UserController@add_photo');
Route::post('/user/edit_photo', 'UserController@edit_photo');
Route::get('/user/my_photos/album/{album}', 'UserController@get_album_photos');
Route::post('/user/my_photos/getExistAlbum', 'UserController@getExistAlbum');
Route::post('/user/save_info', 'UserController@save_info');
Route::post('/user/account_info', 'UserController@account_info');
Route::get('/user/del_album/{id}', 'UserController@del_album');
Route::get('/user/del_photo/{id}', 'UserController@del_photo');
Route::get('/user/feedback', 'UserController@feedback');
Route::post('/user/feedback', 'UserController@feedback_post');
Route::get('/user/account_activate/{email}', 'UserController@account_verify');
/* =============== paypal =============== */
Route::post('/paywithpaypal', 'PaypalController@paywithpaypal');
Route::get('/paypal/return', 'PaypalController@paypalReturn');
Route::get('/paypal/cancel', 'PaypalController@paypalCancel');
Route::post('/paywithautherized', 'AutherizedController@paywithautherized');
Route::get('/payments/success', 'PaypalController@success');
Route::post('/payment_process', 'PaymentController@payment_process');
/* ================ newsletter subscriber ================ */
Route::post('/newsletter', 'HomeController@newsletter');
/* =============== request quote =============== */
Route::post('/request_quote', 'HomeController@request_quote');
/* ========= sitemap ========== */
Route::get('/sitemap', 'SitemapController@sitemap');
/* ============ search ============= */
Route::get('typeahead-response',array('as'=>'typeahead.response','uses'=>'SearchController@typeahead'));
Route::post('/search', 'SearchController@search_submit');
/* =============== payments ================ */
Route::group(['prefix' => 'payments', 'as' => 'payments.'], function(){
	Route::post('/shipping_address', 'PaymentController@shipping_address');
	//Route::get('/cart/{type}', 'PaymentController@cart');
	Route::get('/cart', 'PaymentController@cart');
	Route::post('/remove_cart', 'PaymentController@remove_cart');
	Route::post('/get_shiiping_address', 'PaymentController@get_shiiping_address');
	
	Route::get('resend_verify_mail/{email}', 'PaymentController@resend_verify_mail');
	Route::get('verify_mail_confirm', 'PaymentController@verify_mail_confirm');
	Route::get('account_activate/{email}', 'PaymentController@account_verify');
});
/* =============upload image============ */
Route::post('/uploadFile', 'UserController@uploadFile');
/* ================ Cart ===============*/
Route::group(['prefix' => 'cart', 'as' => 'cart.'], function(){
	Route::post('/add_to_cart', 'CartController@add_to_cart');
});
/* ================= Share Site ====================*/
Route::group(['prefix' => 'sharesite', 'as' => 'sharesite.'], function(){
	Route::get('/', 'SharesiteController@sharesite');
	Route::post('/delete_site', 'SharesiteController@delete_site');
	Route::post('/share_to_friend', 'SharesiteController@share_to_friend');
	Route::get('/index', 'SharesiteController@index');
	Route::get('/makeasite/{id}', 'SharesiteController@makeasite');
	Route::post('/makeasite_post', 'SharesiteController@makeasite_post');
	Route::get('/choose_design/{id}', 'SharesiteController@choose_design');
	Route::post('/choose_design', 'SharesiteController@choose_design_post');
	
});
/* ================== Calendars ================== */
Route::group(['prefix' => 'calendars', 'as' => 'calendars.'], function(){
	Route::get('/', 'CalendarsController@index');
	Route::get('/wall_calendars', function(){
		return redirect('calendars');
	});
	Route::post('/wall_calendars', 'CalendarsController@wall_calendar');
	Route::get('/wall_calendars/{calendarstyle}/{calendar_size_id}/{month}/{year}', 'CalendarsController@get_calendar_styles');
	
	Route::get('/cal_editor/{calendar_id}/{calendar_size_id}', 'CalendarsController@cal_editor');
	Route::get('/cal_editor/{calendar_id}/{calendar_size_id}/{calendar_category}/{month}/{year}', 'CalendarsController@cal_editor');
	Route::post('/save_project', 'CalendarsController@save_project');
	Route::post('/save_calendar', 'CalendarsController@save_calendar');
	Route::get('/get_calendar_preview/{project_id}', 'CalendarsController@get_calendar_preview');
	
	Route::get('/get_calendar_status/{project_id}', 'CalendarsController@get_calendar_status');
	Route::post('/add_to_cart', 'CalendarController@add_to_cart');
		
	Route::get('/easel_calendars', 'CalendarsController@easel_calendars');
	Route::post('/easel_calendars', 'CalendarsController@get_easel_calendars');
	Route::post('/easel','CalendarsController@easel_post');
	Route::get('/easel/{style_id}/{size_id}/{calendar_category}','CalendarsController@easel');
	Route::get('/calendar_posters', 'CalendarsController@calendar_posters');
	Route::post('/calendar_posters', 'CalendarsController@get_calendar_posters');
	Route::get('/colposview/{calendar_id}/{calendar_category_id}', 'CalendarsController@colposview');
	Route::post('/colposter', 'CalendarsController@colposter');
	
	Route::get('/desk', 'CalendarsController@desk_calendar');
	Route::post('/desk', 'CalendarsController@get_desk_calendar');
	
	Route::get('/poster_editor/{calendar_id}/{calendar_size_id}/{calendar_category}/{year}', 'CalendarsController@poster_editor');
	Route::post('/save_poster', 'CalendarsController@save_poster');
	Route::get('/htmltopdfview/{project_id}/{pdf}',array('as'=>'htmltopdfview','uses'=>'CalendarsController@htmltopdfview'));
	
	Route::post('/crop_image', 'CalendarsController@crop_image');

	
});
/* ================== Photobooks ================== */
Route::group(['prefix' => 'photobooks', 'as' => 'photobooks.'], function(){
	Route::get('/', 'PhotobookController@index');
	/** custom path **/
	Route::get('/custom_path', 'PhotobookController@custom_path');
	Route::post('/custom_path', 'PhotobookController@post_editor_custom_path');
	Route::get('/editor_custom_path/{photobook_id}/{photobook_size}/{project_id}', 'PhotobookController@editor_custom_path');
	Route::get('/custom_path/project/{project_id}', 'PhotobookController@editor_custom_path_cp');
	Route::get('/custom_path/{photobookstyle}', 'PhotobookController@get_photo_books');
	Route::post('/save_project', 'PhotobookController@save_project');
	/** end custom path **/
	/** simple path **/
	Route::get('/simple_path', 'PhotobookController@simple_path');
	Route::get('/editor_simple_path/{size_id}', 'PhotobookController@editor_simple_path');
	/** end simple path **/
	/** make my book **/
	Route::get('/make_my_book', 'PhotobookController@make_my_book');
	Route::get('/mmb', 'PhotobookController@mmb');
	Route::get('/mmb/{photobookstyle}', 'PhotobookController@get_mmb_photo_books');
	Route::get('/mmb_fitch/{id}', 'PhotobookController@mmb_fitch');
	Route::post('/mmb/store', 'PhotobookController@mmb_store');
	Route::get('/mmb_complete/{mmb_id}', 'PhotobookController@mmb_complete');
	/** end make my book **/
	Route::get('/get_book_styles/{photobook_id}/{size_id}', 'PhotobookController@get_book_styles');
	Route::get('/get_photobook_price/{size_id}/{cover_id}', 'PhotobookController@get_photobook_price');
	Route::post('/upload_new_images', 'PhotobookController@upload_new_images');
	Route::post('/upload_new_images_ajax', 'PhotobookController@upload_new_images_ajax');
	Route::post('/add_new_album', 'PhotobookController@add_new_album');
	Route::post('/add_new_album_ajax', 'PhotobookController@add_new_album_ajax');
	Route::get('/addmore_page/{w}/{h}', 'PhotobookController@addmore_page');
	Route::get('/custom_path/project/addmore_page/{w}/{h}', 'PhotobookController@addmore_page');
	Route::post('/save_photobook', 'PhotobookController@save_photobook');
	Route::post('/custom_path/project/save_photobook', 'PhotobookController@save_photobook');
	Route::get('/get_photobook_preview/{project_id}', 'PhotobookController@get_photobook_preview');
	Route::get('/custom_path/project/get_photobook_preview/{project_id}', 'PhotobookController@get_photobook_preview');
	Route::get('/htmltopdfview/{project_id}/{pdf}',array('as'=>'htmltopdfview','uses'=>'PhotobookController@htmltopdfview'));
	Route::get('/get_photobook_status/{project_id}', 'PhotobookController@get_photobook_status');
	Route::post('/add_to_cart', 'PhotobookController@add_to_cart');
	Route::get('/shipping_address_status', 'PhotobookController@shipping_address_status');
	Route::get('/shipping_price', 'PhotobookController@shipping_price');
	Route::get('/cover_pricing_detail','PhotobookController@cover_pricing_detail');
});
/* ================== Posters ================== */
Route::group(['prefix' => 'posters', 'as' => 'posters.'], function(){
	Route::get('/', 'PosterController@index');
});
/* ================== Prints ================== */
Route::group(['prefix' => 'prints', 'as' => 'prints.'], function(){
	Route::get('/', 'PrintController@index');
	Route::get('/large_format_print', 'PrintController@large_format_print');
	Route::post('/add_photo', 'PrintController@add_photo');
	Route::post('/alter_image', 'PrintController@alter_image');
	Route::post('/print_form_submit', 'PrintController@print_form_submit');
	
	Route::get('/college_poster', 'PrintController@college_poster');
	Route::post('/college_poster', 'PrintController@get_college_poster');
	Route::get('/colposview/{poster_id}', 'PrintController@colposview');
	Route::post('/colposter', 'PrintController@colposter');
	Route::get('/poster_editor/{poster_id}/{calendar_size_id}', 'PrintController@poster_editor');
	
	Route::get('resend_verify_mail/{email}', 'CustomCartController@resend_verify_mail');
	Route::get('verify_mail_confirm', 'CustomCartController@verify_mail_confirm');
	Route::get('account_activate/{email}', 'CustomCartController@account_verify');
	
	Route::post('/add_to_cart', 'PrintController@add_to_cart');
});
/* ================== Custom Cart ==================== */
Route::get('/custom_cart', 'CustomCartController@show_cart');
Route::post('/custom_cart_remove', 'CustomCartController@custom_cart_remove');
Route::post('/custom_payment_process', 'CustomCartController@custom_payment_process');
/* ================== Pages ================== */
Route::group(['prefix' => 'pages', 'as' => 'pages.'], function(){
	Route::get('/{page_slug}', 'PagesController@pages');
	Route::post('/contact', 'PagesController@contact');
});
/* ============== social routes ============== */
Route::get('/user/instagram', 'UserController@instagram_authentication');
Route::get('/user/instagram_photo', 'UserController@instagram_photo');
Route::post('/user/add_insta_photo', 'UserController@add_insta_photo');
Route::get('/user/glogin',array('uses'=>'UserController@googleLogin'));
Route::post('/user/add_google_photo', 'UserController@add_google_photo');
//Route::get('/user/google-user',array('uses'=>'UserController@listGoogleUserPhoto'));
Route::get('user/login/callback',array('as'=>'user.fblogin','uses'=>'UserController@fbSignUp'));
Route::get('user/facebook/login',array('as'=>'user.facebook.login','uses'=>'UserController@facebookLogin'));
/* ================== Admin Routes ================== */
require __DIR__.'/admin_routes.php';