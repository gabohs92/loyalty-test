<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuids;

class Patient extends Model
{
	use SoftDeletes, Uuids;

	protected $table = 'patient';

	protected $fillable = [
		'uuid',
		'name',
		'curp',
		'nss',
		'email',
		'telephone',
	];

	public function appointments()
	{
		return $this->hasMany(Appointment::class, 'patient_id', 'id');
	}
}
