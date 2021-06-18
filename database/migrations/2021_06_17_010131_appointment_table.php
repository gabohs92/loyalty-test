<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppointmentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointment', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->comment("UUID de la tienda");
			$table->unsignedInteger('patient_id')->comment("Id del paciente");
			$table->unsignedInteger('doctor_id')->comment("Id del doctor");
			$table->datetime('date')->comment("Fecha de consulta");

			$table->timestamps();
			$table->softDeletes();

			$table->index(['patient_id'], 'FK_appointment_patient_idx');
			$table->index(['doctor_id'], 'FK_appointment_doctor_idx');
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
