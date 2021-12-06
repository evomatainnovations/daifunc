<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?php echo base_url().'assets/images/daifunc_logo.png'; ?>" type="image/x-icon">
<title><?php if (isset($c_details)) { echo $c_details[0]->iextetm_company_name; } ?> </title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-light_green.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-light_green.min.css" />
<style type="text/css">
	html, body, h1, h2, h3, h4, h5, h6, a {
		font-family: 'Muli', sans-serif !important;
	}

	.problem_button {
		margin: 30px;
	    padding: 49px;
	    font-size: 2em;
	    outline: none;
	    line-height: 1.4em;
	    width: 300px;
		height: 250px;
		text-align: center;
		cursor: pointer;
		border-radius: 50%;
		background: #f74d4d;
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f74d4d), color-stop(100%, #f86569));
		background-image: -moz-gradient(linear, left top, left bottom, color-stop(0%, #f74d4d), color-stop(100%, #f86569));
		box-shadow: 0 15px #e24f4f;
		border: 0px;
	}

	.problem_button:active {
		box-shadow: 0 0 #e24f4f;
		-webkit-transform: translate(0px, 15px);
		-moz-transform: translate(0px, 15px);
		-ms-transform: translate(0px, 15px);
		-o-transform: translate(0px, 15px);
		-webkit-transition: 0.1s all ease-out;
		-moz-transition: 0.1s all ease-out;
		-ms-transition: 0.1s all ease-out;
		-o-transition: 0.1s all ease-out;
		transition: 0.1s all ease-out;
	}
	.pic_button {
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc;
		margin: 20px;
		position: relative;
		overflow: hidden;
	}
	.pic_button input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
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
<div class="mdl-grid loader" style="display: none;">
	<div class="mdl-cell mdl-cell--4-col"></div>
</div>
<div id="login_page" class="mdl-grid" style="text-align: center;display: ;">
	<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
		<?php
			$path = '';
			if (isset($c_details)) {
				$path = base_url()."assets/data/portal/mobile_users/".$c_details[0]->iextetm_logo;
			}
			echo '<img src="'.$path.'" style="width: 50%;">';
			echo '<h4><b>'.$c_details[0]->iextetm_company_name.'</b></h4>';
		?>
		<h5>Login</h5>
		<hr>
	</div>
	<div class="mdl-cell mdl-cell--12-col" style="padding-top: 0px;">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="u_name"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
			<label class="mdl-textfield__label" for="u_name">Email Id</label>
			<span class="mdl-textfield__error">Please enter a valid email!</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="password" id="u_pass">
			<label class="mdl-textfield__label" for="u_pass">Password</label>
		</div>

		<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored access_button" style="width: 100%;" id="submit">Login</button>
	</div>
	<div class="mdl-cell mdl-cell--12-col">
		<button class="mdl-button mdl-js-button access_button" id="forgot_toggle" style="width: 100%;">Forgot Password</button>
	</div>
	<div class="mdl-cell mdl-cell--12-col">
		<button class="mdl-button mdl-js-button access_button" id="register_toggle" style="width: 100%;">Create Account</button>
	</div>
</div>
<div id="signup_page" class="mdl-grid" style="text-align: center;display: none;">
	<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
		<?php
			$path = '';
			if (isset($c_details)) {
				$path = base_url()."assets/data/portal/mobile_users/".$c_details[0]->iextetm_logo;
			}
			echo '<img src="'.$path.'" style="width: 50%;">';
			echo '<h4><b>'.$c_details[0]->iextetm_company_name.'</b></h4>';
		?>
		<h5>Create Account</h5>
		<hr>
	</div>
	<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="c_name">
			<label class="mdl-textfield__label" for="c_name">Your Name</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="c_company">
			<label class="mdl-textfield__label" for="c_company">Company</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="c_email">
			<label class="mdl-textfield__label" for="c_email">Email</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="c_phone">
			<label class="mdl-textfield__label" for="c_phone">Phone</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="c_address">
			<label class="mdl-textfield__label" for="c_address">Address</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="c_gst">
			<label class="mdl-textfield__label" for="c_gst">GST Number</label>
		</div>
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored access_button mdl-js-ripple-effect" id="reg_submit" style="width: 100%;">Register</button>
		<button class="mdl-button mdl-js-button access_button" id="login_toggle" style="width: 100%;">Login</button>
	</div>
</div>
<div id="forgot_page" class="mdl-grid" style="text-align: center;display: none;">
	<div class="mdl-cell mdl-cell--12-col">
		<?php
			$path = '';
			if (isset($c_details)) {
				$path = base_url()."assets/data/portal/mobile_users/".$c_details[0]->iextetm_logo;
			}
			echo '<img src="'.$path.'" style="width: 50%;">';
			echo '<h4><b>'.$c_details[0]->iextetm_company_name.'</b></h4>';
		?>
		<h5>Forgot Password</h5>
		<hr>
	</div>
	<div class="mdl-cell--12-col">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="f_email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
			<label class="mdl-textfield__label" for="f_email">Email Id</label>
			<span class="mdl-textfield__error">Please enter a valid email!</span>
		</div>
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored access_button" id="forgot_submit" style="width: 100%;">Send Request</button>

		<button class="mdl-button mdl-js-button access_button" id="f_login_toggle" style="width: 100%;">Login</button>
	</div>
</div>
<div id="otp_page" class="mdl-grid" style="text-align: center;display: none;">
	<div class="mdl-cell mdl-cell--12-col">
		<?php
			$path = '';
			if (isset($c_details)) {
				$path = base_url()."assets/data/portal/mobile_users/".$c_details[0]->iextetm_logo;
			}
			echo '<img src="'.$path.'" style="width: 50%;">';
			echo '<h4><b>'.$c_details[0]->iextetm_company_name.'</b></h4>';
		?>
		<h5>Verify with otp</h5>
		<hr>
	</div>
	<div class="mdl-cell--12-col">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="password" id="pwd">
			<label class="mdl-textfield__label" for="pwd">Enter Password</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="password" id="c_pwd">
			<label class="mdl-textfield__label" for="c_pwd">Enter Confirm Password</label>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="otp">
			<label class="mdl-textfield__label" for="otp">Enter OTP</label>
		</div>
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored access_button" id="verify_otp" style="width: 100%;">Verify</button>
		<div class="test_timer"></div>
		<button class="mdl-button mdl-js-button access_button" id="resend_otp" style="width: 100%;display: none;">Resend OTP</button>
	</div>
</div>
<div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar">
	<div class="mdl-snackbar__text"></div>
	<button class="mdl-snackbar__action" type="button"></button>
</div>
</body>
<script type="text/javascript">
	var snackbarContainer = document.querySelector('#demo-snackbar-example');
	var otp_arr = [];
	var forgot_pwd_flg = 'false';
	$(document).ready(function() {
		if (localStorage.getItem("myKey") == null || localStorage.getItem("myKey") == '' || localStorage.getItem("myKey") == 'null' ) {
			localStorage["myKey"] = null;
		}else{
			$.post('<?php echo base_url()."Mobile_app/check_mobile_sess/";?>'+localStorage["myKey"],
	 		function(data, status, xhr) {
     			if (data == 'true') {
         			window.location = "<?php echo base_url().'Mobile_app/cosmos_home/';?>"+localStorage["myKey"];
		       	}else{
		       		localStorage["myKey"] = null;
		       	}
	       	});
		}

		$('#login_toggle').click(function(e) {
			e.preventDefault();
			$('#signup_page').css('display','none');
			$('.loader').css('display','block');
			setTimeout(function() {
				$('.loader').css('display','none');
				$('#login_page').css('display','block');
			}, 1000);
		});

		$('#forgot_toggle').click(function(e) {
			e.preventDefault();
			$('#login_page').css('display','none');
			$('.loader').css('display','block');
			setTimeout(function() {
				$('.loader').css('display','none');
				$('#forgot_page').css('display','block');
			}, 1000);
		});

		$('#register_toggle').click(function(e) {
			e.preventDefault();
			$('#login_page').css('display','none');
			$('.loader').css('display','block');
			setTimeout(function() {
				$('.loader').css('display','none');
				$('#signup_page').css('display','block');
			}, 1000);
		});

		$('#f_login_toggle').click(function(e) {
			e.preventDefault();
			$('#forgot_page').css('display','none');
			$('.loader').css('display','block');
			setTimeout(function() {
				$('.loader').css('display','none');
				$('#login_page').css('display','block');
			}, 1000);
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			var uname = $('#u_name').val();
			var upass = $('#u_pass').val();
			login_user(uname,upass);
		});

		function login_user(uname,upass) {
			$('#submit').prop('disabled', true);
			if (localStorage.getItem("myKey") == null) {
				var key = null;
			}else{
				var key = localStorage['myKey'];
			}
			var path = '<?php echo base_url()."Mobile_app/verify/" ?>';
			$.post(path,{
				'uname' : uname, 'upass' : upass, 'key' : key
			}, function(data, status, xhr) {
				$('#submit').prop('disabled', false);
				var status = data.substr(0,1);
				var id = data.substr(1,data.length);
				if(status == 't' ) {
					localStorage['myKey'] = id ;
					window.location = '<?php echo base_url(); ?>'+'Mobile_app/cosmos_home/'+id;
				} else if(data == 'false') { 
					var ert = {message: 'Please check your Username and Password.',timeout: 2000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert); 
				} else if(data == 'block') {
					var ert = {message: 'Please conatct owner for login !',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else{
					var ert = {message: 'You enter wrong User_id or Password !',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}
			}, 'text');
		}

		$('#logout').click(function (e) {
			e.preventDefault();
			var uname = $('#u_name').val();
			$.post('<?php echo base_url()."Account/logout_session/";?>', 
			{'uname' : uname},
			function(data, status, xhr) {
				window.location = "<?php echo base_url().'account/login';?>";
			}, 'text');
		});

		$('#reg_submit').click(function(e){
        	e.preventDefault();
			var email = $('#c_email').val();
			var phone = $('#c_phone').val();
			$('.loader').show();
			$.post('<?php echo base_url()."Mobile_app/send_reg_user_otp/".$oid; ?>', {
				'email' : email , 'phone' : phone
			}, function(data, status, xhr) {
				$('.loader').hide();
				if (data=="nn") {
					var ert = {message: 'Kindly check email id.',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				} else if(data=="nnn"){
					var ert = {message: 'Kindly check phone Number.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				} else if(data=="Exception"){
					var ert = {message: 'Plz try again.',timeout: 4000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else{
					otp_arr.push(data);
					$('#signup_page').css('display','none');
					$('.loader').css('display','none');
					$('#otp_page').css('display','block');

					var count = 60, timer = setInterval(function() {
					    $(".test_timer").html('OTP send in '+count--+' sec.');
					    if(count == 0) clearInterval(timer);
					    if (count == 0) {
					    	$(".test_timer").css('display','none');
					    	$('#resend_otp').css('display','block');
					    }
					}, 1000);
					var ert = {message: 'Kindly check email account.',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}
			}, 'text');
       	});

		$('#resend_otp').click(function(e){
        	e.preventDefault();
			var email = $('#c_email').val();
			$.post('<?php echo base_url()."Mobile_app/send_reg_user_otp/".$oid; ?>', {
				'email' : email
			}, function(data, status, xhr) {
				otp_arr.push(data);
				var ert = {message: 'Kindly check email id.',timeout: 2000,};
				snackbarContainer.MaterialSnackbar.showSnackbar(ert);
			}, 'text');
       	});

		$('#verify_otp').click(function(e){
        	e.preventDefault();
        	if (forgot_pwd_flg == 'true') {
        		var path = '<?php echo base_url()."Mobile_app/update_reg_user/".$oid."/".$mob_id; ?>';
        		var email = $('#f_email').val();
        	}else{
        		var path = '<?php echo base_url()."Mobile_app/save_reg_user/".$oid."/".$mob_id; ?>'
        		var email = $('#c_email').val();
        	}
        	var otp_flg = '';
        	var pwd_flg = '';
        	for (var i = 0; i < otp_arr.length; i++) {
        		if(otp_arr[i] == $('#otp').val() ){
        			otp_flg = 'otp';
        		}
        	}
        	if ($('#pwd').val() == $('#c_pwd').val()) {
        		pwd_flg = 'true';
        	}
        	if (otp_flg == 'otp' && pwd_flg == 'true') {
        		var name = $('#c_name').val();
				var company = $('#c_company').val();
				var phone = $('#c_phone').val();
				var address = $('#c_address').val();
				var gst = $('#c_gst').val();
				var pwd = $('#pwd').val();
				$('.loader').show();
				$.post(path, {
					'email' : email , 'name' : name , 'company' : company , 'phone' : phone , 'address' : address , 'gst' : gst , 'pwd' :pwd
				}, function(data, status, xhr) {
					$('#forgot_page').css('display','none');
					$('#signup_page').css('display','none');
					$('#otp_page').css('display','none');
					$('#login_page').css('display','block');
					$('.loader').hide();
				}, 'text');
        	}else{
        		if (otp_flg == '') {
        			var ert = {message: 'Kindly check OTP.',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
        		}else{
        			var ert = {message: 'Password And Confirm Password Not Match !.',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
        		}
        	}
       	});

	    $('#forgot_submit').click(function(e){
	       	e.preventDefault();
	       	$('.loader').show();
			var email = $('#f_email').val();
			$.post('<?php echo base_url()."Mobile_app/send_reg_user_otp/".$oid; ?>', {
				'email' : email
			}, function(data, status, xhr) {
				$('.loader').hide();
				if (data=="nn") {
					var ert = {message: 'Email id incorrect. Please type correct email id',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else{
					otp_arr = [];
					otp_arr.push(data);
					forgot_pwd_flg = 'true';
					$('#forgot_page').css('display','none');
					$('.loader').css('display','none');
					$('#otp_page').css('display','block');
					var ert = {message: 'Kindly check email account.',timeout: 2000,};
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}
			}, 'text');
	    });

	});
</script>
</html>