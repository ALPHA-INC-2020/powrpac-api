<?php

use App\FAQ;
use Illuminate\Database\Seeder;

class faqTableSeeder extends Seeder
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
            FAQ::create([
                'question' => "this is question" . $faker->sentence,
                'answer' => $faker->sentence,
            ]);
        }

    }
}
