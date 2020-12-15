<?php

use App\Banner;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Banner::create([
                'banner_title' => $faker->randomElement(['Happy Thadingyut', 'Happy Tazaundiang', 'Happy Thingyan', 'Happy December']),
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRA46D6RIgZT725S5goC2PIrSZg76NLbneGMw&usqp=CAU',
            ]);
        }
    }
}
