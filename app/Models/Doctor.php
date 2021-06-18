<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuids;

class Doctor extends Model
{
	use SoftDeletes, Uuids;

	protected $table = 'doctor';

	protected $fillable = [
		'uuid',
		'name',
		'area',
		'email',
		'telephone',
	];

	public function appointments()
	{
		return $this->hasMany(Appointment::class, 'doctor_id', 'id');
	}
}
