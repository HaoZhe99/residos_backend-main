<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
                'type' => 'permission',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
                'type' => 'permission',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
                'type' => 'permission',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
                'type' => 'permission',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
                'type' => 'permission',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
                'type' => 'role',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
                'type' => 'role',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
                'type' => 'role',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
                'type' => 'role',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
                'type' => 'role',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
                'type' => 'user',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
                'type' => 'user',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
                'type' => 'user',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
                'type' => 'user',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
                'type' => 'user',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
                'type' => 'audit_log',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
                'type' => 'audit_log',
            ],
            [
                'id'    => 19,
                'title' => 'setting_access',
                'type' => 'access',
            ],
            [
                'id'    => 20,
                'title' => 'general_access',
                'type' => 'access',
            ],
            [
                'id'    => 21,
                'title' => 'design_access',
                'type' => 'access',
            ],
            [
                'id'    => 22,
                'title' => 'seo_access',
                'type' => 'access',
            ],
            [
                'id'    => 23,
                'title' => 'application_access',
                'type' => 'access',
            ],
            [
                'id'    => 24,
                'title' => 'country_create',
                'type' => 'country',
            ],
            [
                'id'    => 25,
                'title' => 'country_edit',
                'type' => 'country',
            ],
            [
                'id'    => 26,
                'title' => 'country_show',
                'type' => 'country',
            ],
            [
                'id'    => 27,
                'title' => 'country_delete',
                'type' => 'country',
            ],
            [
                'id'    => 28,
                'title' => 'country_access',
                'type' => 'country',
            ],
            [
                'id'    => 29,
                'title' => 'state_create',
                'type' => 'state',
            ],
            [
                'id'    => 30,
                'title' => 'state_edit',
                'type' => 'state',
            ],
            [
                'id'    => 31,
                'title' => 'state_show',
                'type' => 'state',
            ],
            [
                'id'    => 32,
                'title' => 'state_delete',
                'type' => 'state',
            ],
            [
                'id'    => 33,
                'title' => 'state_access',
                'type' => 'state',
            ],
            [
                'id'    => 34,
                'title' => 'area_setting_access',
                'type' => 'setting',
            ],
            [
                'id'    => 35,
                'title' => 'area_create',
                'type' => 'area',
            ],
            [
                'id'    => 36,
                'title' => 'area_edit',
                'type' => 'area',
            ],
            [
                'id'    => 37,
                'title' => 'area_show',
                'type' => 'area',
            ],
            [
                'id'    => 38,
                'title' => 'area_delete',
                'type' => 'area',
            ],
            [
                'id'    => 39,
                'title' => 'area_access',
                'type' => 'area',
            ],
            [
                'id'    => 40,
                'title' => 'user_application_access',
                'type' => 'application',
            ],
            [
                'id'    => 41,
                'title' => 'admin_application_access',
                'type' => 'application',
            ],
            [
                'id'    => 42,
                'title' => 'sms_setting_access',
                'type' => 'SMS setting',
            ],
            [
                'id'    => 43,
                'title' => 'e_mail_setting_access',
                'type' => 'setting',
            ],
            [
                'id'    => 44,
                'title' => 'payment_method_access',
                'type' => 'payment_method',
            ],
            [
                'id'    => 45,
                'title' => 'resident_setting_access',
                'type' => 'setting',
            ],
            [
                'id'    => 46,
                'title' => 'role_premission_access',
                'type' => 'access',
            ],
            [
                'id'    => 47,
                'title' => 'property_access',
                'type' => 'access',
            ],
            [
                'id'    => 48,
                'title' => 'developer_listing_create',
                'type' => 'developer_listing',
            ],
            [
                'id'    => 49,
                'title' => 'developer_listing_edit',
                'type' => 'developer_listing',
            ],
            [
                'id'    => 50,
                'title' => 'developer_listing_show',
                'type' => 'developer_listing',
            ],
            [
                'id'    => 51,
                'title' => 'developer_listing_delete',
                'type' => 'developer_listing',
            ],
            [
                'id'    => 52,
                'title' => 'developer_listing_access',
                'type' => 'developer_listing',
            ],
            [
                'id'    => 53,
                'title' => 'project_setting_access',
                'type' => 'setting',
            ],
            [
                'id'    => 54,
                'title' => 'project_category_create',
                'type' => 'project_category',
            ],
            [
                'id'    => 55,
                'title' => 'project_category_edit',
                'type' => 'project_category',
            ],
            [
                'id'    => 56,
                'title' => 'project_category_show',
                'type' => 'project_category',
            ],
            [
                'id'    => 57,
                'title' => 'project_category_delete',
                'type' => 'project_category',
            ],
            [
                'id'    => 58,
                'title' => 'project_category_access',
                'type' => 'project_category',
            ],
            [
                'id'    => 59,
                'title' => 'project_type_create',
                'type' => 'project_type',
            ],
            [
                'id'    => 60,
                'title' => 'project_type_edit',
                'type' => 'project_type',
            ],
            [
                'id'    => 61,
                'title' => 'project_type_show',
                'type' => 'project_type',
            ],
            [
                'id'    => 62,
                'title' => 'project_type_delete',
                'type' => 'project_type',
            ],
            [
                'id'    => 63,
                'title' => 'project_type_access',
                'type' => 'project_type',
            ],
            [
                'id'    => 64,
                'title' => 'project_listing_create',
                'type' => 'project_listing',
            ],
            [
                'id'    => 65,
                'title' => 'project_listing_edit',
                'type' => 'project_listing',
            ],
            [
                'id'    => 66,
                'title' => 'project_listing_show',
                'type' => 'project_listing',
            ],
            [
                'id'    => 67,
                'title' => 'project_listing_delete',
                'type' => 'project_listing',
            ],
            [
                'id'    => 68,
                'title' => 'project_listing_access',
                'type' => 'project_listing',
            ],
            [
                'id'    => 69,
                'title' => 'project_access',
                'type' => 'access',
            ],
            [
                'id'    => 70,
                'title' => 'pic_create',
                'type' => 'pic',
            ],
            [
                'id'    => 71,
                'title' => 'pic_edit',
                'type' => 'pic',
            ],
            [
                'id'    => 72,
                'title' => 'pic_show',
                'type' => 'pic',
            ],
            [
                'id'    => 73,
                'title' => 'pic_delete',
                'type' => 'pic',
            ],
            [
                'id'    => 74,
                'title' => 'pic_access',
                'type' => 'pic',
            ],
            [
                'id'    => 75,
                'title' => 'resident_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 76,
                'title' => 'social_login_access',
                'type' => 'social_login',
            ],
            [
                'id'    => 77,
                'title' => 'e_billing_access',
                'type' => 'access',
            ],
            [
                'id'    => 78,
                'title' => 'event_access',
                'type' => 'access',
            ],
            [
                'id'    => 79,
                'title' => 'access_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 80,
                'title' => 'facility_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 81,
                'title' => 'form_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 82,
                'title' => 'defect_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 83,
                'title' => 'content_access',
                'type' => 'access',
            ],
            [
                'id'    => 84,
                'title' => 'content_listing_create',
                'type' => 'content_listing',
            ],
            [
                'id'    => 85,
                'title' => 'content_listing_edit',
                'type' => 'content_listing',
            ],
            [
                'id'    => 86,
                'title' => 'content_listing_show',
                'type' => 'content_listing',
            ],
            [
                'id'    => 87,
                'title' => 'content_listing_delete',
                'type' => 'content_listing',
            ],
            [
                'id'    => 88,
                'title' => 'content_listing_access',
                'type' => 'content_listing',
            ],
            [
                'id'    => 89,
                'title' => 'content_type_create',
                'type' => 'content_type',
            ],
            [
                'id'    => 90,
                'title' => 'content_type_edit',
                'type' => 'content_type',
            ],
            [
                'id'    => 91,
                'title' => 'content_type_show',
                'type' => 'content_type',
            ],
            [
                'id'    => 92,
                'title' => 'content_type_delete',
                'type' => 'content_type',
            ],
            [
                'id'    => 93,
                'title' => 'content_type_access',
                'type' => 'content_type',
            ],
            [
                'id'    => 94,
                'title' => 'feedback_access',
                'type' => 'access',
            ],
            [
                'id'    => 95,
                'title' => 'feedback_category_create',
                'type' => 'feedback_category',
            ],
            [
                'id'    => 96,
                'title' => 'feedback_category_edit',
                'type' => 'feedback_category',
            ],
            [
                'id'    => 97,
                'title' => 'feedback_category_show',
                'type' => 'feedback_category',
            ],
            [
                'id'    => 98,
                'title' => 'feedback_category_delete',
                'type' => 'feedback_category',
            ],
            [
                'id'    => 99,
                'title' => 'feedback_category_access',
                'type' => 'feedback_category',
            ],
            [
                'id'    => 100,
                'title' => 'feedback_listing_create',
                'type' => 'feedback_listing',
            ],
            [
                'id'    => 101,
                'title' => 'feedback_listing_edit',
                'type' => 'feedback_listing',
            ],
            [
                'id'    => 102,
                'title' => 'feedback_listing_show',
                'type' => 'feedback_listing',
            ],
            [
                'id'    => 103,
                'title' => 'feedback_listing_delete',
                'type' => 'feedback_listing',
            ],
            [
                'id'    => 104,
                'title' => 'feedback_listing_access',
                'type' => 'feedback_listing',
            ],
            [
                'id'    => 105,
                'title' => 'car_park_management_access',
                'type' => 'management',
            ],
            [
                'id'    => 106,
                'title' => 'vehicle_access',
                'type' => 'access',
            ],
            [
                'id'    => 107,
                'title' => 'vehicle_brand_create',
                'type' => 'vehicle_brand',
            ],
            [
                'id'    => 108,
                'title' => 'vehicle_brand_edit',
                'type' => 'vehicle_brand',
            ],
            [
                'id'    => 109,
                'title' => 'vehicle_brand_show',
                'type' => 'vehicle_brand',
            ],
            [
                'id'    => 110,
                'title' => 'vehicle_brand_delete',
                'type' => 'vehicle_brand',
            ],
            [
                'id'    => 111,
                'title' => 'vehicle_brand_access',
                'type' => 'vehicle_brand',
            ],
            [
                'id'    => 112,
                'title' => 'vehicle_model_create',
                'type' => 'vehicle_model',
            ],
            [
                'id'    => 113,
                'title' => 'vehicle_model_edit',
                'type' => 'vehicle_model',
            ],
            [
                'id'    => 114,
                'title' => 'vehicle_model_show',
                'type' => 'vehicle_model',
            ],
            [
                'id'    => 115,
                'title' => 'vehicle_model_delete',
                'type' => 'vehicle_model',
            ],
            [
                'id'    => 116,
                'title' => 'vehicle_model_access',
                'type' => 'vehicle_model',
            ],
            [
                'id'    => 117,
                'title' => 'vehicle_management_create',
                'type' => 'vehicle_management',
            ],
            [
                'id'    => 118,
                'title' => 'vehicle_management_edit',
                'type' => 'vehicle_management',
            ],
            [
                'id'    => 119,
                'title' => 'vehicle_management_show',
                'type' => 'vehicle_management',
            ],
            [
                'id'    => 120,
                'title' => 'vehicle_management_delete',
                'type' => 'vehicle_management',
            ],
            [
                'id'    => 121,
                'title' => 'vehicle_management_access',
                'type' => 'vehicle_management',
            ],
            [
                'id'    => 122,
                'title' => 'carparklocation_create',
                'type' => 'carparklocation',
            ],
            [
                'id'    => 123,
                'title' => 'carparklocation_edit',
                'type' => 'carparklocation',
            ],
            [
                'id'    => 124,
                'title' => 'carparklocation_show',
                'type' => 'carparklocation',
            ],
            [
                'id'    => 125,
                'title' => 'carparklocation_delete',
                'type' => 'carparklocation',
            ],
            [
                'id'    => 126,
                'title' => 'carparklocation_access',
                'type' => 'carparklocation',
            ],
            [
                'id'    => 127,
                'title' => 'vehicle_log_create',
                'type' => 'vehicle_log',
            ],
            [
                'id'    => 128,
                'title' => 'vehicle_log_edit',
                'type' => 'vehicle_log',
            ],
            [
                'id'    => 129,
                'title' => 'vehicle_log_show',
                'type' => 'vehicle_log',
            ],
            [
                'id'    => 130,
                'title' => 'vehicle_log_delete',
                'type' => 'vehicle_log',
            ],
            [
                'id'    => 131,
                'title' => 'vehicle_log_access',
                'type' => 'vehicle_log',
            ],
            [
                'id'    => 132,
                'title' => 'event_category_create',
                'type' => 'event_category',
            ],
            [
                'id'    => 133,
                'title' => 'event_category_edit',
                'type' => 'event_category',
            ],
            [
                'id'    => 134,
                'title' => 'event_category_show',
                'type' => 'event_category',
            ],
            [
                'id'    => 135,
                'title' => 'event_category_delete',
                'type' => 'event_category',
            ],
            [
                'id'    => 136,
                'title' => 'event_category_access',
                'type' => 'event_category',
            ],
            [
                'id'    => 137,
                'title' => 'defect_category_create',
                'type' => 'defect_category',
            ],
            [
                'id'    => 138,
                'title' => 'defect_category_edit',
                'type' => 'defect_category',
            ],
            [
                'id'    => 139,
                'title' => 'defect_category_show',
                'type' => 'defect_category',
            ],
            [
                'id'    => 140,
                'title' => 'defect_category_delete',
                'type' => 'defect_category',
            ],
            [
                'id'    => 141,
                'title' => 'defect_category_access',
                'type' => 'defect_category',
            ],
            [
                'id'    => 142,
                'title' => 'status_control_create',
                'type' => 'status_control',
            ],
            [
                'id'    => 143,
                'title' => 'status_control_edit',
                'type' => 'status_control',
            ],
            [
                'id'    => 144,
                'title' => 'status_control_show',
                'type' => 'status_control',
            ],
            [
                'id'    => 145,
                'title' => 'status_control_delete',
                'type' => 'status_control',
            ],
            [
                'id'    => 146,
                'title' => 'status_control_access',
                'type' => 'status_control',
            ],
            [
                'id'    => 147,
                'title' => 'defect_listing_create',
                'type' => 'defect_listing',
            ],
            [
                'id'    => 148,
                'title' => 'defect_listing_edit',
                'type' => 'defect_listing',
            ],
            [
                'id'    => 149,
                'title' => 'defect_listing_show',
                'type' => 'defect_listing',
            ],
            [
                'id'    => 150,
                'title' => 'defect_listing_delete',
                'type' => 'defect_listing',
            ],
            [
                'id'    => 151,
                'title' => 'defect_listing_access',
                'type' => 'defect_listing',
            ],
            [
                'id'    => 152,
                'title' => 'facility_category_create',
                'type' => 'facility_category',
            ],
            [
                'id'    => 153,
                'title' => 'facility_category_edit',
                'type' => 'facility_category',
            ],
            [
                'id'    => 154,
                'title' => 'facility_category_show',
                'type' => 'facility_category',
            ],
            [
                'id'    => 155,
                'title' => 'facility_category_delete',
                'type' => 'facility_category',
            ],
            [
                'id'    => 156,
                'title' => 'facility_category_access',
                'type' => 'facility_category',
            ],
            [
                'id'    => 157,
                'title' => 'facility_listing_create',
                'type' => 'facility_listing',
            ],
            [
                'id'    => 158,
                'title' => 'facility_listing_edit',
                'type' => 'facility_listing',
            ],
            [
                'id'    => 159,
                'title' => 'facility_listing_show',
                'type' => 'facility_listing',
            ],
            [
                'id'    => 160,
                'title' => 'facility_listing_delete',
                'type' => 'facility_listing',
            ],
            [
                'id'    => 161,
                'title' => 'facility_listing_access',
                'type' => 'facility_listing',
            ],
            [
                'id'    => 162,
                'title' => 'facility_book_create',
                'type' => 'facility_book',
            ],
            [
                'id'    => 163,
                'title' => 'facility_book_edit',
                'type' => 'facility_book',
            ],
            [
                'id'    => 164,
                'title' => 'facility_book_show',
                'type' => 'facility_book',
            ],
            [
                'id'    => 165,
                'title' => 'facility_book_delete',
                'type' => 'facility_book',
            ],
            [
                'id'    => 166,
                'title' => 'facility_book_access',
                'type' => 'facility_book',
            ],
            [
                'id'    => 167,
                'title' => 'facility_maintain_create',
                'type' => 'facility_maintain',
            ],
            [
                'id'    => 168,
                'title' => 'facility_maintain_edit',
                'type' => 'facility_maintain',
            ],
            [
                'id'    => 169,
                'title' => 'facility_maintain_show',
                'type' => 'facility_maintain',
            ],
            [
                'id'    => 170,
                'title' => 'facility_maintain_delete',
                'type' => 'facility_maintain',
            ],
            [
                'id'    => 171,
                'title' => 'facility_maintain_access',
                'type' => 'facility_maintain',
            ],
            [
                'id'    => 172,
                'title' => 'location_create',
                'type' => 'location',
            ],
            [
                'id'    => 173,
                'title' => 'location_edit',
                'type' => 'location',
            ],
            [
                'id'    => 174,
                'title' => 'location_show',
                'type' => 'location',
            ],
            [
                'id'    => 175,
                'title' => 'location_delete',
                'type' => 'location',
            ],
            [
                'id'    => 176,
                'title' => 'location_access',
                'type' => 'location',
            ],
            [
                'id'    => 177,
                'title' => 'gateway_create',
                'type' => 'gateway',
            ],
            [
                'id'    => 178,
                'title' => 'gateway_edit',
                'type' => 'gateway',
            ],
            [
                'id'    => 179,
                'title' => 'gateway_show',
                'type' => 'gateway',
            ],
            [
                'id'    => 180,
                'title' => 'gateway_delete',
                'type' => 'gateway',
            ],
            [
                'id'    => 181,
                'title' => 'gateway_access',
                'type' => 'gateway',
            ],
            [
                'id'    => 182,
                'title' => 'qr_create',
                'type' => 'qr',
            ],
            [
                'id'    => 183,
                'title' => 'qr_edit',
                'type' => 'qr',
            ],
            [
                'id'    => 184,
                'title' => 'qr_show',
                'type' => 'qr',
            ],
            [
                'id'    => 185,
                'title' => 'qr_delete',
                'type' => 'qr',
            ],
            [
                'id'    => 186,
                'title' => 'qr_access',
                'type' => 'qr',
            ],
            [
                'id'    => 187,
                'title' => 'gate_history_create',
                'type' => 'gate_history',
            ],
            [
                'id'    => 188,
                'title' => 'gate_history_edit',
                'type' => 'gate_history',
            ],
            [
                'id'    => 189,
                'title' => 'gate_history_show',
                'type' => 'gate_history',
            ],
            [
                'id'    => 190,
                'title' => 'gate_history_delete',
                'type' => 'gate_history',
            ],
            [
                'id'    => 191,
                'title' => 'gate_history_access',
                'type' => 'gate_history',
            ],
            [
                'id'    => 192,
                'title' => 'event_listing_create',
                'type' => 'event_listing',
            ],
            [
                'id'    => 193,
                'title' => 'event_listing_edit',
                'type' => 'event_listing',
            ],
            [
                'id'    => 194,
                'title' => 'event_listing_show',
                'type' => 'event_listing',
            ],
            [
                'id'    => 195,
                'title' => 'event_listing_delete',
                'type' => 'event_listing',
            ],
            [
                'id'    => 196,
                'title' => 'event_listing_access',
                'type' => 'event_listing',
            ],
            [
                'id'    => 197,
                'title' => 'event_enroll_create',
                'type' => 'event_enroll',
            ],
            [
                'id'    => 198,
                'title' => 'event_enroll_edit',
                'type' => 'event_enroll',
            ],
            [
                'id'    => 199,
                'title' => 'event_enroll_show',
                'type' => 'event_enroll',
            ],
            [
                'id'    => 200,
                'title' => 'event_enroll_delete',
                'type' => 'event_enroll',
            ],
            [
                'id'    => 201,
                'title' => 'event_enroll_access',
                'type' => 'event_enroll',
            ],
            [
                'id'    => 202,
                'title' => 'notice_board_access',
                'type' => 'notice_board',
            ],
            [
                'id'    => 203,
                'title' => 'notification_access',
                'type' => 'access',
            ],
            [
                'id'    => 204,
                'title' => 'notification_setting_access',
                'type' => 'setting',
            ],
            [
                'id'    => 205,
                'title' => 'unit_mangement_create',
                'type' => 'unit_mangement',
            ],
            [
                'id'    => 206,
                'title' => 'unit_mangement_edit',
                'type' => 'unit_mangement',
            ],
            [
                'id'    => 207,
                'title' => 'unit_mangement_show',
                'type' => 'unit_mangement',
            ],
            [
                'id'    => 208,
                'title' => 'unit_mangement_delete',
                'type' => 'unit_mangement',
            ],
            [
                'id'    => 209,
                'title' => 'unit_mangement_access',
                'type' => 'unit_mangement',
            ],
            [
                'id'    => 210,
                'title' => 'unit_access',
                'type' => 'access',
            ],
            [
                'id'    => 211,
                'title' => 'add_unit_access',
                'type' => 'add_unit',
            ],
            [
                'id'    => 212,
                'title' => 'add_block_create',
                'type' => 'add_block',
            ],
            [
                'id'    => 213,
                'title' => 'add_block_edit',
                'type' => 'add_block',
            ],
            [
                'id'    => 214,
                'title' => 'add_block_show',
                'type' => 'add_block',
            ],
            [
                'id'    => 215,
                'title' => 'add_block_delete',
                'type' => 'add_block',
            ],
            [
                'id'    => 216,
                'title' => 'add_block_access',
                'type' => 'add_block',
            ],
            [
                'id'    => 217,
                'title' => 'defect_setting_access',
                'type' => 'setting',
            ],
            [
                'id'    => 218,
                'title' => 'e_bill_listing_create',
                'type' => 'e_bill_listing',
            ],
            [
                'id'    => 219,
                'title' => 'e_bill_listing_edit',
                'type' => 'e_bill_listing',
            ],
            [
                'id'    => 220,
                'title' => 'e_bill_listing_show',
                'type' => 'e_bill_listing',
            ],
            [
                'id'    => 221,
                'title' => 'e_bill_listing_delete',
                'type' => 'e_bill_listing',
            ],
            [
                'id'    => 222,
                'title' => 'e_bill_listing_access',
                'type' => 'e_bill_listing',
            ],
            [
                'id'    => 223,
                'title' => 'transaction_create',
                'type' => 'transaction',
            ],
            [
                'id'    => 224,
                'title' => 'transaction_edit',
                'type' => 'transaction',
            ],
            [
                'id'    => 225,
                'title' => 'transaction_show',
                'type' => 'transaction',
            ],
            [
                'id'    => 226,
                'title' => 'transaction_delete',
                'type' => 'transaction',
            ],
            [
                'id'    => 227,
                'title' => 'transaction_access',
                'type' => 'transaction',
            ],
            [
                'id'    => 228,
                'title' => 'bank_account_access',
                'type' => 'access',
            ],
            [
                'id'    => 229,
                'title' => 'bank_acc_listing_create',
                'type' => 'bank_acc_listing',
            ],
            [
                'id'    => 230,
                'title' => 'bank_acc_listing_edit',
                'type' => 'bank_acc_listing',
            ],
            [
                'id'    => 231,
                'title' => 'bank_acc_listing_show',
                'type' => 'bank_acc_listing',
            ],
            [
                'id'    => 232,
                'title' => 'bank_acc_listing_delete',
                'type' => 'bank_acc_listing',
            ],
            [
                'id'    => 233,
                'title' => 'bank_acc_listing_access',
                'type' => 'bank_acc_listing',
            ],
            [
                'id'    => 234,
                'title' => 'bank_name_create',
                'type' => 'bank_name',
            ],
            [
                'id'    => 235,
                'title' => 'bank_name_edit',
                'type' => 'bank_name',
            ],
            [
                'id'    => 236,
                'title' => 'bank_name_show',
                'type' => 'bank_name',
            ],
            [
                'id'    => 237,
                'title' => 'bank_name_delete',
                'type' => 'bank_name',
            ],
            [
                'id'    => 238,
                'title' => 'bank_name_access',
                'type' => 'bank_name',
            ],
            [
                'id'    => 239,
                'title' => 'advance_setting_create',
                'type' => 'advance_setting',
            ],
            [
                'id'    => 240,
                'title' => 'advance_setting_edit',
                'type' => 'advance_setting',
            ],
            [
                'id'    => 241,
                'title' => 'advance_setting_show',
                'type' => 'advance_setting',
            ],
            [
                'id'    => 242,
                'title' => 'advance_setting_delete',
                'type' => 'advance_setting',
            ],
            [
                'id'    => 243,
                'title' => 'advance_setting_access',
                'type' => 'advance_setting',
            ],
            [
                'id'    => 244,
                'title' => 'profile_password_edit',
                'type' => 'profile_password',
            ],
            [
                'id'    => 245,
                'title' => 'add_unit_create',
                'type' => 'add_unit',
            ],
            [
                'id'    => 246,
                'title' => 'add_unit_edit',
                'type' => 'add_unit',
            ],
            [
                'id'    => 247,
                'title' => 'add_unit_show',
                'type' => 'add_unit',
            ],
            [
                'id'    => 248,
                'title' => 'add_unit_delete',
                'type' => 'add_unit',
            ],
            [
                'id'    => 249,
                'title' => 'notice_board_create',
                'type' => 'notice_board',
            ],
            [
                'id'    => 250,
                'title' => 'notice_board_edit',
                'type' => 'notice_board',
            ],
            [
                'id'    => 251,
                'title' => 'notice_board_show',
                'type' => 'notice_board',
            ],
            [
                'id'    => 252,
                'title' => 'notice_board_delete',
                'type' => 'notice_board',
            ],
            [
                'id'    => 253,
                'title' => 'payment_method_create',
                'type' => 'payment_method',
            ],
            [
                'id'    => 254,
                'title' => 'payment_method_edit',
                'type' => 'payment_method',
            ],
            [
                'id'    => 255,
                'title' => 'payment_method_show',
                'type' => 'payment_method',
            ],
            [
                'id'    => 256,
                'title' => 'payment_method_delete',
                'type' => 'payment_method',
            ],
            [
                'id'    => 257,
                'title' => 'family_control_access',
                'type'  => 'family_control',
            ],
            [
                'id'    => 258,
                'title' => 'family_control_create',
                'type'  => 'family_control',
            ],
            [
                'id'    => 259,
                'title' => 'family_control_edit',
                'type'  => 'family_control',
            ],
            [
                'id'    => 260,
                'title' => 'family_control_show',
                'type'  => 'family_control',
            ],
            [
                'id'    => 261,
                'title' => 'family_control_delete',
                'type'  => 'family_control',
            ],
            [
                'id'    => 262,
                'title' => 'tenant_control_access',
                'type'  => 'tenant_control',
            ],
            [
                'id'    => 263,
                'title' => 'tenant_control_create',
                'type'  => 'tenant_control',
            ],
            [
                'id'    => 264,
                'title' => 'tenant_control_edit',
                'type'  => 'tenant_control',
            ],
            [
                'id'    => 265,
                'title' => 'tenant_control_show',
                'type'  => 'tenant_control',
            ],
            [
                'id'    => 266,
                'title' => 'tenant_control_delete',
                'type'  => 'tenant_control',
            ],
            [
                'id'    => 267,
                'title' => 'visitor_control_create',
                'type'  => 'visitor_control',
            ],
            [
                'id'    => 268,
                'title' => 'visitor_control_edit',
                'type'  => 'visitor_control',
            ],
            [
                'id'    => 269,
                'title' => 'visitor_control_show',
                'type'  => 'visitor_control',
            ],
            [
                'id'    => 270,
                'title' => 'visitor_control_delete',
                'type'  => 'visitor_control',
            ],
            [
                'id'    => 271,
                'title' => 'visitor_control_access',
                'type'  => 'visitor_control',
            ],
            [
                'id'    => 272,
                'title' => 'water_utility_payment_create',
                'type'  => 'water_utility_payment',
            ],
            [
                'id'    => 273,
                'title' => 'water_utility_payment_edit',
                'type'  => 'water_utility_payment',
            ],
            [
                'id'    => 274,
                'title' => 'water_utility_payment_show',
                'type'  => 'water_utility_payment',
            ],
            [
                'id'    => 275,
                'title' => 'water_utility_payment_delete',
                'type'  => 'water_utility_payment',
            ],
            [
                'id'    => 276,
                'title' => 'water_utility_payment_access',
                'type'  => 'water_utility_payment',
            ],
            [
                'id'    => 277,
                'title' => 'water_utility_setting_create',
                'type'  => 'water_utility_setting',
            ],
            [
                'id'    => 278,
                'title' => 'water_utility_setting_edit',
                'type'  => 'water_utility_setting',
            ],
            [
                'id'    => 279,
                'title' => 'water_utility_setting_show',
                'type'  => 'water_utility_setting',
            ],
            [
                'id'    => 280,
                'title' => 'water_utility_setting_delete',
                'type'  => 'water_utility_setting',
            ],
            [
                'id'    => 281,
                'title' => 'water_utility_setting_access',
                'type'  => 'water_utility_setting',
            ],
            [
                'id'    => 282,
                'title' => 'notifications_create',
                'type'  => 'notification',
            ],
            [
                'id'    => 283,
                'title' => 'notifications_edit',
                'type'  => 'notification',
            ],
            [
                'id'    => 284,
                'title' => 'notifications_show',
                'type'  => 'notification',
            ],
            [
                'id'    => 285,
                'title' => 'notifications_delete',
                'type'  => 'notification',
            ],
            [
                'id'    => 286,
                'title' => 'notifications_access',
                'type'  => 'notification',
            ],
            [
                'id'    => 287,
                'title' => 'term_and_policy_create',
                'type'  => 'term_and_policy',
            ],
            [
                'id'    => 288,
                'title' => 'term_and_policy_edit',
                'type'  => 'term_and_policy',
            ],
            [
                'id'    => 289,
                'title' => 'term_and_policy_show',
                'type'  => 'term_and_policy',
            ],
            [
                'id'    => 290,
                'title' => 'term_and_policy_delete',
                'type'  => 'term_and_policy',
            ],
            [
                'id'    => 291,
                'title' => 'term_and_policy_access',
                'type'  => 'term_and_policy',
            ],
            [
                'id'    => 292,
                'title' => 'amenity_create',
                'type'  => 'amenity',
            ],
            [
                'id'    => 293,
                'title' => 'amenity_edit',
                'type'  => 'amenity',
            ],
            [
                'id'    => 294,
                'title' => 'amenity_show',
                'type'  => 'amenity',
            ],
            [
                'id'    => 295,
                'title' => 'amenity_delete',
                'type'  => 'amenity',
            ],
            [
                'id'    => 296,
                'title' => 'amenity_access',
                'type'  => 'amenity',
            ],
            [
                'id'    => 297,
                'title' => 'rent_create',
                'type'  => 'rent',
            ],
            [
                'id'    => 298,
                'title' => 'rent_edit',
                'type'  => 'rent',
            ],
            [
                'id'    => 299,
                'title' => 'rent_show',
                'type'  => 'rent',
            ],
            [
                'id'    => 300,
                'title' => 'rent_delete',
                'type'  => 'rent',
            ],
            [
                'id'    => 301,
                'title' => 'rent_access',
                'type'  => 'rent',
            ],
            [
                'id'    => 302,
                'title' => 'report_access',
                'type'  => 'report',
            ],
            [
                'id'    => 303,
                'title' => 'sms_setting_edit',
                'type' => 'SMS setting',
            ],
            [
                'id'    => 304,
                'title' => 'social_login_create',
                'type' => 'social_login',
            ],
            [
                'id'    => 305,
                'title' => 'social_login_edit',
                'type' => 'social_login',
            ],
            [
                'id'    => 306,
                'title' => 'social_login_show',
                'type' => 'social_login',
            ],
            [
                'id'    => 307,
                'title' => 'social_login_delete',
                'type' => 'social_login',
            ],
        ];

        Permission::insert($permissions);
    }
}
