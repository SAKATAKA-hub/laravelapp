<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('従業員ID');
            $table->date('date')->comment('出勤日');
            $table->string('place')->comment('勤務地');
            $table->integer('in')->comment('出勤入力');
            $table->integer('out')->comment('退勤入力')->nullable()->default(null);
            $table->integer('RestrainTime')->comment('勤務時間')->nullable()->default(null);
            $table->integer('BreakTime')->comment('休憩時間')->nullable()->default(null);
            $table->integer('WorkingTime')->comment('労働時間')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('employee_id')
            ->references('id')
            ->on('employees') //存在しないidの登録は不可
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
        Schema::dropIfExists('works');
    }
}
