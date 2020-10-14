<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;
use Faker\Factory;
use App\Tag;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Factory::create();

      $categories = Category::all();
      
      foreach($categories as $category){
          for($i=1; $i<=30; $i++){
              $Product = Product::create([
                'name'      => $category->name . ' ' .$i,
                'description'   =>$faker->paragraph(),
                'price'         =>$faker->randomFloat(2,100,500),
                'image'        =>'https://via.placeholder.com/150?Text='.str_replace(' ', '+', $category->name) .'+'.$i ,
                'category_id'  =>$category->id,

              ]);
              $tags= Tag::inRandomOrder()->take(3)->pluck('id')->toArray();
              $Product->tags()->attach($tags);
          }
      }
    }
}
