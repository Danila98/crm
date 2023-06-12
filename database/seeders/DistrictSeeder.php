<?php

namespace Database\Seeders;

use App\Models\Geo\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        District::create([
            'id' => 2,
            'name' => 'Центральный федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 3,
            'name' => 'Южный федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 4,
            'name' => 'Северо-западный федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 5,
            'name' => 'Дальневосточный федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 6,
            'name' => 'Сибирский федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 7,
            'name' => 'Уральский федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 8,
            'name' => 'Приволжский федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);

        District::create([
            'id' => 9,
            'name' => 'Северо-Кавказский федеральный округ',
            'created_at' => NULL,
            'updated_at' => NULL
        ]);
    }
}
