<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DoctorTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->comment("UUID de la tienda");
			$table->string('name')->comment("Nombre del doctor");
			$table->text('area')->nullable()->comment("Especialidad del doctor");
			$table->string('email')->comment("Correo del doctor");
			$table->string('telephone')->comment("Número de contacto doctor");

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
		//
	}
}
