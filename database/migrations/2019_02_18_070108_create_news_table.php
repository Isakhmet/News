<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('alias')->unique();
            $table->text('anons');
            $table->string('image')->nullable();
            $table->string('image_copyright')->nullable();
            $table->longText('description');
            $table->boolean('status');
            $table->timestamp('active_at');
            $table->timestamp('active_end')->nullable();
            $table->text('settings');
            $table->integer('locale_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
