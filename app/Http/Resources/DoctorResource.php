<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
			'doctor_id'	=> $this->id,
			'doctor_uuid'	=> $this->uuid,
			'name'	=> $this->name,
			'area'	=> $this->area,
			'email'	=> $this->email,
			'telephone'	=> $this->telephone,
		];
	}
}
