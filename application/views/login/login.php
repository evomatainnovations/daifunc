<!DOCTYPE html>
<html lang="en">
<head>
	<title>Carpool - Login/ Signup</title>
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	
</head>
<body>
	<div id="success_done" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div align="center" class="modal-body" style="background-color:#ffcc00;color:white;">
				<h1>Thank you for showing interest,<b class="u_name"></b>. :)</h1>
				<h2>We really appriciate</h2>
				<br>
				<h1>We will get back to you.</h1>
		<!-- 		<div class="row">
					<div class="col-sm-12"> -->
						<a href="https://www.facebook.com/Ascend-Educators-927782920681551/">
							<button class="btn btn-lg">
								Like us on Facebook :)
							</button>
						</a>
					<!-- </div>
				</div> -->
		
			</div>
		</div>
	</div>
	<div id="failure" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div align="center" class="modal-body" style="background-color:#ff0000;color:white;">
				<h1>Well <b class="u_name"></b>, something went wrong. Can you try again?</h1>
				<h2>Sorry about that</h2>
				<br>
				
		<!-- 		<div class="row">
					<div class="col-sm-12"> -->
						<a href="https://www.facebook.com/Ascend-Educators-927782920681551/">
							<button class="btn btn-lg">
								Like us on Facebook :)
							</button>
						</a>
					<!-- </div>
				</div> -->
		
			</div>
		</div>
	</div>
	<div id="failure_form" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div align="center" class="modal-body" style="background-color:#ff0000;color:white;">
				<h1>Well <b class="u_name"></b>, you seem to have missed out on a few things.</h1>
				<h2>Sorry about that, but then thats needed.</h2>
				<br>
				
				<h2 align="left"><ul class="form_need"></ul></h2>
		
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6 well-lg">
					<ul class="nav nav-tabs nav-justifie">
						<li class="active"><a data-toggle="tab" href="#signin">Sign In</a></li>
						<li><a data-toggle="tab" href="#signup"> Sign Up</a></li>
					</ul>
					<div class="tab-content">
						<div id="signin" class="tab-pane fade in active">
							<div class="row">
								<div class="col-sm-12">
								<h3>Sign In</h3>
								</div>
							</div>
							<div class="row">
								<form method="post" id="signin_form" role="form" method="post" action="<?php echo base_url().'index.php/Login/check_login'; ?>";">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Email</label>
											<input class="form-control text-theme" type="text" id="si_email" name="si_email" placeholder="Enter your email">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input class="form-control text-theme" id="si_password" type="password" name="si_password" placeholder="Enter your password">
										</div>
										<div>
											<input id="submit" type="submit" class="btn btn-block text-theme-inverse" value="Sign In">
										</div>
									</div>
								</form>
							</div>
						</div>
						<div id="signup" class="tab-pane fade">
							<div class="row">
								<div class="col-sm-12">
								<h3>Sign Up</h3>
								</div>
							</div>
							<div class="row">
								<form method="post" id="signup_form" role="form" action="<?php echo base_url().'index.php/Login/create_login'; ?>">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Name</label>
											<input class="form-control text-theme" type="text" id="su_name" name="su_name" placeholder="Your Full Name">
										</div>
										<div class="form-group">
											<label>Address</label>
											<textarea class="form-control text-theme" type="text" id="su_address" name="su_address" placeholder="Your Address"></textarea>
										</div>
										<div class="form-group">
											<label>Phone</label>
											<input class="form-control text-theme" type="text" id="su_phone" name="su_phone" placeholder="Your phone number">
										</div>
										<div class="form-group">
											<label>Email</label>
											<input class="form-control text-theme" type="text" id="su_email" name="su_email" placeholder="Your Email Id">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input class="form-control text-theme" id="su_password" type="password" name="su_password" placeholder="Your password">
										</div>
										<div>
											<input id="submit" type="submit" class="btn btn-block text-theme-inverse" value="Sign Up">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-3"></div>

			</div>
		</div>
	</div>
</body>
</html>