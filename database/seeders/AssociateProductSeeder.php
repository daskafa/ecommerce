<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\UserProductFavorite;
use Exception;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AssociateProductSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            $publicPathFiles = File::files(public_path('images'));
            $publicPathFileNames = [];
            foreach ($publicPathFiles as $publicPathFile) {
                $publicPathFileNames[] = $publicPathFile->getFilename();
            }

            $randomCategories = Category::inRandomOrder()->get();
            $faker = Factory::create();

            $productsArr = [];
            foreach ($randomCategories as $randomCategory) {
                $randomIsNew = array_rand((new Product())->getIsNewSituations());
                $randomShowStockCounts = array_rand((new Product())->getShowStockCountsSituations());

                $randomStockCode = 'E-' . $randomCategory->id . '-' . Str::upper(Str::random(10));

                $randomWords = [];

                for ($i = 0; $i < random_int(1, 7); $i++) {
                    $randomWords[] = $faker->word;
                }
                $randomWordsImploded = implode(',', $randomWords);

                $totalStock = $faker->numberBetween(1, 100);
                $remainingStock = 0;
                if ($totalStock > 0) {
                    $remainingStock = $faker->numberBetween(1, $totalStock);
                }

                $productsArr[] = [
                    'category_id' => $randomCategory->id,
                    'photo' => $publicPathFileNames[array_rand($publicPathFileNames)],
                    'name' => 'Product ' . $randomCategory->id,
                    'content' => $faker->text(),
                    'is_new' => $randomIsNew,
                    'tags' => $randomWordsImploded,
                    'stock_code' => $randomStockCode,
                    'price' => $faker->randomFloat(2, 1, 5000),
                    'total_stock' => $totalStock,
                    'remaining_stock' => $remainingStock,
                    'show_stock_counts' => $randomShowStockCounts,
                    'created_at' => now()->addMinute($randomCategory->id)->addSecond($randomCategory->id),
                ];
            }

            Product::insert($productsArr);

            $productRandomIds = Product::inRandomOrder()->pluck('id')->toArray();
            $userRandomIds = User::users()->inRandomOrder()->pluck('id')->toArray();

            $productReviewsArr = [];
            foreach ($productRandomIds as $productRandomId) {
                $productReviewsArr[] = [
                    'product_id' => $productRandomId,
                    'user_id' => $userRandomIds[array_rand($userRandomIds)],
                    'review' => $faker->numberBetween(0, 5),
                    'created_at' => now()->addMinute($productRandomId)->addSecond($productRandomId),
                ];
            }

            $productCommentsArr = [];
            foreach ($productRandomIds as $productRandomId) {
                $productCommentsArr[] = [
                    'product_id' => $productRandomId,
                    'user_id' => $userRandomIds[array_rand($userRandomIds)],
                    'comment' => $faker->text(),
                    'created_at' => now()->addMinute($productRandomId)->addSecond($productRandomId),
                ];
            }

            $userProductFavoritesArr = [];
            foreach ($productRandomIds as $productRandomId) {
                $userProductFavoritesArr[] = [
                    'product_id' => $productRandomId,
                    'user_id' => $userRandomIds[array_rand($userRandomIds)],
                    'created_at' => now()->addMinute($productRandomId)->addSecond($productRandomId),
                ];
            }

            ProductReview::insert($productReviewsArr);
            ProductComment::insert($productCommentsArr);
            UserProductFavorite::insert($userProductFavoritesArr);

            DB::commit();

            $this->command->info('Ürünler başarıyla eklendi.');
        } catch (Exception $exception) {
            DB::rollback();
            $this->command->error('Ürünler eklenirken bir hata oluştu. | ' . $exception->getMessage());
        }
    }
}
