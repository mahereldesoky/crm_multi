<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     

 
        $view_orders   = Permission::create(['name' => 'view orders']);
        $create_orders = Permission::create(['name' => 'create orders']);
        $update_orders = Permission::create(['name' => 'update orders']);
        $delete_orders = Permission::create(['name' => 'delete orders']);

        $view_compaigns   = Permission::create(['name' => 'view compaigns']);
        $create_compaigns = Permission::create(['name' => 'create compaigns']);
        $update_compaigns = Permission::create(['name' => 'update compaigns']);
        $delete_compaigns = Permission::create(['name' => 'delete compaigns']);

        $view_roles   = Permission::create(['name' => 'view roles']);
        $create_roles = Permission::create(['name' => 'create roles']);
        $update_roles = Permission::create(['name' => 'update roles']);
        $delete_roles = Permission::create(['name' => 'delete roles']);

        $view_users   = Permission::create(['name' => 'view users']);
        $create_users = Permission::create(['name' => 'create users']);
        $update_users = Permission::create(['name' => 'update users']);
        $delete_users = Permission::create(['name' => 'delete users']);

        $view_departments   = Permission::create(['name' => 'view departments']);
        $create_departments = Permission::create(['name' => 'create departments']);
        $update_departments = Permission::create(['name' => 'update departments']);
        $delete_departments = Permission::create(['name' => 'delete departments']);

        $view_deals   = Permission::create(['name' => 'view deals']);
        $create_deals = Permission::create(['name' => 'create deals']);
        $update_deals = Permission::create(['name' => 'update deals']);
        $delete_deals = Permission::create(['name' => 'delete deals']);

        $view_teams   = Permission::create(['name' => 'view teams']);
        $create_teams = Permission::create(['name' => 'create teams']);
        $update_teams = Permission::create(['name' => 'update teams']);
        $delete_teams = Permission::create(['name' => 'delete teams']);

        $view_accounts   = Permission::create(['name' => 'view accounts']);
        $create_accounts = Permission::create(['name' => 'create accounts']);
        $update_accounts = Permission::create(['name' => 'update accounts']);
        $delete_accounts = Permission::create(['name' => 'delete accounts']);

        $view_customers   = Permission::create(['name' => 'view customers']);
        $create_customers = Permission::create(['name' => 'create customers']);
        $update_customers = Permission::create(['name' => 'update customers']);
        $delete_customers = Permission::create(['name' => 'delete customers']);
           
         // create role & give it permissions
        $admin_role =  Role::create(["name" => "CEO"]);
        $admin_role->givePermissionTo([
            $view_orders,
            $create_orders,
            $update_orders,
            $delete_orders,
            $view_compaigns,
            $create_compaigns,
            $update_compaigns,
            $delete_compaigns,
            $view_roles,
            $create_roles,
            $update_roles,
            $delete_roles,
            $view_users,
            $create_users,
            $update_users,
            $delete_users,
            $view_departments,
            $create_departments,
            $update_departments,
            $delete_departments,
            $view_deals,
            $create_deals,
            $update_deals,
            $delete_deals,
            $view_teams,
            $create_teams,
            $update_teams,
            $delete_teams,
            $view_accounts,
            $create_accounts,
            $update_accounts,
            $delete_accounts,
            $view_customers,
            $create_customers,
            $update_customers,
            $delete_customers,
        ]);
        

         $manager = Role::create(["name" => "admin_manager"]);
         $manager->givePermissionTo([
            $view_orders,
            $create_orders,
            $update_orders,
            $delete_orders,
            $view_compaigns,
            $create_compaigns,
            $update_compaigns,
            $delete_compaigns,
            $view_roles,
            $create_roles,
            $update_roles,
            $delete_roles,
            $view_users,
            $create_users,
            $update_users,
            $delete_users,
         ]);

       

    }
}
