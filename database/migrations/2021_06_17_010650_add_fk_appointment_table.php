<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkAppointmentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('appointment', function (Blueprint $table) {
			$table->foreign('patient_id')->references('id')->on('patient')->onDelete('no action')->onUpdate('no action');
			$table->foreign('doctor_id')->references('id')->on('doctor')->onDelete('no action')->onUpdate('no action');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('appointment', function (Blueprint $table) {
			$table->dropForeign(['patient_id']);
			$table->dropForeign(['doctor_id']);
		});
	}
}
