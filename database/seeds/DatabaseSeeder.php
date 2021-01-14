<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::unguard();
        $this->call(UserTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(LocalityTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(HTMLSeeder::class);
        $this->call(SidebarHTMLsSeeder::class);
        $this->call(BlogsTableSeeder::class);
        $this->call(ListingTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
//        User::reguard();

    }
}
