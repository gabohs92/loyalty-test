<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'uuid'	=> $this->uuid,
			'patient_id'	=> $this->patient_id,
			'doctor_id'	=> $this->doctor_id,
			'patient_uuid'	=> $this->patient->uuid,
			'doctor_uuid'	=> $this->doctor->uuid,
			'date'	=> $this->date->format('Y-m-d H:i'),
			'format_date'	=> $this->date->format('Y-m-d') . 'T' . $this->date->format('H:i'),
		];
	}
}
