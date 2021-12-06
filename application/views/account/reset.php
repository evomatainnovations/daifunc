<!DOCTYPE html>
<html>
<head>
	<title>Daifunc | Reset Password</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.min.css'; ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.red-deep_orange.min.css" />


	<script src="<?php echo base_url().'assets/js/jquery-ui.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url().'assets/js/tag-it.js'; ?>" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery-ui.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.tagit.css'; ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<style type="text/css">

		/*body {
			background-image: url('<?php echo base_url().'assets/images/pattern_reset.svg'; ?>');
		}*/
		html, body, h1, h2, h3, h4, h5, h6, a {
			font-family: 'Muli', sans-serif !important;
		}

		html, body{
			background-color: #ccc;
		}

		.mdl-card {
			text-align: center;
		}

		.mdl-card {
			width: 100% !important;
			background-color: #fff;
		}

		.mdl-cell {
			/*border: 1px #000 solid;*/
		}

		.mdl-card__title {
			width: 100%!important;
			height: auto;
 			/*background-image: url('<?php //echo base_url().'assets/images/pattern.svg'; ?>');*/
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
	</style>

</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<main class="mdl-layout__content">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet"></div>
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">
					<div class="mdl-card mdl-shadow--4dp" style="text-align: center;">
						<div style="padding: 10%;">
							<h4><img src="<?php echo base_url().'assets/images/daifunc_logo.png'; ?>" style="width: 50%;"><div>DAI<b>FUNC</b></div>	</h4>
						</div>
						<h4 style="border-bottom: 1px solid #ccc;">Reset Password</h4>
						<div style="padding: 10%;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="password" id="u_pass" name="u_pass" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="u_pass">Password</label>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="password" id="u_confirm_pass" name="u_confirm_pass" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="u_confirm_pass">Confirm Password</label>
							</div>
							<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored access_button mdl-js-ripple-effect" style="width: 100%;" id="submit">Update</button>
						</div>
					</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet"></div>
			</div>
		</main>
	</div>

	<div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar">
		<div class="mdl-snackbar__text"></div>
		<button class="mdl-snackbar__action" type="button"></button>
	</div>
</body>
<script>
	$(document).ready(function() {
		$('#submit').click(function(e) {
			e.preventDefault();

			var upass = $('#u_pass').val();
			var ucpass = $('#u_confirm_pass').val();

			if (upass==ucpass) {
				$.post('<?php if (isset($status)) { echo base_url()."Account/invite_reset_update/".$uid."/".$e_oid."/".$status; } else { echo base_url()."Account/reset_update/".$uid."/".$code; } ?>', 
					{'upass' : upass},
					function(data, status, xhr)
					{ 	console.log(data); 
					 	if(data == 'true') 
					 	{ window.location = '<?php echo base_url()."Account"?>'; } 
					}, 'text');
				
			} else {
				var snackbarContainer = document.querySelector('#demo-snackbar-example');
				var ert = { message: 'Both Passwords must match.',timeout: 2000,}; snackbarContainer.MaterialSnackbar.showSnackbar(ert);
			
			}


		});
	})
</script>
</html>