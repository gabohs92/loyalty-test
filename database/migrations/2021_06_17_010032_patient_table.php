<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PatientTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->comment('UUID de la tienda');
			$table->string('name')->comment('Nombre del paciente');
			$table->string('curp')->comment('Curp del paciente');
			$table->string('nss')->nullable()->comment('Número seguro social');
			$table->string('email')->comment('Correo del paciente');
			$table->string('telephone')->comment('Número de contacto paciente');

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
