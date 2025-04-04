<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createMasterMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_materials', function (Blueprint $table) {
            			$table->increments("id");
			$table->string("code",50)->nullable();
			$table->string("name",255)->nullable();
			$table->string("pack",50)->nullable();
			$table->string("content",50)->nullable();
			$table->text("remark")->nullable();
			$table->tinyInteger("status")->nullable();
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
        Schema::dropIfExists('master_materials');
    }
}
