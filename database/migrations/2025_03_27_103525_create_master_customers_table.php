<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createMasterCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_customers', function (Blueprint $table) {
            			$table->increments("id");
			$table->string("name",255)->nullable();
			$table->string("street",255)->nullable();
			$table->string("district",255)->nullable();
			$table->string("regency",255)->nullable();
			$table->string("province",255)->nullable();
			$table->string("postalcode",255)->nullable();
			$table->string("telephone",20)->nullable();
			$table->string("phone",20)->nullable();
			$table->tinyInteger("status")->nullable();
			$table->text("remark")->nullable();
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
        Schema::dropIfExists('master_customers');
    }
}
