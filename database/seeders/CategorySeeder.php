<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //save() create() createMany() -- you can use any of these

        $categories = [
            [
                'name' => 'TV',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Theatre',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Wellness',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->category->insert($categories);
        //insert() - similar to createMany, but doesn't need $fillable
    }
}
