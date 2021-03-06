<?php

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
        $this->call(ProductTableSeeder::class);
        $this->call(BannerTableSeeder::class);
        $this->call(PromotionTableSeeder::class);
        $this->call(faqTableSeeder::class);
    }
}
