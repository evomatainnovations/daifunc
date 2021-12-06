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
	</style>

</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<main class="mdl-layout__content">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-card mdl-shadow--16dp">
						<div class="mdl-grid">
							<div class="mdl-cell mdl-cell--12-col">
								<img src="<?php echo base_url().'assets/images/dai_func1.png'; ?>" style="width: 40%; padding: 50px;">
								<p style="font-size: 3em;color: #000;">DAI<b style="font-weight: 4em;">FUNC</b></p>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<h5 style="padding-right: 50px; padding-left: 50px;" >A platform that values your work.</h5>
							</div>
							<div class="mdl-cell mdl-cell--12-col" style="text-align: left;border-bottom: 1px solid #ccc; padding-left: 20px;">
								<h4>Login</h4>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" id="u_name" name="u_name" class="mdl-textfield__input">
									<label class="mdl-textfield__label" for="u_name">Username</label>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="password" id="u_pass" name="u_pass" class="mdl-textfield__input">
									<label class="mdl-textfield__label" for="u_pass">Password</label>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<button class="mdl-button mdl-js-button mdl-button-done mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;" id="submit">Login</button>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<button class="mdl-button mdl-js-button mdl-button-done mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;display: none;" id="logout">Please Logout From Other Device</button>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<a href="<?php echo base_url().'Account/register/'?>">
									<button class="mdl-button mdl-js-button mdl-button-done mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Create an account</button></a>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<a href="<?php echo base_url().'Account/forgot_password'?>">
									<button class="mdl-button mdl-js-button mdl-button-done mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Forgot Password ?</button></a>
							</div>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col"></div>
			</div>
		</main>
	</div>
	<div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar">
		<div class="mdl-snackbar__text"></div>
		<button class="mdl-snackbar__action" type="button"></button>
	</div>
	

</body>
<div id="particle-canvas" style="opacity: 0.6;"></div>
<script>
	var sess_id = 0;
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
	    	
		$('#submit').click(function(e) {
			e.preventDefault();
			
			var uname = $('#u_name').val();
			var upass = $('#u_pass').val();
			$('#submit').prop('disabled', true);
			var snackbarContainer = document.querySelector('#demo-snackbar-example');

			if (localStorage.getItem("myKey") == null) {
				var key = null;
			}else{
				var key = localStorage['myKey'];
			}
			<?php
				if ($mode == "portal") {
					echo "$.post('".base_url()."Portal/verify/', {'uname' : uname, 'upass' : upass}, function(data, status, xhr) { console.log(data);$('#submit').prop('disabled', false); if(data == 'true') { window.location = '".base_url()."Portal'; } else { var ert = {message: 'Please check your Username and Password.',timeout: 2000,}; snackbarContainer.MaterialSnackbar.showSnackbar(ert); } }, 'text');";
				} elseif ($mode=="user") {
					echo "$.post('".base_url()."Account/verify', {'uname' : uname, 'upass' : upass, 'key' : key }, function(data, status, xhr) { console.log(data);$('#submit').prop('disabled', false); var status = data.substr(0,1);var id = data.substr(1,data.length);if(status == 't' ) { window.location = '".base_url()."Home/index/'+id; } else if(data == 'false') { var ert = {message: 'Please check your Username and Password.',timeout: 2000,}; snackbarContainer.MaterialSnackbar.showSnackbar(ert); } else if(data == 'unknown') { var ert = {message: 'Unknown error occured.',timeout: 2000,}; snackbarContainer.MaterialSnackbar.showSnackbar(ert); } else if(status == 's') { logout_session(id); } else{ window.location = '".base_url()."Account/reset_password/' + data; } }, 'text');";
				}
			?>
		});

		$('#logout').click(function (e) {
			e.preventDefault();
			var uname = $('#u_name').val();
			$.post('<?php echo base_url()."Account/logout_session/";?>', 
				{'uname' : uname},
				function(data, status, xhr) { 
					window.location = "<?php echo base_url().'account/login';?>";
				}, 'text');
		});

		function logout_session(id){
			sess_id = id;
			$('#logout').css('display','block');
		}
	})
</script>
</html>