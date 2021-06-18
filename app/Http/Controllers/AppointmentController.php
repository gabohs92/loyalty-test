<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

use App\Http\Resources\AppointmentResource;

use App\Traits\ResponsesTrait;

class AppointmentController extends Controller
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
		$appointments = Appointment::paginate(2);

		$now = Carbon::now()->format('Y-m-d') . 'T' . Carbon::now()->format('H:i');

		return view('appointment.appointment', ['appointments' => $appointments, 'now' => $now]);
	}

	protected function show($appointment_uuid)
	{
		$appointment = Appointment::where('uuid', $appointment_uuid)->first();

		if ( ! $appointment )
			return ResponsesTrait::responseFails(400, 'Cita no encontrado');

		$doctors = Doctor::select('uuid', 'name')->get();

		$patients = Patient::select('uuid', 'name')->get();

		$response = new AppointmentResource($appointment);

		return ResponsesTrait::responseSuccess(200, 'Detalle de la cita', ['appointment' => $response, 'doctors' => $doctors, 'patients' => $patients]);
	}

	protected function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'doctor'  => 'required',
			'patient'  => 'required',
			'date'   => 'required'
		]);

		if ($validator->fails()) {
			$request->session()->flash('error', implode(" ", $validator->errors()->all()));
			return redirect('citas');
		}

		$date = Carbon::create($request->input('date'));

		if ( Carbon::now()->greaterThan($date) ) {
			$request->session()->flash('error', 'No se pueden crear citas con fechas pasadas');
			return redirect('citas');
		}

		$doctor = Doctor::where('uuid', $request->input('doctor'))->first();

		if ( ! $doctor ) {
			$request->session()->flash('error', 'Doctor no disponible');
			return redirect('citas');
		}

		$patient = Patient::where('uuid', $request->input('patient'))->first();

		if ( ! $patient ) {
			$request->session()->flash('error', 'Paciente no disponible');
			return redirect('citas');
		}

		$data = [
			'doctor_id' => $doctor->id,
			'patient_id'    => $patient->id,
			'date'  => $date->format('Y-m-d H:i:s')
		];

		$appointment = Appointment::create($data);

		$request->session()->flash('status', 'Cita creada éxitosamente');
		return redirect('citas');
	}

	protected function update($appointment_uuid, Request $request)
	{
		$appointment = Appointment::where('uuid', $appointment_uuid)->first();

		if ( ! $appointment )
			return ResponsesTrait::responseFails(400, 'Cita no encontrada');

		$validator = Validator::make($request->all(), [
            'doctor'  => 'required',
			'patient'  => 'required',
			'date'   => 'required'
        ]);

        if ($validator->fails())
            return ResponsesTrait::responseFails(400, implode(" ", $validator->errors()->all()));

        $date = Carbon::create($request->input('date'));

        if ( Carbon::now()->greaterThan($date) )
        	return ResponsesTrait::responseFails(400, 'No se pueden crear citas con fechas pasadas');

        $doctor = Doctor::where('uuid', $request->input('doctor'))->first();

        if ( ! $doctor )
        	return ResponsesTrait::responseFails(400, 'Doctor no disponible');

        $patient = Patient::where('uuid', $request->input('patient'))->first();

        if ( ! $patient )
        	return ResponsesTrait::responseFails(400, 'Paciente no encontrado');

		$appointment->update([
			'doctor_id' => $doctor->id,
			'patient_id'    => $patient->id,
			'date'  => $date->format('Y-m-d H:i:s')
		]);

		$response = new AppointmentResource($appointment);

		$request->session()->flash('status', 'Cita actualizada éxitosamente');
		return ResponsesTrait::responseSuccess(200, 'Cita actualizada con éxito', $response);
	}

	protected function destroy($appointment_uuid, request $request)
	{
		$appointment = Appointment::where('uuid', $appointment_uuid)->first();

		if ( ! $appointment )
			return ResponsesTrait::responseFails(400, 'Cita no encontrada');

		$appointment->delete();

		$request->session()->flash('status', 'Cita eliminada éxitosamente');
		return ResponsesTrait::responseSuccess(200, 'Cita eliminada con éxito');
	}
}
