<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
			'patient_id'	=> $this->id,
			'patient_uuid'	=> $this->uuid,
			'name'	=> $this->name,
			'curp'	=> $this->curp,
			'nss'	=> $this->nss,
			'email'	=> $this->email,
			'telephone'	=> $this->telephone,
		];
	}
}
