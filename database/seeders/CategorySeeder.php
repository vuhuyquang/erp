<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      [
        'id' => 1,
        'name' => 'Chính trị',
      ],
      [
        'id' => 2,
        'name' => 'Tâm lý học',
      ],
      [
        'id' => 3,
        'name' => 'Giáo dục',
      ],
      [
        'id' => 4,
        'name' => 'Công nghệ',
      ],
      [
        'id' => 5,
        'name' => 'Thể thao',
      ],
    ];

    try {
      Category::insert($categories);
  } catch (\Throwable $th) {
  }
  }
}
