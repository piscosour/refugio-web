<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>#NiUnaMenos</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyA91Ls4vWMs7nr6t-Bp8B-zrQwao0MC9YY&sensor=true"></script>
		<link rel="stylesheet" href="./css/bootstrap.css">
		<style type="text/css">
		</style>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body id="App">

	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

	<div class="container-fluid">
		<div class="login">
			<refuge></refuge>
		</div>
	</div>

	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

	<template id="FormLogin">

		<section>

			<div class="panel panel-default panel-login" v-show="settings.form">
				<div class="panel-heading">
					<h3 class="panel-title">Registro</h3>
				</div>
				<div class="panel-body">
					<section>
						<form action="#" method="POST" role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-3 control-label">Correo</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="Email" required="required">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Contraseña</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="Contraseña" required="required">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Confirmar contraseña</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="Confirmar contraseña" required="required">
								</div>
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn-primary">Registro</button>
							</div>
						</form>

						<div class="btn-trigger">
							<button type="button" class="btn btn-danger btn-lg" @click="needHelp">
								<i class="fa fa-bullhorn"></i>
								Emergencia
							</button>
						</div>
					</section>
				</div>
			</div>

			<div class="panel panel-default panel-map" v-bind:class="[settings.form ? 'visible_c' : 'hidden_c']">
				<div class="panel-heading">
					<h3 class="panel-title">Refugio</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<div id="Map"></div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Ruta</h3>
								</div>
								<div class="panel-body">
									<div id="instructions"></div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Refugio</h3>
								</div>
								<div class="panel-body">
									<p><strong>Anfitrión:</strong> @{{ refuge.nombre }} @{{ refuge.apellido }}</p>
									<p><strong>Correo:</strong> @{{ refuge.correo }} </p>
									<p><strong>Refugio:</strong> @{{ refuge.direccion }} </p>
									<p><strong>Capacidad:</strong> @{{ refuge.capacidad }} </p>
									<p>
										<strong>Disponibilidad:</strong><br>
										<ul class="pagination">
											<li v-for="day in refuge.disponibilidad">
												<span>@{{ day }}</span>
											</li>
										</ul>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>

    </template>


	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
	<script src="https://cdn.firebase.com/js/client/2.4.2/firebase.js"></script>
	<script src="https://cdn.jsdelivr.net/vuefire/1.0.0/vuefire.min.js"></script>
	<script src="./js/maps.js"></script>

	<script type="text/javascript">

		var firebaseConnection = new Firebase("https://refugio-d50d1.firebaseio.com/refuges");

		var map;

		var Refuge = Vue.extend({

		    template: '#FormLogin',

		    ready: function() {

		    	map = new GMaps({
	                div : '#Map',
	                lat : -12.0971829,
	                lng : -77.03258499999998,
	                zoom: 13
	            });

		    },

		    data : function(){

		    	return {

					form : {
						latitud  : '',
						longitud : '',
					},
					settings:{
						form : true
					},

					refuge : {
						nombre         : '',
						apellido       : '',
						correo         : '',
						direccion      : '',
						capacidad      : 0,
						complejidad    : 0,
						disponibilidad : []
					}

		    	};

		    },

		    methods : {

		    	needHelp : function(){

		    		var self = this;

		    		if (this.collection.length > 0) {

		    			var user = this.collection[0];

		    			this.$set('refuge', this.collection[0]);

		    			GMaps.geolocate({
					        success: function(position){

					          	map.setCenter(position.coords.latitude, position.coords.longitude);

					          	map.addMarker({
									lat : position.coords.latitude,
					                lng : position.coords.longitude
								});

								self.form.latitud  = position.coords.latitude;
								self.form.longitud = position.coords.longitude;

								self.settings.form = false;

								map.addMarker({
									lat : user.latitud,
					                lng : user.longitud,
					                color: 'blue'
								});

								map.travelRoute({
								    origin: [position.coords.latitude, position.coords.longitude],
								    destination: [user.latitud, user.longitud],
								    travelMode: 'driving',
								    step: function(e) {
								        $('#instructions').append('<li>' + e.instructions + '</li>');
								        $('#instructions li:eq(' + e.step_number + ')').delay(450 * e.step_number).fadeIn(200, function() {
								            map.setCenter(e.end_location.lat(), e.end_location.lng());
								            map.drawPolyline({
								                path: e.path,
								                strokeColor: '#131540',
								                strokeOpacity: 0.6,
								                strokeWeight: 6
								            });
								        });
								    }
								});

					        },
					        error: function(error){
					          alert('Geolocalización Fallida: '+error.message);
					        },
					        not_supported: function(){
					          alert("El Navegador no soporta la Geolocalización");
					        }
					   	});

		    		}
		    		else{
		    			alert("No hay refugios disponibles");
		    		}

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

</body>
</html>