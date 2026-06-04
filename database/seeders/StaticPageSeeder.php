<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'id' => 1,
                'name' => 'Home',
                'slug' => 'home',
                'cover_title' => '',
                'cover_paragraph' => '',
                'info_title' => '',
                'info_paragraph' => '',
                'cover_image_path' => '',
                'gallery' => null,
                'created_at' => '2018-09-14 10:50:07',
                'updated_at' => '2023-06-19 18:46:18',
            ],
            [
                'id' => 2,
                'name' => 'About',
                'slug' => 'about',
                'cover_title' => '',
                'cover_paragraph' => '',
                'info_title' => '',
                'info_paragraph' => '',
                'cover_image_path' => '',
                'gallery' => null,
                'created_at' => '2018-09-14 10:50:07',
                'updated_at' => '2023-06-19 18:46:18',
            ],
            [
                'id' => 3,
                'name' => 'Contact',
                'slug' => 'contact',
                'cover_title' => '',
                'cover_paragraph' => '',
                'info_title' => '',
                'info_paragraph' => '',
                'cover_image_path' => '',
                'gallery' => null,
                'created_at' => '2018-09-14 10:50:07',
                'updated_at' => '2023-06-19 18:46:18',
            ],
        ];

        foreach ($pages as $page) {
            DB::table('static_pages')->updateOrInsert(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
