<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'appointment-list','appointment-create','appointment-edit','appointment-delete',
            'speciality-list','speciality-create','speciality-edit','speciality-delete',
            'service-list','service-create','service-edit','service-delete',
            'subadmin-list','subadmin-create','subadmin-edit','subadmin-delete',
            'area-list','area-create','area-edit','area-delete',
            'labtest-list','labtest-create','labtest-edit','labtest-delete',
            'entity-list','entity-create','entity-edit','entity-delete',
            'doctor-list','doctor-create','doctor-edit','doctor-delete',
            'patient-list','patient-create','patient-edit','patient-delete',
            'user-list','user-create','user-edit','user-delete',
            'coupon-list','coupon-create','coupon-edit','coupon-delete',
            'blogtype-list','blogtype-create','blogtype-edit','blogtype-delete',
            'blog-list','blog-create','blog-edit','blog-delete',
            'role-list','role-create','role-edit','role-delete',
            'setting-list','setting-create','setting-edit','setting-delete',
         ];
    
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission,'guard_name'=>'admin']);
         }
    }
}
