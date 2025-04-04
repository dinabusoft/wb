<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            			$table->increments("id");
			$table->string("name",50)->nullable();
			$table->integer("port")->nullable();
			$table->string("baudrate",50)->nullable();
			$table->string("databits",50)->nullable();
			$table->string("stopbits",50)->nullable();
			$table->string("parity",50)->nullable();
			$table->integer("inputlen")->nullable();
			$table->string("threshold",50)->nullable();
			$table->string("delimiter",50)->nullable();
			$table->integer("index")->nullable();
			$table->tinyInteger("status")->nullable();
			$table->text("remark")->nullable();
			$table->text("log")->nullable();
			$table->timestamp("created_at")->nullable();
			$table->timestamp("updated_at")->nullable();
			$table->timestamp("deleted_at")->nullable();
			$table->integer("created_by")->nullable();
			$table->integer("updated_by")->nullable();
			$table->integer("deleted_by")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
