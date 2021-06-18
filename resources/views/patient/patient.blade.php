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
								<a class="btn btn-primary waves-effect waves-light" data-toggle="modal" href='#new_patient'>
									Crear paciente
								</a>
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
											<th class="text-center">Nombre</th>
											<th class="text-center">Correo</th>
											<th class="text-center">CURP</th>
											<th class="text-center">NSS</th>
											<th class="text-center">Teléfono</th>
											<th class="text-center">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@if( ! empty($patients->items()) )
											@foreach($patients as $key => $patient)
												<tr id="patient_{{$patient->id}}">
													<td class="text-center centerAll">
														<p>{{$patient->uuid}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$patient->name}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$patient->email}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$patient->curp}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$patient->nss}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$patient->telephone}}</p>
													</td>
													

													<td class="text-center">
														<div class="row">
															<div class="col d-flex flex-row flex-wrap justify-content-center">
																<button data-id="{{$patient->uuid}}" type="button" class="btn btn-success waves-effect waves-light mb-1 btn-edit">
																	Editar
																</button>
																<button type="button" data-id="{{$patient->uuid}}" class="btn btn-danger waves-effect waves-light btn-delete ml-1 mb-1">Eliminar</button>
															</div>
														</div>
													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td class="text-center" colspan="7">
													<p>No hay pacientes registrados</p>
												</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>

							{{$patients->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="new_patient">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Nuevo paciente</h4>
				</div>
				<form action="/pacientes" method="POST" role="form">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Nombre</label>
							<input type="text" class="form-control" name="name" id="name" required="required" placeholder="Nombre del paciente">
						</div>

						<div class="form-group">
							<label for="email">Correo</label>
							<input type="text" class="form-control" name="email" id="email" required="required" placeholder="Correo del paciente">
						</div>

						<div class="form-group">
							<label for="telephone">Teléfono</label>
							<input type="text" class="form-control" name="telephone" id="telephone" required="required" placeholder="Telefono del paciente">
						</div>

						<div class="form-group">
							<label for="curp">CURP</label>
							<input type="text" class="form-control" name="curp" id="curp" required="required" placeholder="CURP del paciente">
						</div>

						<div class="form-group">
							<label for="nss">NSS</label>
							<input type="text" class="form-control" name="nss" id="nss" required="required" placeholder="Número seguro social">
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
							<label for="edit_name">Nombre</label>
							<input type="text" class="form-control" name="edit_name" id="edit_name" required="required" placeholder="Nombre del paciente">
						</div>

						<div class="form-group">
							<label for="edit_email">Correo</label>
							<input type="text" class="form-control" name="edit_email" id="edit_email" required="required" placeholder="Correo del paciente">
						</div>

						<div class="form-group">
							<label for="edit_telephone">Teléfono</label>
							<input type="text" class="form-control" name="edit_telephone" id="edit_telephone" required="required" placeholder="Telefono del paciente">
						</div>

						<div class="form-group">
							<label for="edit_curp">CURP</label>
							<input type="text" class="form-control" name="edit_curp" id="edit_curp" required="required" placeholder="CURP del paciente">
						</div>

						<div class="form-group">
							<label for="edit_nss">NSS</label>
							<input type="text" class="form-control" name="edit_nss" id="edit_nss" required="required" placeholder="Número seguro social">
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
		$(document).ready(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#edit_patient').on('hidden.bs.modal', function () {
				$('#form_edit_patient').find('input').val("");
				$('#form_edit_patient').find('textarea').val("");
			});

			function fill_edit(response) {
				$('#edit_name').val(response.name);
				$('#edit_email').val(response.email);
				$('#edit_telephone').val(response.telephone);
				$('#edit_curp').val(response.curp);
				$('#edit_nss').val(response.nss);
				$('#edit_uuid').val(response.patient_uuid);
			}

			$('.btn-edit').click(function(event) {
				uuid = $(this).attr('data-id');

				$.ajax({
					url: '/pacientes/' + uuid,
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
							url: '/pacientes/' + uuid,
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
					url: '/pacientes/' + $('#edit_uuid').val(),
					type: 'PUT',
					data: {
						name: $('#edit_name').val(),
						email: $('#edit_email').val(),
						telephone: $('#edit_telephone').val(),
						curp: $('#edit_curp').val(),
						nss: $('#edit_nss').val()
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
