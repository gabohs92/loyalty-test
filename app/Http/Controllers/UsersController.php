<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Doctor;

use App\Models\Patient;

use App\Traits\ResponsesTrait;

class UsersController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	protected function getUsers()
	{
		$doctors = Doctor::select('uuid', 'name')->get();

		$patients = Patient::select('uuid', 'name')->get();

		return ResponsesTrait::responseSuccess(200, 'Listado de usuarios', ['doctors' => $doctors, 'patients' => $patients]);
	}
}
