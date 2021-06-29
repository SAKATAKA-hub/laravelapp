<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkedRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worked_records', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->comment('従業員ID');
            $table->integer('work_num')->comment('勤務回数');
            $table->date('date')->comment('出勤日');
            $table->time('in')->comment('出勤入力')->default(NULL);
            $table->time('out')->comment('退勤入力')->default(NULL);
            $table->string('breaks')->comment('休憩入力')->default(NULL);
            $table->time('RestrainTime')->comment('勤務時間')->default(NULL);
            $table->time('BreakTime')->comment('休憩時間')->default(NULL);
            $table->time('WorkingTime')->comment('労働時間')->default(NULL);
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
        Schema::dropIfExists('worked_records');
    }
}
