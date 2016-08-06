@extends ('home.app')

@section('app_header')
	<meta id="_token" value="{{ csrf_token() }}">
@stop

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-10 col-sm-offset-1">
				<refuge></refuge>
			</div>
		</div>
	</div>

	<template id="RefugeResource">

		<section>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Registrar Refugio de Refugios</h3>
				</div>
				<div class="panel-body">
					<form action="#" method="POST" id="Form" @submit.prevent="storeRefuge" class="form-horizontal" role="form">

						<div class="form-group">
							<label class="col-sm-2 control-label">Dirección</label>
							<div class="col-sm-10">
								<input type="text" name="address" v-model="form.direccion" class="form-control" placeholder="Dirección" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Capacidad</label>
							<div class="col-sm-10">
								<input type="number" name="capacity" v-model="form.capacidad" class="form-control" value="" min="1" max="10" step="1" required="required" placeholder="Capacidad de refugiados" number>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Complejidad</label>
							<div class="col-sm-10">
								<select name="complexity" v-model="form.complejidad" class="form-control" required="required" number>
									<option value="">Seleccione</option>
									<option value="1">Riesgo</option>
									<option value="2">Amenaza</option>
									<option value="3">Violencia</option>
									<option value="4">Emergencia</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Disponibilidad</label>
							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Lunes">
										Lunes
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Martes">
										Martes
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Miercoles">
										Miercoles
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Jueves">
										Jueves
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Viernes">
										Viernes
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Sabado">
										Sábado
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="availability[]" v-model="form.disponibilidad" value="Domingo">
										Domingo
									</label>
								</div>
							</div>
						</div>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">Registrar</button>
						</div>

					</form>
				</div>

			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Refugios</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Key ID</th>
									<th>Dirección</th>
									<th>Capacidad de Personas</th>
									<th>Complejidad de Violencia</th>
									<th>Disponibilidad</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in collection">
									<td>@{{ item['.key'] }}</td>
									<td>@{{ item.direccion }}</td>
									<td>@{{ item.capacidad }}</td>
									<td>@{{ item.complejidad }}</td>
									<td>
										<ul class="pagination">
											<li v-for="day in item.disponibilidad">
												<span>@{{ day }}</span>
											</li>
										</ul>
									</td>
									<td>
										<button type="button" @click="removeRefuge(item['.key'])" class="btn btn-danger">Eliminar</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

    </template>

@stop

@section('app_footer')

	<script type="text/javascript">

		var firebaseConnection = new Firebase("https://refugio-d50d1.firebaseio.com/refuges");

		var Refuge = Vue.extend({

		    template: '#RefugeResource',

		    ready: function() {

		    },

		    data : function(){

		    	return {

					form : {
						direccion      : '',
						capacidad      : 0,
						complejidad    : '',
						disponibilidad : []
		    		}

		    	};

		    },

		    methods : {

		    	storeRefuge : function(){

		    		firebaseConnection.push(this.form);

		    	},
		    	editRefuge : function(item, event){

		    	},
		    	updateRefuge : function(){

		    	},
		    	removeRefuge : function(key){

		    		firebaseConnection.child(key).remove();
		    	}
		    },

		    firebase: {

			    collection: firebaseConnection.limitToLast(20)
			}

		});

		Vue.component('refuge', Refuge)

		new Vue({
			el: '#App'
		})

	</script>

@stop