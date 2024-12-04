<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Staffs;
use App\Models\User;
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
//        \App\Models\User::factory(10)->create();

//        if (count(Staffs::all()) == 0) {
//            \App\Models\Branches::create([
//                'name' => 'Branch 1',
//                'location' => 'Kochi',
//            ]);
//            $users = User::all();
//            foreach ($users as $user) {
//                $staff = new Staffs();
//                $staff->branch_id = 1;
//                $staff->user_id = $user->id;
//                $staff->full_name = $user->name;
//                $staff->save();
//            }
//        }

        $this->call([
            PermissionSeeder::class
        ]);
    }
}
