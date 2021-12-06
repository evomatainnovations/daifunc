<!DOCTYPE html>
<html>
<head>
	<title>IRENE - User Registration</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<style type="text/css">

		body {
			background-size: cover;
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
		<div class="mdl-cell mdl-cell--4-col">
			
		</div>
		
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid" style="padding: 0px;margin: 0px;">
				<div class="mdl-cell mdl-cell--12-col" style="margin: 0px;">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Registration</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_name" name="c_name" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="c_name">Customer Name</label>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_company" name="c_company" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="c_company">Company Name</label>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_email" name="c_email" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="c_email">Email</label>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_phone" name="c_phone" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="c_phone">Phone</label>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_address" name="c_address" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="c_address">Address</label>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_gst" name="c_gst" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="c_gst">GST Number</label>
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<b>Select your profile picture</b>
								<input type="file" name="attach_file" class="upload">
							</div>
							<div class="mdl-cell mdl-cell--12-col">
								<b>Select your logo</b>
								<input type="file" name="attach_file" class="upload">
							</div>				
						</div>
					</div>
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
		</main>
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
           	var name = $('#c_name').val();
			var company = $('#c_company').val();
			var email = $('#c_email').val();
			var phone = $('#c_phone').val();
			var address = $('#c_address').val();
			var gst = $('#c_gst').val();

			$.post('<?php if (isset($status)) {echo base_url()."Account/invite_reg_user/".$e_oid."/".$status."/".$cust_id;} else{echo base_url()."Account/reg_user/";} ?>', {
				'name' : name, 'company' : company, 'email' : email, 'phone' : phone, 'address' : address, 'gst' : gst
			}, function(data, status, xhr) {
				if (data=="email") {
					var ert = {message: 'Kindly check email id.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				} else if(data=="phone"){
					var ert = {message: 'Kindly check phone Number.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				} else if(data=="email_phone"){
					var ert = {message: 'Kindly check email and phone Number.',timeout: 4000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				} else if(data=="Exception"){
					var ert = {message: 'email not send.',timeout: 4000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else{
					if($('.upload')[0].files[0]){
						 file_upload(data);
					} else {
						 send_mail(data);
					}
				}
			}, 'text');
        });
	});
	 var datat = new FormData();
	function file_upload(id) {

		for(var i=0; i < $('.upload').length; i++) {
		    if($('.upload')[i].files[0]) {
		        // console.log($('.upload')[i].files[0]);
    		    datat.append(i, $('.upload')[i].files[0]);
		    }
		}
		var url ="<?php if (isset($status)) {echo base_url()."Account/invite_reg_upload/".$e_oid."/".$status."/";} else{echo base_url()."Account/reg_upload/";}?>"+ id;
		
		flnm = "";
		$.ajax({
			url: url, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data){
				var ert = {message: 'Please Verify Your Email.',timeout: 4000,}; 
				snackbarContainer.MaterialSnackbar.showSnackbar(ert); 
			},
			error: function(x,s,e){
				var ert = {message: 'Please enter correct email file.',timeout: 4000,}; 
				snackbarContainer.MaterialSnackbar.showSnackbar(ert); 	
			} 
		});
		
	}
	function send_mail(id){
		var url ="<?php if (isset($status)) {echo base_url()."Account/invite_reg_email/".$e_oid."/".$status."/";} else{echo base_url()."Account/reg_upload/";}?>"+ id;
		flnm = "";
		$.ajax({
			url: url, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data){
				var ert = {message: 'Please Verify Your Email.',timeout: 4000,}; 
				snackbarContainer.MaterialSnackbar.showSnackbar(ert); 
			},
			error: function(x,s,e){
				var ert = {message: 'Please enter correct email send.',timeout: 4000,}; 
				snackbarContainer.MaterialSnackbar.showSnackbar(ert); 	
			} 
		});
	}

</script>
</html>