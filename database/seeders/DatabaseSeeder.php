<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('permissions')->insert([
            [
                'name' => 'View Dashboard',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Create user',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View user',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Update user',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete User',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Edit user',
                'guard_name' => 'web',
            ],
           
            [
                'name' => 'View role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'add role',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update role',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Create Department',
                'guard_name' => 'web',
            ],

            [
                'name' => 'View Department',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Edit Department',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Update Department',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Delete Department',
                'guard_name' => 'web',
            ],

            
            [
                'name' => 'Create Designation',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Designation',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Edit Designation',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Update Designation',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Designation',
                'guard_name' => 'web',
            ],

           
            [
                'name' => 'View employee',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create employee',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit employee',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Update employee',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Delete employee',
                'guard_name' => 'web',
            ],

            [
                'name' => 'View asset',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Create asset',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit asset',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Update asset',
                'guard_name' => 'web',
            ],

            [
                'name' => 'Delete asset',
                'guard_name' => 'web',
            ],

            [
                'name' => 'check depreciation',
                'guard_name' => 'web',
            ],
            [
                'name' => 'view leave-type',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create leave-type',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit leave-type',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update leave-type',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete leave-type',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view leave',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create leave',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit leave',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update leave',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete leave',
                'guard_name' => 'web',
            ],


            [
                'name' => 'view perdeim',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create perdeim',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit perdeim',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update perdeim',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete perdeim',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view fund-request',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create fund-request',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit fund-request',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update fund-request',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete fund-request',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view mypayrol',
                'guard_name' => 'web',
            ],
            
            [
                'name' => 'generate payslip',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view overal-payrol',
                'guard_name' => 'web',
            ],
            

            [
                'name' => 'view work-overtime',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create work-overtime',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit work-overtime',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update work-overtime',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete work-overtime',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view deduction',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create deduction',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit deduction',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update deduction',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete deduction',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view benefits',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create benefits',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit benefits',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update benefits',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete benefits',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view salary',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create salary',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit salary',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update salary',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete salary',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view invoice',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create invoice',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit invoice',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update invoice',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete invoice',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view income',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create income',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit income',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update income',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete income',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view expenditure',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create expenditure',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit expenditure',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update expenditure',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete expenditure',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view employee-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create employee-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit employee-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update employee-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete employee-timesheet',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view machine-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create machine-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit machine-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update machine-timesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete machine-timesheet',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view profitlossreport',
                'guard_name' => 'web',
            ],
            [
                'name' => 'view balancesheet',
                'guard_name' => 'web',
            ],

            [
                'name' => 'create balancesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit balancesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update balancesheet',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete balancesheet',
                'guard_name' => 'web',
            ],

            [
                'name' => 'manager approve leave',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manager approve fund-request',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manager approve perdeim',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manager approve work-overtime',
                'guard_name' => 'web',
            ],
            [
                'name' => 'director approve leave',
                'guard_name' => 'web',
            ],
            [
                'name' => 'director approve fund-request',
                'guard_name' => 'web',
            ],
            [
                'name' => 'director approve perdeim',
                'guard_name' => 'web',
            ],
            [
                'name' => 'director approve work-overtime',
                'guard_name' => 'web',
            ],

           

          
            
        ]);

        $this->call(AdminUserSeeder::class);
    }
}
