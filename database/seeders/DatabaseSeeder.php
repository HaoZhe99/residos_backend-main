<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            AreaTableSeeder::class,
            CountriesTableSeeder::class,
            PicTableSeeder::class,
            ProjectCategoryTableSeeder::class,
            ProjectTypeTableSeeder::class,
            DeveloperListingTableSeeder::class,
            ProjectListingTableSeeder::class,
            AddBlockTableSeeder::class,
            AddUnitTableSeeder::class,
            UnitManagementTableSeeder::class,
            PaymentMethodTableSeeder::class,
            BankAccTableSeeder::class,
            BankAccListingTableSeeder::class,
            EBilingListingTableSeeder::class,
            ContentTypeTableSeeder::class,
            AmenitiesTableSeeder::class,
            RentTableSeeder::class,
            LanguageTableSeeder::class,
            TenantControlTableSeeder::class,
            EventCategoryTableSeeder::class,
            EventListingTableSeeder::class,
            SMSTableSeeder::class,
            SocialLoginTableSeeder::class,
        ]);
    }
}
