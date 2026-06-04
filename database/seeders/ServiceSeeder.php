<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'id' => 1,
                'name' => 'Photoshoot',
                'slug' => 'photoshoot',
                'description' => '',
                'created_at' => '2018-09-14 11:50:07',
                'updated_at' => '2024-04-10 15:13:02',
            ],
            [
                'id' => 2,
                'name' => 'Weddings',
                'slug' => 'weddings',
                'description' => '',
                'created_at' => '2018-09-14 11:50:07',
                'updated_at' => '2024-04-10 15:12:01',
            ],
            [
                'id' => 3,
                'name' => 'Commercials',
                'slug' => 'commercials',
                'description' => '',
                'created_at' => '2018-09-14 11:50:07',
                'updated_at' => '2024-04-10 15:12:33',
            ],
            [
                'id' => 4,
                'name' => 'Corporates',
                'slug' => 'corporates',
                'description' => '',
                'created_at' => '2018-09-14 11:50:07',
                'updated_at' => '2024-04-10 15:12:55',
            ],
            [
                'id' => 5,
                'name' => 'Families',
                'slug' => 'families',
                'description' => '',
                'created_at' => '2018-09-14 11:50:07',
                'updated_at' => '2024-04-10 15:13:19',
            ],
            [
                'id' => 6,
                'name' => 'Proposals',
                'slug' => 'proposals',
                'description' => '',
                'created_at' => '2018-09-14 11:50:07',
                'updated_at' => '2024-04-10 15:13:40',
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->updateOrInsert(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
