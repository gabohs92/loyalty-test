<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Doctor;

use App\Http\Resources\DoctorResource;

use App\Traits\ResponsesTrait;

class DoctorController extends Controller
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

	protected function index(Request $request)
	{
		$doctors = Doctor::paginate(2);

		return view('doctor.doctor', ['doctors' => $doctors]);;
	}

	protected function show($doctor_uuid)
	{
		$doctor = Doctor::where('uuid', $doctor_uuid)->first();

		if ( ! $doctor )
			return ResponsesTrait::responseFails(400, 'Doctor no encontrado');

		$response = new DoctorResource($doctor);

		return ResponsesTrait::responseSuccess(200, 'Detalle del doctor', $response);
	}

	protected function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'	=> 'required',
			'area'	=> 'required',
			'email'	=> 'required|email',
			'telephone'	=> 'required',
		]);

		if ($validator->fails()) {
			$request->session()->flash('error', implode(" ", $validator->errors()->all()));
			return redirect('doctores');
		}

		$data = [
			'name'	=> $request->input('name'),
			'area'	=> $request->input('area'),
			'email'	=> $request->input('email'),
			'telephone'	=> $request->input('telephone'),
		];

		$doctor = Doctor::create($data);

		$request->session()->flash('status', 'Doctor creado éxitosamente');
		return redirect('doctores');
	}

	protected function update($doctor_uuid, Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'	=> 'required',
			'area'	=> 'required',
			'email'	=> 'required|email',
			'telephone'	=> 'required',
		]);

		if ($validator->fails())
			return ResponsesTrait::responseFails(400, implode(" ", $validator->errors()->all()));

		$doctor = Doctor::where('uuid', $doctor_uuid)->first();

		if ( ! $doctor )
			return ResponsesTrait::responseFails(400, 'Doctor no encontrado');

		$doctor->update([
			'name'	=> $request->input('name'),
			'area'	=> $request->input('area'),
			'email'	=> $request->input('email'),
			'telephone'	=> $request->input('telephone'),
		]);

		$response = new DoctorResource($doctor);

		$request->session()->flash('status', 'Doctor actualizado éxitosamente');
		return ResponsesTrait::responseSuccess(200, 'Doctor actualizado con éxito', $response);
	}

	protected function destroy($doctor_uuid, request $request)
	{
		$doctor = Doctor::where('uuid', $doctor_uuid)->first();

		if ( ! $doctor )
			return ResponsesTrait::responseFails(400, 'Doctor no encontrado');

		$doctor->appointments()->delete();
		$doctor->delete();

		$request->session()->flash('status', 'Doctor eliminado éxitosamente');
		return ResponsesTrait::responseSuccess(200, 'Doctor eliminado con éxito');
	}
}
