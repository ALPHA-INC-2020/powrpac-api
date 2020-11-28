<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $details = [];
        $imageURLs = ['https://cdn.shopify.com/s/files/1/2219/4035/products/10_57b494a3-de4b-48ea-aa5a-7a37837b9dd1_1024x1024.jpg?v=1502162950', 'https://cdn.shopify.com/s/files/1/0259/2876/1406/products/product5_524e241c-f1ad-4fd1-b8dd-00841286281d_2000x.png?v=1586927307'];
        for ($i = 1; $i < 5; $i++) {
            array_push($details, $faker->text);
        }
        for ($i = 0; $i < 10; $i++) {
            $productName = $faker->name;

            Product::create([
                'model' => $faker->name,
                'productName' => $productName,
                'navigator' => str_replace(' ', '_', $productName),
                'brand' => $faker->randomElement(['iFan', 'PowerPac', 'MyChoice']),
                'rating' => rand(1, 5),
                'realPrice' => $faker->numberBetween(5000, 10000),
                'promoPrice' => $faker->numberBetween(5000, 10000) - 2000,
                'type' => $faker->randomElement(['fan', 'cooker', 'blender']),
                'productType' => $faker->randomElement(['Wall Fan', 'Stand Fan', 'Desk Fan']),
                'sale' => $faker->randomElement(['outstock', 'onsale', 'preorder']),
                'details' => $details,
                'imageURLs' => $imageURLs,
            ]);

        }
    }
}
