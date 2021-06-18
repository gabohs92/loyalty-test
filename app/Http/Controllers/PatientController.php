<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Patient;

use App\Http\Resources\PatientResource;

use App\Traits\ResponsesTrait;

class PatientController extends Controller
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
		$patients = Patient::paginate(2);

		return view('patient.patient', ['patients' => $patients]);;
	}

	protected function show($patient_uuid)
	{
		$patient = Patient::where('uuid', $patient_uuid)->first();

		if ( ! $patient )
			return ResponsesTrait::responseFails(400, 'Paciente no encontrado');

		$response = new PatientResource($patient);

		return ResponsesTrait::responseSuccess(200, 'Detalle del paciente', $response);
	}

	protected function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'	=> 'required',
			'curp'	=> 'required',
			'nss'	=> 'required',
			'email'	=> 'required|email',
			'telephone'	=> 'required'
		]);

		if ($validator->fails()) {
			$request->session()->flash('error', implode(" ", $validator->errors()->all()));
			return redirect('pacientes');
		}

		$data = [
			'name'	=> $request->input('name'),
			'curp'	=> $request->input('curp'),
			'nss'	=> $request->input('nss'),
			'email'	=> $request->input('email'),
			'telephone'	=> $request->input('telephone'),
		];

		$patient = Patient::create($data);

		$request->session()->flash('status', 'Paciente creado éxitosamente');
		return redirect('pacientes');
	}

	protected function update($patient_uuid, Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'	=> 'required',
			'curp'	=> 'required',
			'nss'	=> 'required',
			'email'	=> 'required|email',
			'telephone'	=> 'required'
		]);

		if ($validator->fails())
			return ResponsesTrait::responseFails(400, implode(" ", $validator->errors()->all()));

		$patient = Patient::where('uuid', $patient_uuid)->first();

		if ( ! $patient )
			return ResponsesTrait::responseFails(400, 'Paciente no encontrado');

		$patient->update([
			'name'	=> $request->input('name'),
			'curp'	=> $request->input('curp'),
			'nss'	=> $request->input('nss'),
			'email'	=> $request->input('email'),
			'telephone'	=> $request->input('telephone'),
		]);

		$response = new PatientResource($patient);

		$request->session()->flash('status', 'Paciente actualizado éxitosamente');
		return ResponsesTrait::responseSuccess(200, 'Paciente actualizado con éxito', $response);
	}

	protected function destroy($patient_uuid, request $request)
	{
		$patient = Patient::where('uuid', $patient_uuid)->first();

		if ( ! $patient )
			return ResponsesTrait::responseFails(400, 'Paciente no encontrado');

		$patient->appointments()->delete();
		$patient->delete();

		$request->session()->flash('status', 'Paciente eliminado éxitosamente');
		return ResponsesTrait::responseSuccess(200, 'Paciente eliminado con éxito');
	}
}
