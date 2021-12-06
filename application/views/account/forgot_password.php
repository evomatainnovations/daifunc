<!DOCTYPE html>
<html>
<head>
	<title>IRENE - User Login</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.min.css'; ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.deep_orange-red.min.css" />
    <script src="<?php echo base_url().'assets/js/particle.js'; ?>"></script>
    <link rel="shortcut icon" type="image/x-icon" href="http://evomata.com/assets/images/logo-2587x2829.png" />

	<script src="<?php echo base_url().'assets/js/jquery-ui.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url().'assets/js/tag-it.js'; ?>" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery-ui.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.tagit.css'; ?>">

	<link href="<?php echo base_url().'assets/css/Opensans.css'; ?>" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<style type="text/css">

		body {
			/*background-image: url('<?php echo base_url().'assets/images/pattern.svg'; ?>');*/
			font-family: 'Open sans', sans-serif !important;
			background-size: cover;
			background-color: #000;
		}

		.mdl-card {
			text-align: center;
		}

		.mdl-card {
			width: 100% !important;
			color: #999;
			background-color: #fff;
		}

		.mdl-cell {
			/*border: 1px #000 solid;*/
		}

		.mdl-card__title {
			width: 100%!important;
			height: 175px;
			background: background: linear-gradient(0deg,#FF0000,#ff0000a7),-webkit-linear-gradient(4deg, #ff0000, #ff0000a7), url(<?php echo base_url().'assets/images/vector-abstract-geometric.jpg'; ?>);
			/*background-image: url('<?php echo base_url().'assets/images/'; ?>vector-abstract-geometric.jpg');*/
			background-size: cover;
			background-color:#ff0000;
			color:#fff;
		}

		.lower-button {
			right: 30px !important;
			bottom: 50px!important;
			position: fixed;
			z-index: 5;
			/*background-color: #330000;
			color: #fff;
			box-shadow: 2px 5px 10px #999999;*/
		}

		.mdl-button-upside {
			/*padding: 5px;*/
			margin-left: 10px!important;
			margin-right: 10px!important;
		}

		#myTags {
			margin: 0px;
		}

		a:link {
			text-decoration: none;
		}

		a:visited {
			text-decoration: none;
		}

		a:hover {
			text-decoration: underline;
		}

		a:active {
			text-decoration: underline;
		}
		
		#particle-canvas {
            width: 100%;
            height: 100vh;
            z-index: 0;
        }
    
        .mdl-layout {
            z-index: 20;
        }
        .loader {
			position: fixed;
		    border: 5px solid #f3f3f3;
			-webkit-animation: spin 2s linear infinite; /* Safari */
			animation: spin 1s linear infinite;
			border-top: 5px solid #555;
			border-radius: 50%;
			width: 50px;
			height: 50px;
			left: 47%;
			top: 50%;
			z-index: 1000000 !important;
		}
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		    0% { transform: rotate(0deg); }
		    100% { transform: rotate(360deg); }
		}
	</style>
</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
			<main class="mdl-layout__content">
				<div class="mdl-grid loader" style="display: none;">
					<div class="mdl-cell mdl-cell--4-col"></div>
				</div>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<div class="mdl-card mdl-shadow--16dp">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<img src="<?php echo base_url().'/assets/images/dai_func1.png'; ?>" style="width: 40%; padding: 50px;">
									<p style="font-size: 3em;color: #000;">DAI<b style="font-weight: 4em;">FUNC</b></p>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<h5 style="padding-right: 50px; padding-left: 50px;" >A platform that values your work.</h5>
								</div>
								<div class="mdl-cell mdl-cell--12-col" style="text-align: left;border-bottom: 1px solid #ccc; padding-left: 20px;">
									<h4>Forgot your password ?</h4>
									<h5 style="font-size: 0.8em;text-align: left;">Just tell us the email address you registerd .</h5>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-card__supporting-text">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="f_email" name="f_email" class="mdl-textfield__input">
											<label class="mdl-textfield__label" for="f_email">Email</label>
										</div>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col" style="padding-bottom: 10%;">
									<a href="<?php echo base_url().'Account/register/'?>">
									<button class="mdl-button mdl-button--raised mdl-button--color mdl-button--accent" style="width: 100%;" id="submit">Send</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>

	<div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar" style="z-index: 100000000000;">
		<div class="mdl-snackbar__text"></div>
		<button class="mdl-snackbar__action" type="button"></button>
	</div>
	

</body>
<div id="particle-canvas" style="opacity: 0.6;"></div>
<script>
	var snackbarContainer = document.querySelector('#demo-snackbar-example');
    $(document).ready(function() {

	    var canvasDiv = document.getElementById('particle-canvas');
        var options = {
            particleColor: '#999',
            // background: 'https://raw.githubusercontent.com/JulianLaval/canvas-particle-network/master/img/demo-bg.jpg',
            background: '#f2f2f2',
            interactive: true,
            speed: 'high',
            density: 'high'
        };
        var particleCanvas = new ParticleNetwork(canvasDiv, options);

        $('#submit').click(function(e){
        	e.preventDefault();
			var email = $('#f_email').val();
			$('.loader').show();
			$('#submit').prop('disabled', true);
			$.post('<?php echo base_url()."Account/forgot_mail/"; ?>', {
				'email' : email
			}, function(data, status, xhr) {
				$('.loader').hide();
				$('#submit').prop('disabled', false);

				if (data=="email") {
					var ert = {message: 'Email id incorrect. Please type correct email id',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else if (data == 'true') {
					var ert = {message: 'Verify email',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else{
					var ert = {message: 'Unknown Error.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}
			}, 'text');
        });
	});

</script>
</html>