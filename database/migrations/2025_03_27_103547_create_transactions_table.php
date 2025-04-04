<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            			$table->increments("id");
			$table->date("date_in")->nullable();
			$table->date("date_out")->nullable();
			$table->time("time_in")->nullable();
			$table->time("time_out")->nullable();
			$table->double("weight_in")->nullable();
			$table->double("weight_out")->nullable();
			$table->string("ref_no",50)->nullable();
			$table->string("police_no",50)->nullable();
			$table->string("driver_name",255)->nullable();
			$table->string("driver_phone",20)->nullable();
			$table->integer("materials_id")->unsigned()->nullable();
			$table->integer("customers_id")->unsigned()->nullable();
			$table->text("remark")->nullable();
			$table->timestamp("created_at")->nullable();
			$table->timestamp("updated_at")->nullable();
			$table->timestamp("deleted_at")->nullable();
			$table->integer("created_by")->nullable();
			$table->integer("updated_by")->nullable();
			$table->integer("deleted_by")->nullable();
        $table->foreign('materials_id')->references('id')->on('master_materials')->onDelete('cascade');

        $table->foreign('customers_id')->references('id')->on('master_customers')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
