 <?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                'name'              => 'Product name 1',
                'description'       => 'Decrição do produto 1',
                'image'             => 'images/image1.jpg',
                'price'             => '10.00'
            ],

            [
                'name'              => 'Product name 2',
                'description'       => 'Decrição do produto 2',
                'image'             => 'images/image2.jpg',
                'price'             => '20.00'
            ],
        ]);
    }
}
