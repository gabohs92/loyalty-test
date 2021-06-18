<template>
    <div class="modal fade" id="new_appointment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nueva cita!!!</h4>
                    </div>
                    <form action="/citas" method="POST" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="doctor">Doctor:</label>
                                <select v-model="doctor" name="doctor" id="doctor" class="form-control" required="required">
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="patient">Paciente:</label>
                                <select  v-model="patient" name="patient" id="patient" class="form-control" required="required">
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="telephone">Fecha:</label>
                                <datetime v-model="date" format="YYYY-MM-DD H:i:s" width="300px" name='dob'></datetime>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" @click="crear()">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</template>

<script>
    import datetime from 'vuejs-datetimepicker';
    import $ from 'jquery';

    export default {
        data() {
            return {
                doctor: '',
                patient: '',
                date: ''
            }
        },
        props:{
            appointmentdata:{
              required:true,
              type: Object
            },
        },
        mounted() {
            console.log(this.appointmentdata);
        },
        components: { datetime },
        methods: {
            crear() {
                let data = {
                    doctor_uuid: this.doctor,
                    patient_uuid: this.patient,
                    date: this.date
                };
                Swal.fire(
                        'Error',
                        'Hola',
                        'error'
                    );

                console.log(data);

                // axios.post('citas', data).then((response) => {
                //     console.log(response.data);
                // }).catch(e => {
                //     console.log(e);
                // });
            }
        }
    }
</script>
