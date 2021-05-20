<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {

    // E Bill Listings
    Route::post('e-bill-listings/call_back', 'EBillListingApiController@call_back');
    Route::get('e-bill-listings/redirect', 'EBillListingApiController@redirect');
    Route::get('e-bill-listings/call_pg', 'EBillListingApiController@call_pg');

    Route::group(['middleware' => ['auth:api', 'scope:view-user']], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Permissions
        Route::apiResource('permissions', 'PermissionsApiController');

        // Roles
        Route::apiResource('roles', 'RolesApiController');

        // Users
        Route::get('users/add_paginate_user_data', 'UsersApiController@add_paginate_user_data');
        Route::get('users/paginate_user_data', 'UsersApiController@paginate_user_data');
        Route::post('users/addUser', 'UsersApiController@addUser');
        Route::post('users/updateProfile/{user}', 'UsersApiController@updateProfile');
        Route::get('users/login/{email}', 'UsersApiController@login');
        Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
        Route::apiResource('users', 'UsersApiController');

        // Countries
        Route::apiResource('countries', 'CountriesApiController');

        // States
        Route::apiResource('states', 'StatesApiController');

        // Areas
        Route::post('areas/postcode_filter', 'AreaApiController@postcode_filter');
        Route::get('areas/area_filter', 'AreaApiController@area_filter');
        Route::apiResource('areas', 'AreaApiController');

        // Developer Listings
        Route::apiResource('developer-listings', 'DeveloperListingApiController');

        // Project Categories
        Route::apiResource('project-categories', 'ProjectCategoryApiController');

        // Project Types
        Route::apiResource('project-types', 'ProjectTypeApiController');

        // Project Listings
        Route::apiResource('project-listings', 'ProjectListingApiController');

        // Pics
        Route::apiResource('pics', 'PicApiController');

        // Content Listings
        Route::get('notifications/read', 'ContentListingApiController@read');
        Route::post('content-listings/media', 'ContentListingApiController@storeMedia')->name('content-listings.storeMedia');
        Route::apiResource('content-listings', 'ContentListingApiController');

        // Content Types
        Route::apiResource('content-types', 'ContentTypeApiController');

        // Feedback Categories
        Route::apiResource('feedback-categories', 'FeedbackCategoryApiController');

        // Feedback Listings
        Route::post('feedback-listings/media', 'FeedbackListingApiController@storeMedia')->name('feedback-listings.storeMedia');
        Route::apiResource('feedback-listings', 'FeedbackListingApiController');

        // Vehicle Brands
        Route::apiResource('vehicle-brands', 'VehicleBrandApiController');

        // Vehicle Models
        Route::apiResource('vehicle-models', 'VehicleModelApiController');

        // Vehicle Managements
        Route::apiResource('vehicle-managements', 'VehicleManagementApiController');

        // Carparklocations
        Route::apiResource('carparklocations', 'CarparklocationApiController');

        // Vehicle Logs
        Route::apiResource('vehicle-logs', 'VehicleLogApiController');

        // Event Categories
        Route::apiResource('event-categories', 'EventCategoryApiController');

        // Defect Categories
        Route::apiResource('defect-categories', 'DefectCategoryApiController');

        // Status Controls
        Route::apiResource('status-controls', 'StatusControlApiController');

        // Defect Listings
        Route::post('defect-listings/media', 'DefectListingApiController@storeMedia')->name('defect-listings.storeMedia');
        Route::apiResource('defect-listings', 'DefectListingApiController');

        // Facility Categories
        Route::apiResource('facility-categories', 'FacilityCategoryApiController');

        // Facility Listings
        Route::post('facility-listings/media', 'FacilityListingApiController@storeMedia')->name('facility-listings.storeMedia');
        Route::apiResource('facility-listings', 'FacilityListingApiController');

        // Facility Books
        Route::apiResource('facility-books', 'FacilityBookApiController');

        // Facility Maintains
        Route::apiResource('facility-maintains', 'FacilityMaintainApiController');

        // Locations
        Route::apiResource('locations', 'LocationApiController');

        // Gateways
        Route::apiResource('gateways', 'GatewayApiController');

        // Qrs
        Route::get('qrs/scanQrCode/{qr}/{gateway}/{type}', 'QrApiController@scanQrCode');
        Route::apiResource('qrs', 'QrApiController');

        // Gate Histories
        Route::apiResource('gate-histories', 'GateHistoryApiController');

        // Event Listings
        Route::post('event-listings/add_paginate_event_data', 'EventListingApiController@add_paginate_event_data');
        Route::get('event-listings/paginate_event_data', 'EventListingApiController@paginate_event_data');
        Route::post('event-listings/update_participants/{id}', 'EventListingApiController@update_participants');
        Route::post('event-listings/media', 'EventListingApiController@storeMedia')->name('event-listings.storeMedia');
        Route::apiResource('event-listings', 'EventListingApiController');

        // Event Enrolls
        Route::apiResource('event-enrolls', 'EventEnrollApiController');

        // Unit Mangements
        Route::post('unit-mangements/addUnit', 'UnitMangementApiController@addUnit');
        Route::post('unit-mangements/update_status/{id}', 'UnitMangementApiController@update_status');
        Route::post('unit-mangements/media', 'UnitMangementApiController@storeMedia')->name('unit-mangements.storeMedia');
        Route::apiResource('unit-mangements', 'UnitMangementApiController');

        // Notice Boards
        Route::post('notice-boards/media', 'NoticeBoardApiController@storeMedia')->name('notice-boards.storeMedia');
        Route::apiResource('notice-boards', 'NoticeBoardApiController');

        // Tenant Controls
        Route::apiResource('tenant-controls', 'TenantControlApiController');

        // Family Controls
        Route::apiResource('family-controls', 'FamilyControlApiController');

        // Payment Methods
        Route::apiResource('payment-methods', 'PaymentMethodApiController');

        // Add Units
        Route::get('add-units/unit_filter', 'AddUnitApiController@unit_filter');
        Route::apiResource('add-units', 'AddUnitApiController');

        // Add Blocks
        Route::apiResource('add-blocks', 'AddBlockApiController');

        // E Bill Listings
        Route::post('e-bill-listings/owner_approval_payement/{id}', 'EBillListingApiController@owner_approval_payement');
        Route::post('e-bill-listings/generate_rental_fee', 'EBillListingApiController@generate_rental_fee');
        Route::post('e-bill-listings/media', 'EBillListingApiController@storeMedia')->name('e-bill-listings.storeMedia');
        Route::apiResource('e-bill-listings', 'EBillListingApiController');

        // Transactions
        Route::apiResource('transactions', 'TransactionApiController');

        // Bank Acc Listings
        Route::apiResource('bank-acc-listings', 'BankAccListingApiController');

        // Bank Names
        Route::apiResource('bank-names', 'BankNameApiController');

        // Advance Settings
        Route::apiResource('advance-settings', 'AdvanceSettingApiController');

        // Visitor Controls
        Route::apiResource('visitor-controls', 'VisitorControlApiController');

        // Water Utility Settings
        Route::apiResource('water-utility-settings', 'WaterUtilitySettingsApiController');

        // Water Utility Payments
        Route::post('water-utility-payments/scanQrCode', 'WaterUtilityPaymentApiController@scanQrCode');
        Route::post('water-utility-payments/media', 'WaterUtilityPaymentApiController@storeMedia')->name('water-utility-payments.storeMedia');
        Route::apiResource('water-utility-payments', 'WaterUtilityPaymentApiController');

        // User Alerts
        Route::get('notifications/read', 'NotificationApiController@read');
        Route::apiResource('notifications', 'NotificationApiController');

        // Rents
        Route::post('rents/updateRentImage/{rent}', 'RentApiController@updateRentImage');
        Route::post('rents/update_status/{id}', 'RentApiController@update_status');
        Route::post('rents/media', 'RentApiController@storeMedia')->name('rents.storeMedia');
        Route::apiResource('rents', 'RentApiController');

        // Amenities
        Route::apiResource('amenities', 'AmenitiesApiController');

        // Term And Policies
        Route::post('term-and-policies/media', 'TermAndPolicyApiController@storeMedia')->name('term-and-policies.storeMedia');
        Route::apiResource('term-and-policies', 'TermAndPolicyApiController');

    });
    // Users
    Route::post('users/store_contact_number', 'UsersApiController@store_contact_number');
    Route::post('users/getVerify', 'UsersApiController@getVerify');
    Route::post('users/verifying', 'UsersApiController@verifying');
    Route::post('users/register', 'UsersApiController@register');

    Route::post('users/user_store', 'UsersApiController@user_store');
    Route::get('users/user_verify/{id}', 'UsersApiController@user_verify');
    Route::post('users/user_verify_process', 'UsersApiController@user_verify_process');
});
