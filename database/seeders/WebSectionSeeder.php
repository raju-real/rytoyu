<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\WebPageSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class WebSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Start with the current maximum sorting_serial in the database or 0 if empty
        $currentMaxSortingSerial = WebPageSection::max('sorting_serial') ?: 0;

        // Predefined sections
        $sections = [
            [
                'section_slug' => 'flash-sale',
                'section_title' => 'Flash Sale',
                'section_module' => 'flash-sale',
                'section_for' => 'product',
            ],
            [
                'section_slug' => 'new-arrivals',
                'section_title' => 'New Arrivals',
                'section_module' => 'new-arrivals',
                'section_for' => 'product',
            ]
        ];

        // Add the predefined sections with incrementing sorting_serial
        foreach ($sections as $section) {
            $currentMaxSortingSerial++;
            WebPageSection::insert([
                'section_slug' => $section['section_slug'],
                'section_title' => $section['section_title'],
                'section_module' => $section['section_module'],
                'section_for' => $section['section_for'],
                'sorting_serial' => $currentMaxSortingSerial,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add sections based on categories
        foreach (Category::all() as $category) {
            $currentMaxSortingSerial++;
            WebPageSection::insert([
                'section_slug' => $category->slug,
                'section_title' => $category->name,
                'section_module' => 'category',
                'section_for' => 'category',
                'category_id' => $category->id,
                'sorting_serial' => $currentMaxSortingSerial,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add the final featured section
        WebPageSection::insert([
            'section_slug' => 'featured-arrivals',
            'section_title' => 'Featured Products',
            'section_module' => 'featured-arrivals',
            'section_for' => 'product',
            'sorting_serial' => ++$currentMaxSortingSerial,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

}
