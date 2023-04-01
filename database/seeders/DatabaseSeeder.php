<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   
public function run(): void
    {
        /**
         * @var \Illuminate\Support\Collection<array-key, \Illuminate\Support\Collection> $colors
         */
        $colors = collect([
            'color' => collect(['red', 'green', 'blue', 'yellow', 'white', 'black']),
            'weight' => collect(['1000', '500', '750', '1500']),
        ]);
        $keys = collect(['color', 'weight']);

        Product::factory(10)
            ->has(
                Property::factory(5)->state(fn(array $attributes): array => [
                    'name' => $key = $keys->random(),
                    'value' => $colors->get($key)->random(),
                ])
            )
            ->create();
    }
}
