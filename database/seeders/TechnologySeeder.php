<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $labels = ['Bootstrap', 'CSS', 'HTML', 'ES6', 'PHP', 'SQL', 'Vue', 'SASS'];

        foreach ($labels as $label) {
            $type = new Technology();

            $type->label = $label;
            $type->color = $faker->hexColor();

            $type->save();
        }
    }
}