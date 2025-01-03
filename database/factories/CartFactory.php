<?php
namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\ProductRentModel as Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 10), // Jumlah produk
        ];
    }
}
