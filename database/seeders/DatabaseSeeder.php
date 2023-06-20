<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $users = [
            [
                'name'     => 'Phú Phan',
                'email'    => 'phuphan@gmail.com',
                'password' => bcrypt('123456789')
            ],
            [
                'name'     => 'Hạ Linh',
                'email'    => 'halinh@gmail.com',
                'password' => bcrypt('123456789')
            ]
        ];

        foreach ($users as $item) {
            try{
                print_r($item);
                $item['created_at'] = Carbon::now();
                User::create($item);
            }catch (\Exception $exception) {
                Log::error(json_encode($exception->getMessage()));
            }
        }
    }
}
