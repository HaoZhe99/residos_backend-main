<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Tenant Controls
    Route::delete('tenant-controls/destroy', 'TenantControlController@massDestroy')->name('tenant-controls.massDestroy');
    Route::resource('tenant-controls', 'TenantControlController');


    // Family Controls
    Route::delete('family-controls/destroy', 'FamilyControlController@massDestroy')->name('family-controls.massDestroy');
    Route::resource('family-controls', 'FamilyControlController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Generals
    Route::resource('generals', 'GeneralController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Designs
    Route::resource('designs', 'DesignController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Seos
    Route::resource('seos', 'SeoController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountriesController');

    // States
    Route::delete('states/destroy', 'StatesController@massDestroy')->name('states.massDestroy');
    Route::resource('states', 'StatesController');

    // Areas
    Route::delete('areas/destroy', 'AreaController@massDestroy')->name('areas.massDestroy');
    Route::resource('areas', 'AreaController');

    // User Applications
    Route::resource('user-applications', 'UserApplicationController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Admin Applications
    Route::resource('admin-applications', 'AdminApplicationController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Sms Settings
    Route::resource('sms-settings', 'SmsSettingController');

    // E Mail Settings
    Route::resource('e-mail-settings', 'EMailSettingController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Payment Settings
    Route::delete('payment-settings/destroy', 'PaymentSettingController@massDestroy')->name('payment-settings.massDestroy');
    Route::resource('payment-settings', 'PaymentSettingController');

    // Developer Listings
    Route::delete('developer-listings/destroy', 'DeveloperListingController@massDestroy')->name('developer-listings.massDestroy');
    Route::resource('developer-listings', 'DeveloperListingController');

    // Project Categories
    Route::delete('project-categories/destroy', 'ProjectCategoryController@massDestroy')->name('project-categories.massDestroy');
    Route::resource('project-categories', 'ProjectCategoryController');

    // Project Types
    Route::delete('project-types/destroy', 'ProjectTypeController@massDestroy')->name('project-types.massDestroy');
    Route::resource('project-types', 'ProjectTypeController');

    // Project Listings
    Route::PUT('project-listings/approve_project/{id}', 'ProjectListingController@approve_project')->name('project-listings.approve_project');
    Route::delete('project-listings/destroy', 'ProjectListingController@massDestroy')->name('project-listings.massDestroy');
    Route::resource('project-listings', 'ProjectListingController');

    // Pics
    Route::delete('pics/destroy', 'PicController@massDestroy')->name('pics.massDestroy');
    Route::resource('pics', 'PicController');

    // Social Logins
    Route::delete('social-logins/destroy', 'SocialLoginController@massDestroy')->name('social-logins.massDestroy');
    Route::resource('social-logins', 'SocialLoginController');

    // Content Listings
    Route::get('notifications/read', 'ContentListingController@read');
    Route::delete('content-listings/destroy', 'ContentListingController@massDestroy')->name('content-listings.massDestroy');
    Route::post('content-listings/media', 'ContentListingController@storeMedia')->name('content-listings.storeMedia');
    Route::post('content-listings/ckmedia', 'ContentListingController@storeCKEditorImages')->name('content-listings.storeCKEditorImages');
    Route::resource('content-listings', 'ContentListingController');

    // Content Types
    Route::delete('content-types/destroy', 'ContentTypeController@massDestroy')->name('content-types.massDestroy');
    Route::resource('content-types', 'ContentTypeController');

    // Feedback Categories
    Route::delete('feedback-categories/destroy', 'FeedbackCategoryController@massDestroy')->name('feedback-categories.massDestroy');
    Route::resource('feedback-categories', 'FeedbackCategoryController');

    // Feedback Listings
    Route::delete('feedback-listings/destroy', 'FeedbackListingController@massDestroy')->name('feedback-listings.massDestroy');
    Route::post('feedback-listings/media', 'FeedbackListingController@storeMedia')->name('feedback-listings.storeMedia');
    Route::post('feedback-listings/ckmedia', 'FeedbackListingController@storeCKEditorImages')->name('feedback-listings.storeCKEditorImages');
    Route::resource('feedback-listings', 'FeedbackListingController');

    // Vehicle Brands
    Route::delete('vehicle-brands/destroy', 'VehicleBrandController@massDestroy')->name('vehicle-brands.massDestroy');
    Route::resource('vehicle-brands', 'VehicleBrandController');

    // Vehicle Models
    Route::delete('vehicle-models/destroy', 'VehicleModelController@massDestroy')->name('vehicle-models.massDestroy');
    Route::resource('vehicle-models', 'VehicleModelController');

    // Vehicle Managements
    Route::delete('vehicle-managements/destroy', 'VehicleManagementController@massDestroy')->name('vehicle-managements.massDestroy');
    Route::resource('vehicle-managements', 'VehicleManagementController');

    // Carparklocations
    Route::delete('carparklocations/destroy', 'CarparklocationController@massDestroy')->name('carparklocations.massDestroy');
    Route::resource('carparklocations', 'CarparklocationController');

    // Vehicle Logs
    Route::delete('vehicle-logs/destroy', 'VehicleLogController@massDestroy')->name('vehicle-logs.massDestroy');
    Route::resource('vehicle-logs', 'VehicleLogController');

    // Event Categories
    Route::delete('event-categories/destroy', 'EventCategoryController@massDestroy')->name('event-categories.massDestroy');
    Route::resource('event-categories', 'EventCategoryController');

    // Defect Categories
    Route::delete('defect-categories/destroy', 'DefectCategoryController@massDestroy')->name('defect-categories.massDestroy');
    Route::resource('defect-categories', 'DefectCategoryController');

    // Status Controls
    Route::delete('status-controls/destroy', 'StatusControlController@massDestroy')->name('status-controls.massDestroy');
    Route::resource('status-controls', 'StatusControlController');

    // Defect Listings
    Route::delete('defect-listings/destroy', 'DefectListingController@massDestroy')->name('defect-listings.massDestroy');
    Route::post('defect-listings/media', 'DefectListingController@storeMedia')->name('defect-listings.storeMedia');
    Route::post('defect-listings/ckmedia', 'DefectListingController@storeCKEditorImages')->name('defect-listings.storeCKEditorImages');
    Route::resource('defect-listings', 'DefectListingController');

    // Facility Categories
    Route::delete('facility-categories/destroy', 'FacilityCategoryController@massDestroy')->name('facility-categories.massDestroy');
    Route::resource('facility-categories', 'FacilityCategoryController');

    // Facility Listings
    Route::delete('facility-listings/destroy', 'FacilityListingController@massDestroy')->name('facility-listings.massDestroy');
    Route::post('facility-listings/media', 'FacilityListingController@storeMedia')->name('facility-listings.storeMedia');
    Route::post('facility-listings/ckmedia', 'FacilityListingController@storeCKEditorImages')->name('facility-listings.storeCKEditorImages');
    Route::resource('facility-listings', 'FacilityListingController');

    // Facility Books
    Route::delete('facility-books/destroy', 'FacilityBookController@massDestroy')->name('facility-books.massDestroy');
    Route::resource('facility-books', 'FacilityBookController');

    // Facility Maintains
    Route::delete('facility-maintains/destroy', 'FacilityMaintainController@massDestroy')->name('facility-maintains.massDestroy');
    Route::resource('facility-maintains', 'FacilityMaintainController');

    // Locations
    Route::delete('locations/destroy', 'LocationController@massDestroy')->name('locations.massDestroy');
    Route::resource('locations', 'LocationController');

    // Gateways
    Route::delete('gateways/destroy', 'GatewayController@massDestroy')->name('gateways.massDestroy');
    Route::resource('gateways', 'GatewayController');

    // Qrs
    Route::delete('qrs/destroy', 'QrController@massDestroy')->name('qrs.massDestroy');
    Route::resource('qrs', 'QrController');

    // Gate Histories
    Route::delete('gate-histories/destroy', 'GateHistoryController@massDestroy')->name('gate-histories.massDestroy');
    Route::resource('gate-histories', 'GateHistoryController');

    // Event Listings
    Route::delete('event-listings/destroy', 'EventListingController@massDestroy')->name('event-listings.massDestroy');
    Route::post('event-listings/media', 'EventListingController@storeMedia')->name('event-listings.storeMedia');
    Route::post('event-listings/ckmedia', 'EventListingController@storeCKEditorImages')->name('event-listings.storeCKEditorImages');
    Route::resource('event-listings', 'EventListingController');

    // Event Enrolls
    Route::delete('event-enrolls/destroy', 'EventEnrollController@massDestroy')->name('event-enrolls.massDestroy');
    Route::resource('event-enrolls', 'EventEnrollController');

    // Notice Boards
    Route::delete('notice-boards/destroy', 'NoticeBoardController@massDestroy')->name('notice-boards.massDestroy');
    Route::post('notice-boards/media', 'NoticeBoardController@storeMedia')->name('notice-boards.storeMedia');
    Route::post('notice-boards/ckmedia', 'NoticeBoardController@storeCKEditorImages')->name('notice-boards.storeCKEditorImages');
    Route::resource('notice-boards', 'NoticeBoardController');

    // Notifications
    Route::get('notifications/read', 'NotificationController@read');
    Route::post('notifications/media', 'NotificationController@storeMedia')->name('notifications.storeMedia');
    Route::post('notifications/ckmedia', 'NotificationController@storeCKEditorImages')->name('notifications.storeCKEditorImages');
    Route::delete('notifications/destroy', 'NotificationController@massDestroy')->name('notifications.massDestroy');
    Route::resource('notifications', 'NotificationController');

    // Rents
    Route::delete('rents/destroy', 'RentController@massDestroy')->name('rents.massDestroy');
    Route::post('rents/media', 'RentController@storeMedia')->name('rents.storeMedia');
    Route::post('rents/ckmedia', 'RentController@storeCKEditorImages')->name('rents.storeCKEditorImages');
    Route::resource('rents', 'RentController');

    // Amenities
    Route::delete('amenities/destroy', 'AmenitiesController@massDestroy')->name('amenities.massDestroy');
    Route::resource('amenities', 'AmenitiesController');

    // Notification Settings
    Route::resource('notification-settings', 'NotificationSettingController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Unit Mangements
    Route::delete('unit-mangements/destroy', 'UnitMangementController@massDestroy')->name('unit-mangements.massDestroy');
    Route::post('unit-mangements/media', 'UnitMangementController@storeMedia')->name('unit-mangements.storeMedia');
    Route::post('unit-mangements/ckmedia', 'UnitMangementController@storeCKEditorImages')->name('unit-mangements.storeCKEditorImages');
    Route::resource('unit-mangements', 'UnitMangementController');

    // Add Units
    Route::delete('add-units/destroy', 'AddUnitController@massDestroy')->name('add-units.massDestroy');
    Route::resource('add-units', 'AddUnitController');

    // Add Blocks
    Route::delete('add-blocks/destroy', 'AddBlockController@massDestroy')->name('add-blocks.massDestroy');
    Route::resource('add-blocks', 'AddBlockController');

    // Defect Settings
    Route::resource('defect-settings', 'DefectSettingController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // E Bill Listings
    Route::delete('e-bill-listings/destroy', 'EBillListingController@massDestroy')->name('e-bill-listings.massDestroy');
    Route::PUT('e-bill-listings/owner_approval_payement/{id}', 'EBillListingController@owner_approval_payement')->name('e-bill-listings.owner_approval_payement');
    Route::post('e-bill-listings/media', 'EBillListingController@storeMedia')->name('e-bill-listings.storeMedia');
    Route::post('e-bill-listings/ckmedia', 'EBillListingController@storeCKEditorImages')->name('e-bill-listings.storeCKEditorImages');
    Route::resource('e-bill-listings', 'EBillListingController');

    // Transactions
    Route::delete('transactions/destroy', 'TransactionController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'TransactionController');

    // Bank Acc Listings
    Route::delete('bank-acc-listings/destroy', 'BankAccListingController@massDestroy')->name('bank-acc-listings.massDestroy');
    Route::resource('bank-acc-listings', 'BankAccListingController');

    // Bank Names
    Route::delete('bank-names/destroy', 'BankNameController@massDestroy')->name('bank-names.massDestroy');
    Route::resource('bank-names', 'BankNameController');

    // Advance Settings
    Route::delete('advance-settings/destroy', 'AdvanceSettingController@massDestroy')->name('advance-settings.massDestroy');
    Route::resource('advance-settings', 'AdvanceSettingController');

    // Visitor Controls
    Route::delete('visitor-controls/destroy', 'VisitorControlController@massDestroy')->name('visitor-controls.massDestroy');
    Route::resource('visitor-controls', 'VisitorControlController');

    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');

    // Water Utility Payments
    Route::delete('water-utility-payments/destroy', 'WaterUtilityPaymentController@massDestroy')->name('water-utility-payments.massDestroy');
    Route::post('water-utility-payments/media', 'WaterUtilityPaymentController@storeMedia')->name('water-utility-payments.storeMedia');
    Route::post('water-utility-payments/ckmedia', 'WaterUtilityPaymentController@storeCKEditorImages')->name('water-utility-payments.storeCKEditorImages');
    Route::resource('water-utility-payments', 'WaterUtilityPaymentController');

    // Water Utility Settings
    Route::delete('water-utility-settings/destroy', 'WaterUtilitySettingsController@massDestroy')->name('water-utility-settings.massDestroy');
    Route::resource('water-utility-settings', 'WaterUtilitySettingsController');

    // Term And Policies
    Route::delete('term-and-policies/destroy', 'TermAndPolicyController@massDestroy')->name('term-and-policies.massDestroy');
    Route::post('term-and-policies/media', 'TermAndPolicyController@storeMedia')->name('term-and-policies.storeMedia');
    Route::post('term-and-policies/ckmedia', 'TermAndPolicyController@storeCKEditorImages')->name('term-and-policies.storeCKEditorImages');
    Route::resource('term-and-policies', 'TermAndPolicyController');

    // Report
    Route::resource('reports', 'ReportController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
    Route::GET('reports/detail', 'ReportController@detail')->name('reports.detail');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
