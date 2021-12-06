<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo base_url().'assets/images/daifunc_logo.png'; ?>" type="image/x-icon">

	<title>DAIFUNC - Intelligent Management Solution by Evomata </title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.red-deep_orange.min.css" />
	<style type="text/css">
		html, body, h1, h2, h3, h4, h5, h6, a {
			font-family: 'Muli', sans-serif !important;
		}

		.img-box {
			box-shadow: 0px 3px 10px #111; border-radius: 10px;
		}

		.mdl-layout__header {
			background-color: #fff;
			color: #000;
		}

		.mdl-layout__drawer-button {
			color: #000 !important;
		}

		.full_height {
			height: 100vh;
		}

		.full_height_150 {
			height: 150vh;
		}

		.full_width {
			width: 100%;
		}

		.title_image {
			background: linear-gradient(10deg,rgba(255, 255, 255, 1),rgba(255, 255, 255, 0.5)), url(31216.jpg);
			background-repeat: no-repeat;
			background-size: cover;
			/*background-position: center;*/
		}

		.title_card {
			color: #000;
			padding-top: 40vh;
			text-align: center;
		}

		.title_card_small_text {
			font-size: 2em;
		}

		.title_card_large_text {
			font-weight: bold;
			font-size: 5em;
			line-height: 1.3em;
		}

		.focus_point {
			text-align: center;
			border-radius: 550px;
			box-shadow: 0px 2px 50px #666;
			height: 500px;
			width: 500px;
			padding: 90px;
			background-color: #F44336;
			color: #fff;
			line-height: 1.2em;
			margin: auto;
		}

		.focus_point > h3 {
			font-size: 2em;
		}

		.focus_point > h2 {
			font-weight: bold;
		}

		.focus_question {
			text-align: center;
			/*border-radius: 20px;*/
			height: auto;
			width: 100%;
			padding: 40px;
			background-color: #F44336;
			color: #fff;
			line-height: 1.2em;
			margin: auto;
		}

		.focus_point > h3 {
			font-size: 2em;
		}

		.focus_point > h2 {
			font-weight: bold;
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

		@media only screen and (max-width: 450px) {
			.title_card {
				padding-top: 20vh;
				text-align: left;
			}

			.title_card_large_text {
				font-size: 3.7em;
			}

			.focus_point {
				border-radius: 10px;
				height: auto;
				padding: 25px;
				text-align: left;
			}

			.focus_point > h3 {
				font-size: 1.6em;
			}

			.focus_point > h2 {
				font-size: 3em;
				font-weight: bold;
			}

			.problem_button {
				margin: 0px;
			}

			.text-justify {
				padding: 0px !important;
			}

			.text-justify > h4 {
				padding: 24px;
				font-size: 1.4em;
			}

			.hdr {
				width: 100%;
			}

			.hdr_img {
				width: 100% !important;
			}

			.df_header {
				padding: 20% 5% 20% 5% !important;
			}
		}

		@media only screen and (max-width: 800px) {
			.hdr {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 1024px) and (min-width: 800px) and (min-height: 800px) {
			.hdr_img {
				width: 100% !important;
			}

			.mn_grid {
				height: 60vh !important;
			}
		}

		@media only screen and (min-width: 550px) and (max-width: 823px) and (max-height: 420px) {
			.hdr {
				width: 100% !important;
			}

			.mn_grid {
				height: 250vh !important;
			}
		}

		



		@media only screen and (max-width: 320px) {
			.title_card_large_text {
				font-size: 3em;
			}

			.focus_point {
				width: 100%;
			}

			.focus_point > h2 {
				font-size: 2.5em;
			}

			.text-justify {
				padding: 0px !important;
			}

			.text-justify > h4 {
				padding: 24px;
				font-size: 1.4em;
			}

			.hdr {
				width: 100%;
			}

			.hdr_img {
				width: 100% !important;
			}

			.mn_grid {
				height: 130vh !important;
			}

			.df_header {
				padding: 20% 0px 20% 0px !important;
			}
		}

		.benefits {
			height: 300px;
		}


		.modal-dialog {
	        z-index: 10000000 !important;
	    }

	    .modal-content{
	        border-radius: 0px;
	        box-shadow: 1px 5px 77px #000;
	    }

	    .modal-header{
	        padding: 30px;
	        padding-bottom: 0px;
	    }

	    .modal{
	        padding-left: 0px;
	    }
		

		.access_button {
			width: 50%;
		}

		.pic_button {
			/*height: 100px;*/
			border-radius: 10px;
			box-shadow: 0px 4px 10px #ccc;
			margin: 20px;
			position: relative;
			overflow: hidden;
			/*margin: 10px;*/
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

		a:hover {
			text-decoration: none;
		}

		a:focus {
			text-decoration: none;
		}

		.text-justify {
			text-align: justify;
			padding: 10px;
		}

		.text-justify > h4 {
			padding: 30px;
			box-shadow: 0px 5px 20px #aaa;
			border-radius: 10px;
		}

		.main_features {
			border-radius: 5px; box-shadow: 0px 3px 10px #aaa;padding: 10px;
		}

		.main_features > h4 {
			text-align: center;
			color: #f44336;
		}

		.main_features > ul {
			padding-left: 20px;
		}

	</style>
</head>
<body>

	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
	<header class="mdl-layout__header">
		<div class="mdl-layout__header-row">
			<span class="mdl-layout-title" style="display: contents;"><img src="<?php echo base_url().'assets/images/daifunc_logo.png'; ?>" style="max-width: 30px;max-height: 30px;padding-right: 10px"> <h4>DAI<b>FUNC</b></h4></span>
			<div class="mdl-layout-spacer"></div>
			<nav class="mdl-navigation mdl-layout--large-screen-onl">
			</nav>
		</div>
	</header>
	<div class="mdl-layout__drawer">
		<span class="mdl-layout-title" style="padding: 40px 40px 0px 40px; text-align: center;"><img src="<?php echo base_url().'assets/images/daifunc_logo.png'; ?>" style="max-width: 80%;"><h3>DAI<b>FUNC</b></h3><hr style="width: 100%;"></span>
		<nav class="mdl-navigation" style="text-align: center;">
			<b>Contact Us:</b>
			<a class="mdl-navigation__link" href="tel:+917977061527"><i class="material-icons">phone</i> +917977061527(Whatsapp available)</a>
			<a class="mdl-navigation__link" href="mailto:hellodaifunc@evomata.com?Subject=DAIFUNC%20enquiry"><i class="material-icons">mail</i> hellodaifunc@evomata.com</a>
			<hr style="width: 100%;">
			<a href="http://www.evomata.com" target="_blank"> &copy; Evomata Innovations (OPC) Pvt. Ltd.</a>

		</nav>
	</div>
	<main class="mdl-layout__content">
		<div class="page-content">
			<div class="mdl-grid mn_grid" style="padding: 0px;height: 100vh;color: #fff; font-weight: bold;">
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet hdr" style="background-color: #ff0000; color: #000; margin: 0px; padding: 20px;padding-top: 30%;">
					<h2 style="color: #fff; font-weight: bold;">Be a business leader, not the business itself!</h2>
				</div>
				<div class="mdl-cell mdl-cell--8-col" style="padding-top: 10%;text-align: center;">
					<img src="<?php echo base_url().'assets/images/people_work.svg'; ?>" class="hdr_img" style="width: 80%;">
				</div>
			</div>
			<div class="mdl-grid" style="text-align: center;background-color: #333; color: #fff; padding: 10%;" id="why_built">
				<div class="mdl-cell mdl-cell--12-col" style="margin: auto;">
					<h4>DAIFUNC is an next level ERP software that is designed to respect the efforts you put in managing a business.</h4>
					<br>
					<h4>You achieve complete convenience, scale & time-saver in managing everyday business tasks, enabling you to dream big, plan and achieve them.</h4>
				</div>
			</div>
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--2-col"></div>
				<div class="mdl-cell mdl-cell--8-col" style="text-align: center; box-shadow: 0px 3px 10px #aaa; border-radius: 10px; padding: 10px;">
					<h4>Learn how DAIFUNC supports your Vision, Strategies & People that are part of your business.</h4>
					<button class="mdl-button mdl-js-button mdl-button--colored" data-toggle="modal" data-target="#signup_page">Know more</button>
				</div>
				<div class="mdl-cell mdl-cell--2-col"></div>
			</div>
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<h1 style="padding: 20%;" class="df_header">What does DAI<b>FUNC</b> do for you?</h1>
					<img src="<?php echo base_url().'assets/images/daifunc_function.svg'; ?>" style="width: 100%;">
				</div>
				<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-phone mdl-cell--4-col-tablet">
					<div class="main_features">
						<h4>Convenience</h4>
						<br>
						<ul>
							<li>Make Searching more Relative</li>
							<li>Work anywhere, on any device with anyone.</li>
						</ul>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-phone mdl-cell--4-col-tablet">
					<div class="main_features">
						<h4>Time-Saver</h4>
						<br>
						<ul>
							<li>Simple design reducing the need for tutorials & support.</li>
							<li>Module synchronization using A.I. making work more automated.</li>
						</ul>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-phone mdl-cell--4-col-tablet">
					<div class="main_features">
						<h4>Scale</h4>
						<br>
						<ul>
							<li>Plug-n-play more modules as your needs grow.</li>
							<li>Connect to website, e-commerce and other external entities to enable business from a single screen.</li>
						</ul>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-phone mdl-cell--4-col-tablet">
					<div class="main_features">
						<h4>Achieve</h4>
						<br>
						<ul>
							<li>Easily Identify Trends in your data to plan efﬁcient strategies.</li>
							<li>Keep your goals on track by planning schedules, to-do lists and noting your ideas.</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<h1 style="padding: 20%; text-align: center;">How do you feel?</h1>
					<img src="<?php echo base_url().'assets/images/feeling.svg'; ?>" style="width: 100%;">
				</div>
			</div>
			<div class="mdl-grid " style="background-color: #fff; color: #666;padding: 10%; padding-top: 10%;">
				<div class="mdl-cell mdl-cell--12-col">
					<h3 style="text-align: center;">Because at Evomata we believe,</h3>
					<h2 style="line-height: 1.5em;font-weight: bold;text-align: center;">"Everything is all about Functionality, Usability & Creativity."</h2>
				</div>
				<div class="mdl-cell mdl-cell--12-col focus_point">
					<h3>And the only thing we want is,</h3>
					<h2 style="line-height: 1.3em;">"Let you focus on your speciality!"</h2>
				</div>
			</div>
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<a href="http://www.evomata.com" target="_blank"> &copy; Evomata Innovations (OPC) Pvt. Ltd.</a>
				</div>
			</div>
		</div>
	</main>
	</div>
</body>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111704192-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111704192-4');
</script>
<script>
    let url = new URL(window.location.href);
    let searchParams = new URLSearchParams(url.search);
    console.log(searchParams.get('ref'));
    
    $(document).ready(function() {
        $.post('http://evomata.com/campaign/receive_campaign_values.php?ref=' + searchParams.get('ref'), {
			'site' : 'daifunc.com'
 		}, function(d,s,x) {
 			console.log(d);
 		})  
    })
</script>
</html>