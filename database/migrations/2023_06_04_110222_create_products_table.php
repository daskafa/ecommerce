<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('category_id');

            $table->string('photo')->nullable();
            $table->string('name');
            $table->text('content')->nullable();
            $table->tinyInteger('is_new')->comment('0:Yeni Değil, 1:Yeni');
            $table->string('tags')->nullable();
            $table->string('stock_code');
            $table->double('price', 7, 2);
            $table->mediumInteger('total_stock');
            $table->mediumInteger('remaining_stock');
            $table->tinyInteger('show_stock_counts')->comment('0:Gösterme, 1:Göster. Toplam stok ve kalan stoklar ön yüzde gösterilsin mi');

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
