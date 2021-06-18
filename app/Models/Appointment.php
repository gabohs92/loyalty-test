<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuids;

class Appointment extends Model
{
	use SoftDeletes, Uuids;

	protected $table = 'appointment';

	protected $fillable = [
		'uuid',
		'patient_id',
		'doctor_id',
		'date',
	];

	protected $dates = ['date'];

	public function doctor()
	{
		return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'patient_id', 'id');
	}
}
