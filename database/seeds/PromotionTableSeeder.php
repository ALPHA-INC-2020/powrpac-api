<?php

use App\Promotion;
use Illuminate\Database\Seeder;

class PromotionTableSeeder extends Seeder
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
            Promotion::create([
                'title' => $faker->name,
                'content' => '<p> this is text</p> <b> this is bold </b>',
                'imageURLs' => ['https://unionpowerpac.com.mm/promotions/tadingyut/promo_one.jpg', 'https://unionpowerpac.com.mm/promotions/tadingyut/promo_two.jpg', 'https://unionpowerpac.com.mm/promotions/tadingyut/promo_three.jpg', 'https://unionpowerpac.com.mm/promotions/tadingyut/promo_four.jpg'],
            ]);
        }
    }
}
