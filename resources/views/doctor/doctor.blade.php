@extends('layouts.app')
@section('title', 'Doctores')
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
								<a class="btn btn-primary waves-effect waves-light" data-toggle="modal" href='#new_doctor'>
									Crear doctor
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
											<th class="text-center">Área</th>
											<th class="text-center">Correo</th>
											<th class="text-center">Teléfono</th>
											<th class="text-center">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@if( ! empty($doctors->items()) )
											@foreach($doctors as $key => $doctor)
												<tr id="doctor_{{$doctor->id}}">
													<td class="text-center centerAll">
														<p>{{$doctor->uuid}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$doctor->name}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$doctor->area}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$doctor->email}}</p>
													</td>
													<td class="text-center centerAll">
														<p>{{$doctor->telephone}}</p>
													</td>
													

													<td class="text-center">
														<div class="row">
															<div class="col d-flex flex-row flex-wrap justify-content-center">
																<button data-id="{{$doctor->uuid}}" type="button" class="btn btn-success waves-effect waves-light mb-1 btn-edit">
																	Editar
																</button>
																<button type="button" data-id="{{$doctor->uuid}}" class="btn btn-danger waves-effect waves-light btn-delete ml-1 mb-1">Eliminar</button>
															</div>
														</div>
													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td class="text-center centerAll" colspan="6">
													<p>No hay doctores registrados</p>
												</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>

							{{$doctors->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="new_doctor">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Nuevo doctor</h4>
				</div>
				<form action="/doctores" method="POST" role="form">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Nombre</label>
							<input type="text" class="form-control" name="name" id="name" required="required" placeholder="Nombre del doctor">
						</div>

						<div class="form-group">
							<label for="email">Correo</label>
							<input type="text" class="form-control" name="email" id="email" required="required" placeholder="Correo del doctor">
						</div>

						<div class="form-group">
							<label for="telephone">Teléfono</label>
							<input type="text" class="form-control" name="telephone" id="telephone" required="required" placeholder="Telefono del doctor">
						</div>

						<div class="form-group">
							<label for="area">Área</label>
							<textarea name="area" id="area" class="form-control" rows="3" required="required"></textarea>
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

	<div class="modal fade" id="edit_doctor">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Editar doctor</h4>
				</div>
				<form action="" id="form_edit_doctor" method="POST" role="form">
					<div class="modal-body">
						<input type="hidden" name="edit_uuid" id="edit_uuid" class="form-control" value="">
						<div class="form-group">
							<label for="edit_name">Nombre</label>
							<input type="text" class="form-control" name="edit_name" id="edit_name" required="required" placeholder="Nombre del doctor">
						</div>

						<div class="form-group">
							<label for="edit_email">Correo</label>
							<input type="text" class="form-control" name="edit_email" id="edit_email" required="required" placeholder="Correo del doctor">
						</div>

						<div class="form-group">
							<label for="edit_telephone">Teléfono</label>
							<input type="text" class="form-control" name="edit_telephone" id="edit_telephone" required="required" placeholder="Telefono del doctor">
						</div>

						<div class="form-group">
							<label for="edit_area">Área</label>
							<textarea name="edit_area" id="edit_area" class="form-control" rows="3" required="required"></textarea>
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

			$('#edit_doctor').on('hidden.bs.modal', function () {
				$('#form_edit_doctor').find('input').val("");
				$('#form_edit_doctor').find('textarea').val("");
			});

			function fill_edit(response) {
				$('#edit_name').val(response.name);
				$('#edit_email').val(response.email);
				$('#edit_telephone').val(response.telephone);
				$('#edit_area').val(response.area);
				$('#edit_uuid').val(response.doctor_uuid);
			}

			$('.btn-edit').click(function(event) {
				uuid = $(this).attr('data-id');

				$.ajax({
					url: '/doctores/' + uuid,
					type: 'GET',
				})
				.done(function(response) {
					fill_edit(response.data);
					$('#edit_doctor').modal('show'); 
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
					title: 'Eliminar doctor',
					text: "¿Estás seguro de eliminar este doctor? Todas las citas que tenía agendadas se perderán",
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
							url: '/doctores/' + uuid,
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

			$('#form_edit_doctor').submit(function(event) {
				event.preventDefault();

				$.ajax({
					url: '/doctores/' + $('#edit_uuid').val(),
					type: 'PUT',
					data: {
						name: $('#edit_name').val(),
						email: $('#edit_email').val(),
						telephone: $('#edit_telephone').val(),
						area: $('#edit_area').val()
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
