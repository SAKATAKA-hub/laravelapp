<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_breaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id')->comment('勤務番号');
            $table->integer('in')->comment('休憩開始');
            $table->integer('out')->comment('休憩終了')->nullable()->default(null);
            $table->integer('total_time')->comment('合計時間')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('work_id')
            ->references('id')
            ->on('works') //存在しないidの登録は不可
            ->onDelete('cascade');//主テーブルに関連する従テーブルのレコードを削除

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_breaks');
    }
}
