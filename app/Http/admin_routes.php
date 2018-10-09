<?php

/* ================== Homepage ================== */
Route::auth();

Route::get('/admin', 'LA\Auth\AuthController@showLoginForm');
Route::get('/admin/', 'LA\Auth\AuthController@showLoginForm');
Route::get('/admin/login', 'LA\Auth\AuthController@showLoginForm');
Route::get('/admin/password/reset', 'LA\Auth\PasswordController@showLinkRequestForm');
Route::get('/admin/password/reset/{token}', 'LA\Auth\PasswordController@getReset');
Route::post('/admin/password/reset', 'LA\Auth\PasswordController@postReset');
Route::post('/admin/password/email', 'LA\Auth\PasswordController@postEmail');
Route::get('/admin/logout', 'LA\Auth\AuthController@logout');

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'LA\Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	/* ================== Dashboard ================== */
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	Route::post(config('laraadmin.adminRoute'). '/sendmail', 'LA\DashboardController@sendmail');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	
	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');
	
	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	
	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== Categories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/categories', 'LA\CategoriesController');
	Route::get(config('laraadmin.adminRoute') . '/category_dt_ajax', 'LA\CategoriesController@dtajax');

	/* ================== Products ================== */
	Route::resource(config('laraadmin.adminRoute') . '/products', 'LA\ProductsController');
	Route::get(config('laraadmin.adminRoute') . '/product_dt_ajax', 'LA\ProductsController@dtajax');

	/* ================== Banners ================== */
	Route::resource(config('laraadmin.adminRoute') . '/banners', 'LA\BannersController');
	Route::get(config('laraadmin.adminRoute') . '/banner_dt_ajax', 'LA\BannersController@dtajax');

	/* ================== Sizes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sizes', 'LA\SizesController');
	Route::get(config('laraadmin.adminRoute') . '/size_dt_ajax', 'LA\SizesController@dtajax');

	/* ================== SizeTypes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sizetypes', 'LA\SizeTypesController');
	Route::get(config('laraadmin.adminRoute') . '/sizetype_dt_ajax', 'LA\SizeTypesController@dtajax');

	/* ================== SizeTypeAssignToSizes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sizetypeassigntosizes', 'LA\SizeTypeAssignToSizesController');
	Route::get(config('laraadmin.adminRoute') . '/sizetypeassigntosize_dt_ajax', 'LA\SizeTypeAssignToSizesController@dtajax');

	/* ================== SizeGroups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sizegroups', 'LA\SizeGroupsController');
	Route::get(config('laraadmin.adminRoute') . '/sizegroup_dt_ajax', 'LA\SizeGroupsController@dtajax');

	/* ================== Currencies ================== */
	Route::resource(config('laraadmin.adminRoute') . '/currencies', 'LA\CurrenciesController');
	Route::get(config('laraadmin.adminRoute') . '/currency_dt_ajax', 'LA\CurrenciesController@dtajax');

	/* ================== ShippingCategories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/shippingcategories', 'LA\ShippingCategoriesController');
	Route::get(config('laraadmin.adminRoute') . '/shippingcategory_dt_ajax', 'LA\ShippingCategoriesController@dtajax');

	/* ================== ShippingPrices ================== */
	Route::resource(config('laraadmin.adminRoute') . '/shippingprices', 'LA\ShippingPricesController');
	Route::get(config('laraadmin.adminRoute') . '/shippingprice_dt_ajax', 'LA\ShippingPricesController@dtajax');

	/* ================== CalendarCategories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarcategories', 'LA\CalendarCategoriesController');
	Route::get(config('laraadmin.adminRoute') . '/calendarcategory_dt_ajax', 'LA\CalendarCategoriesController@dtajax');

	/* ================== CalendarDefaultSizes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendardefaultsizes', 'LA\CalendarDefaultSizesController');
	Route::get(config('laraadmin.adminRoute') . '/calendardefaultsize_dt_ajax', 'LA\CalendarDefaultSizesController@dtajax');

	/* ================== CalendarStyles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarstyles', 'LA\CalendarStylesController');
	Route::get(config('laraadmin.adminRoute') . '/calendarstyle_dt_ajax', 'LA\CalendarStylesController@dtajax');

	/* ================== CalendarStyleTypes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarstyletypes', 'LA\CalendarStyleTypesController');
	Route::get(config('laraadmin.adminRoute') . '/calendarstyletype_dt_ajax', 'LA\CalendarStyleTypesController@dtajax');

	/* ================== CalendarStyleEmbellishments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarstyleembellishments', 'LA\CalendarStyleEmbellishmentsController');
	Route::get(config('laraadmin.adminRoute') . '/calendarstyleembellishment_dt_ajax', 'LA\CalendarStyleEmbellishmentsController@dtajax');

	/* ================== CalendarStyleIdeaPages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarstyleideapages', 'LA\CalendarStyleIdeaPagesController');
	Route::get(config('laraadmin.adminRoute') . '/calendarstyleideapage_dt_ajax','LA\CalendarStyleIdeaPagesController@dtajax');

	/* ================== FinishingTouches ================== */
	Route::resource(config('laraadmin.adminRoute') . '/finishingtouches', 'LA\FinishingTouchesController');
	Route::get(config('laraadmin.adminRoute') . '/finishingtouch_dt_ajax', 'LA\FinishingTouchesController@dtajax');

	/* ================== CoverCategories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/covercategories', 'LA\CoverCategoriesController');
	Route::get(config('laraadmin.adminRoute') . '/covercategory_dt_ajax', 'LA\CoverCategoriesController@dtajax');

	/* ================== PhotoBookStyles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobookstyles', 'LA\PhotoBookStylesController');
	Route::get(config('laraadmin.adminRoute') . '/photobookstyle_dt_ajax', 'LA\PhotoBookStylesController@dtajax');

	/* ================== PhotoBooks ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobooks', 'LA\PhotoBooksController');
	Route::get(config('laraadmin.adminRoute') . '/photobook_dt_ajax', 'LA\PhotoBooksController@dtajax');

	/* ================== PhotoBookBackgrounds ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobookbackgrounds', 'LA\PhotoBookBackgroundsController');
	Route::get(config('laraadmin.adminRoute') . '/photobookbackground_dt_ajax', 'LA\PhotoBookBackgroundsController@dtajax');

	/* ================== PhotoBookEmbellishments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobookembellishments', 'LA\PhotoBookEmbellishmentsController');
	Route::get(config('laraadmin.adminRoute') . '/photobookembellishment_dt_ajax', 'LA\PhotoBookEmbellishmentsController@dtajax');

	/* ================== PhotoBookIdeaPages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobookideapages', 'LA\PhotoBookIdeaPagesController');
	Route::get(config('laraadmin.adminRoute') . '/photobookideapage_dt_ajax', 'LA\PhotoBookIdeaPagesController@dtajax');

	/* ================== EmailTemplates ================== */
	Route::resource(config('laraadmin.adminRoute') . '/emailtemplates', 'LA\EmailTemplatesController');
	Route::get(config('laraadmin.adminRoute') . '/emailtemplate_dt_ajax', 'LA\EmailTemplatesController@dtajax');

	/* ================== PromoCodes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/promocodes', 'LA\PromoCodesController');
	Route::get(config('laraadmin.adminRoute') . '/promocode_dt_ajax', 'LA\PromoCodesController@dtajax');

	/* ================== StaticPages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/staticpages', 'LA\StaticPagesController');
	Route::get(config('laraadmin.adminRoute') . '/staticpage_dt_ajax', 'LA\StaticPagesController@dtajax');
	
	/* ================= SavedProject ======================*/
	Route::get(config('laraadmin.adminRoute') . '/saved_project', 'LA\SavedProjectController@index');
	Route::get(config('laraadmin.adminRoute') . '/saved_project/{id}', 'LA\SavedProjectController@destroy');
	
	Route::get(config('laraadmin.adminRoute') . '/saved_project/view/{prj_id}/{order_id}', 'LA\SavedProjectController@show');
	
	Route::get(config('laraadmin.adminRoute') . '/saved_project/custom_view/{order_id}', 'LA\SavedProjectController@custom_show');
	
	Route::get(config('laraadmin.adminRoute') . '/saved_project/order_detail/{prj_id}/{order_id}', 'LA\SavedProjectController@order_detail');
	
	Route::get(config('laraadmin.adminRoute') . '/saved_project/custom_order_detail/{order_id}', 'LA\SavedProjectController@custom_order_detail');
	
	Route::get(config('laraadmin.adminRoute') . '/saved_project/view/pdf/{prj_id}/{order_id}', 'LA\SavedProjectController@download_pdf');
	
	Route::get(config('laraadmin.adminRoute') . '/saved_project/custom_view/pdf/{order_id}', 'LA\SavedProjectController@download_custom_pdf');
	
	Route::post(config('laraadmin.adminRoute') . '/saved_project/dt_ajax', 'LA\SavedProjectController@dtajax');
	
	/* ================= mmb request ================ */
	Route::get(config('laraadmin.adminRoute') . '/mmbrequest', 'LA\MmbRequestController@index');
	Route::get(config('laraadmin.adminRoute') . '/mmbrequest/view/{mmb_id}', 'LA\MmbRequestController@show');
	
	/* ================== PhotoBookDefaultPages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobookdefaultpages', 'LA\PhotoBookDefaultPagesController');
	Route::get(config('laraadmin.adminRoute') . '/photobookdefaultpage_dt_ajax', 'LA\PhotoBookDefaultPagesController@dtajax');

	/* ================== CalendarDefaultPages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendardefaultpages', 'LA\CalendarDefaultPagesController');
	Route::get(config('laraadmin.adminRoute') . '/calendardefaultpage_dt_ajax', 'LA\CalendarDefaultPagesController@dtajax');

	/* ================== CalendarLayouts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarlayouts', 'LA\CalendarLayoutsController');
	Route::get(config('laraadmin.adminRoute') . '/calendarlayout_dt_ajax', 'LA\CalendarLayoutsController@dtajax');

	/* ================== CalendarBackgrounds ================== */
	Route::resource(config('laraadmin.adminRoute') . '/calendarbackgrounds', 'LA\CalendarBackgroundsController');
	Route::get(config('laraadmin.adminRoute') . '/calendarbackground_dt_ajax', 'LA\CalendarBackgroundsController@dtajax');

	/* ================== PhotoBookLayouts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photobooklayouts', 'LA\PhotoBookLayoutsController');
	Route::get(config('laraadmin.adminRoute') . '/photobooklayout_dt_ajax', 'LA\PhotoBookLayoutsController@dtajax');

	/* ================== CoverSubCategories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/coversubcategories', 'LA\CoverSubCategoriesController');
	Route::get(config('laraadmin.adminRoute') . '/coversubcategory_dt_ajax', 'LA\CoverSubCategoriesController@dtajax');

	/* ================== CoverPrices ================== */
	Route::resource(config('laraadmin.adminRoute') . '/coverprices', 'LA\CoverPricesController');
	Route::get(config('laraadmin.adminRoute') . '/coverprice_dt_ajax', 'LA\CoverPricesController@dtajax');

	/* ================== ShareSiteCategories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sharesitecategories', 'LA\ShareSiteCategoriesController');
	Route::get(config('laraadmin.adminRoute') . '/sharesitecategory_dt_ajax', 'LA\ShareSiteCategoriesController@dtajax');

	/* ================== ShareSiteTemplateDesigns ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sharesitetemplatedesigns', 'LA\ShareSiteTemplateDesignsController');
	Route::get(config('laraadmin.adminRoute') . '/sharesitetemplatedesign_dt_ajax', 'LA\ShareSiteTemplateDesignsController@dtajax');

	/* ================== CollegePoserStyles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/collegeposerstyles', 'LA\CollegePoserStylesController');
	Route::get(config('laraadmin.adminRoute') . '/collegeposerstyle_dt_ajax', 'LA\CollegePoserStylesController@dtajax');

	/* ================== CollegePosterBackgrounds ================== */
	Route::resource(config('laraadmin.adminRoute') . '/collegeposterbackgrounds', 'LA\CollegePosterBackgroundsController');
	Route::get(config('laraadmin.adminRoute') . '/collegeposterbackground_dt_ajax', 'LA\CollegePosterBackgroundsController@dtajax');

	/* ================== CollegePosterLayouts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/collegeposterlayouts', 'LA\CollegePosterLayoutsController');
	Route::get(config('laraadmin.adminRoute') . '/collegeposterlayout_dt_ajax', 'LA\CollegePosterLayoutsController@dtajax');

	/* ================== CollegePosterDefaultPages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/collegeposterdefaultpages', 'LA\CollegePosterDefaultPagesController');
	Route::get(config('laraadmin.adminRoute') . '/collegeposterdefaultpage_dt_ajax', 'LA\CollegePosterDefaultPagesController@dtajax');
});
