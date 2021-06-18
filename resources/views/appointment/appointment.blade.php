@extends('layouts.app')
@section('title', 'Pacientes')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">

				<div class="card-body">
					@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
					@endif

					@if (session('error'))
						<div class="alert alert-danger" role="alert">
							{{ session('error') }}
						</div>
					@endif
					<div class="row d-flex align-items-center flex-column justify-content-center align-items-center flex-sm-column justify-content-sm-center align-items-sm-center flex-md-row justify-content-md-between align-items-md-center flex-lg-row justify-content-lg-between align-items-lg-center flex-xl-row justify-content-xl-between align-items-xl-center">
						<div class="col d-flex justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start">
							<div class="button-list" style="margin-bottom: 10px;">
								<button type="button" class="btn btn-primary waves-effect waves-light" id="show_new_appointment">
									Crear cita
								</button>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="table-responsive">
								<table id="datatable-buttons" class="table table-bordered table-hover text-center">
									<thead>
										<tr>
											<th calss="text-center">ID</th>
											<th class="text-center">Nombre Doctor</th>
											<th class="text-center">Correo Doctor</th>
											<th class="text-center">Teléfono Doctor</th>
											<th class="text-center">Nombre Paciente</th>
											<th class="text-center">Correo Paciente</th>
											<th class="text-center">Teléfono Paciente</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@if( ! empty($appointments->items()) )
											@foreach($appointments as $key => $appointment)
												<tr id="patient_{{$appointment->id}}">
													<td class="text-center centerAll">
														<p>{{$appointment->uuid}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->doctor->name}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->doctor->email}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->doctor->telephone}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->patient->name}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->patient->email}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->patient->telephone}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$appointment->date->format('Y-m-d H:i')}}</p>
													</td>

													<td class="text-center">
														<div class="row">
															<div class="col d-flex flex-row flex-wrap justify-content-center">
																<button data-id="{{$appointment->uuid}}" type="button" class="btn btn-success waves-effect waves-light mb-1 btn-edit">
																	Editar
																</button>
																<button type="button" data-id="{{$appointment->uuid}}" class="btn btn-danger waves-effect waves-light btn-delete ml-1 mb-1">Eliminar</button>
															</div>
														</div>
													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td class="text-center" colspan="9">
													<p>No hay citas registradas</p>
												</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>

							{{$appointments->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="new_appointment">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Nueva cita</h4>
				</div>
				<form action="/citas" method="POST" role="form">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label for="doctor">Doctor:</label>
							<select name="doctor" id="doctor" class="form-control" required="required">
								<option value="">Seleccione una opción</option>
							</select>
						</div>

						<div class="form-group">
							<label for="patient">Paciente:</label>
							<select name="patient" id="patient" class="form-control" required="required">
								<option value="">Seleccione una opción</option>
							</select>
						</div>

						<div class="form-group">
							<label for="date">Fecha:</label>
							<input type="datetime-local" name="date" id="date" min="{{$now}}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit_patient">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Editar paciente</h4>
				</div>
				<form action="" id="form_edit_patient" method="POST" role="form">
					<div class="modal-body">
						<input type="hidden" name="edit_uuid" id="edit_uuid" class="form-control" value="">
						<div class="form-group">
							<label for="edit_doctor">Doctor:</label>
							<select name="edit_doctor" id="edit_doctor" class="form-control" required="required">
								<option value="">Seleccione una opción</option>
							</select>
						</div>

						<div class="form-group">
							<label for="select_edit_patient">Paciente:</label>
							<select name="select_edit_patient" id="select_edit_patient" class="form-control" required="required">
								<option value="">Seleccione una opción</option>
							</select>
						</div>

						<div class="form-group">
							<label for="edit_date">Fecha:</label>
							<input type="datetime-local" name="edit_date" id="edit_date" min="{{$now}}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Actualizar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('JS')
	<script type="text/javascript">
		$('.date-appoinment').datetimepicker({
		    format: 'DD-MM-YYYY hh:mm A',
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#new_appointment').on('hidden.bs.modal', function () {
				$('#doctor').empty();
				$('#doctor').append($("<option />").val('').text('Seleccione una opción'));
				$('#patient').empty();
				$('#patient').append($("<option />").val('').text('Seleccione una opción'));
			});

			$('#show_new_appointment').click(function(event) {
				$.ajax({
					url: 'usuarios',
					type: 'GET'
				})
				.done(function(response) {
					$.each(response.data.doctors, function() {
					    $('#doctor').append($("<option />").val(this.uuid).text(this.name));
					    // $('#edit_doctor').append($("<option />").val(this.uuid).text(this.name));
					});

					$.each(response.data.patients, function() {
					    $('#patient').append($("<option />").val(this.uuid).text(this.name));
					    // $('#edit_patient').append($("<option />").val(this.uuid).text(this.name));
					});

					$('#new_appointment').modal('show');
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					errors = JSON.parse(jqXHR.responseText);
					message = errors.message ? errors.message : 'Algo salió mal';
					Swal.fire(
						'Error',
						message,
						'error'
					);
				});
			});

			$('#edit_patient').on('hidden.bs.modal', function () {
				$('#edit_doctor').empty();
				$('#edit_doctor').append($("<option />").val('').text('Seleccione una opción'));
				$('#select_edit_patient').empty();
				$('#select_edit_patient').append($("<option />").val('').text('Seleccione una opción'));
			});

			function fill_edit(response) {
				$.each(response.doctors, function(index, val) {
					$('#edit_doctor').append($("<option />").val(this.uuid).text(this.name));
					if ( response.appointment.doctor_uuid == this.uuid ) {
						$('#edit_doctor').val(this.uuid);
					}
				});

				$.each(response.patients, function() {
					$('#select_edit_patient').append($("<option />").val(this.uuid).text(this.name));
					if ( response.appointment.patient_uuid == this.uuid ) {
						$('#select_edit_patient').val(this.uuid);
					}
				});

				$('#edit_date').val(response.appointment.format_date);
				$('#edit_uuid').val(response.appointment.uuid);
			}

			$('.btn-edit').click(function(event) {
				uuid = $(this).attr('data-id');

				$.ajax({
					url: '/citas/' + uuid,
					type: 'GET',
				})
				.done(function(response) {
					fill_edit(response.data);
					$('#edit_patient').modal('show'); 
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					errors = JSON.parse(jqXHR.responseText);
					message = errors.message ? errors.message : 'Algo salió mal';
					Swal.fire(
						'Error',
						message,
						'error'
					);
				});
			});

			$('.btn-delete').click(function(event) {
				uuid = $(this).attr('data-id');

				Swal.fire({
					title: 'Eliminar paciente',
					text: "¿Estás seguro de eliminar este paciente? Todas las citas que tenía agendadas se perderán",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					cancelButtonText: 'Cancelar',
					confirmButtonText: 'Sí',
					reverseButtons: true,
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: '/citas/' + uuid,
							type: 'DELETE',
						})
						.done(function(response) {
							location.reload();
						})
						.fail(function(jqXHR, textStatus, errorThrown) {
							errors = JSON.parse(jqXHR.responseText);
							message = errors.message ? errors.message : 'Algo salió mal';
							Swal.fire(
								'Error',
								message,
								'error'
							);
						});
					}
				});
			});

			$('#form_edit_patient').submit(function(event) {
				event.preventDefault();

				$.ajax({
					url: '/citas/' + $('#edit_uuid').val(),
					type: 'PUT',
					data: {
						doctor: $('#edit_doctor').val(),
						patient: $('#select_edit_patient').val(),
						date: $('#edit_date').val()
					},
				})
				.done(function(response) {
					location.reload();
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					errors = JSON.parse(jqXHR.responseText);
					message = errors.message ? errors.message : 'Algo salió mal';
					Swal.fire(
						'Error al actualizar',
						message,
						'error'
					);
				});
				
			});
		});
	</script>
@endsection
