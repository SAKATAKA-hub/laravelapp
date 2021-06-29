<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('氏名');
            $table->string('kana_name')->comment('ふりがな');
            $table->string('department')->comment('所属部署');
            $table->string('position')->comment('役職');
            $table->string('gender')->comment('性別');
            $table->string('birthday')->comment('生年月日')->nullable();
            $table->string('tell')->comment('電話番号');
            $table->string('email')->comment('メールアドレス');
            $table->string('image')->comment('画像')->nullable();
            $table->string('hire_date')->comment('入社日')->nullable();
            $table->string('leave_date')->comment('退社日')->nullable()->defolut(NULL);
            $table->string('pass_id')->comment('パスワードID')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
