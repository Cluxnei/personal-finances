<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inflow;
use App\Models\Outflow;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Developer Master',
            'email' => 'dev@dev.dev',
            'password' => Hash::make('dev'),
        ]);

        // $categories = Category::factory()->count(5)->create();

        // Inflow::factory()->count(100)->make()->each(function ($inflow) use ($categories, $user) {
        //     $inflow->category_id = $categories->random(1)->first()->id;
        //     $inflow->user_id = $user->id;
        //     $inflow->save();
        // });

        // Outflow::factory()->count(100)->make()->each(function ($outflow) use ($categories, $user) {
        //     $outflow->category_id = $categories->random(1)->first()->id;
        //     $outflow->user_id = $user->id;
        //     $outflow->save();
        // });

    }
}
