<!DOCTYPE>
<html>
<head>
	<title>COSMOS | <?php echo $title; ?></title>
	<script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
	<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.min.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material_icon.css'; ?>">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.<?php if (isset($color)) { echo $color; } ?>" />
	<script src="<?php echo base_url().'assets/js/moment-with-locales.min.js'; ?>" type="text/javascript" charset="utf-8"></script>

	<script src="<?php echo base_url().'assets/js/jquery-ui.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url().'assets/js/tag-it.js'; ?>" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery-ui.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.tagit.css'; ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material-calender.css'; ?>">
	<script src="<?php echo base_url().'assets/js/material-calender.js'; ?>" type="text/javascript" charset="utf-8"></script>

    <link href="<?php echo base_url().'assets/css/Opensans.css'; ?>" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<script src="<?php echo base_url().'assets/js/bootstrap-3.3.7.min.js'; ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap-3.3.7.min.css'; ?>">
	<link href="<?php echo base_url().'assets/css/font.css'; ?>" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo base_url().'assets/images/daifunc_logo.png'; ?>" type="image/x-icon">
	<style type="text/css">
	    html, body ,h1 ,h2 ,h3 ,h4 ,h5 ,h6 {
	        font-family: 'Muli', sans-serif !important;
	    }

		.mdl-card {
			text-align: center;
		}

		.mdl-card {
			width: 100% !important;
		}

		.mdl-card__title {
			width: 100%!important;
			height: 150px;
			color: #fff;
			background-color: #404040;
		}

		.mdl-card__title{
			width: 100%!important;
			height: 150px;
			/*color: #000;*/
			font-weight: bold;
			background-color: #bf2626;
		}

		.lower-button {
			right: 30px !important;
			bottom: 50px!important;
			position: fixed;
			z-index: 5;
			background-color: #404040;
			color: #fff;
		}

		.mdl-button-upside {
			margin-left: 10px!important;
			margin-right: 10px!important;
		}

        .mdl-layout__header {
            background-color:#fff !important;
            color: #000;
            font-weight: bold;
            box-shadow: none;
        }
        .mdl-layout__drawer-button {
        	color: #000 !important;
        	padding: 10px;
			outline: none;
        }
        
        .mdl-navigation__link {
            color: #000 !important;
        }
        
		#myTags {
			margin: 0px;
		}

		a:link {
		    color: #000;
			text-decoration: none;
		}

		a:visited {
		    color: #000;
			text-decoration: none;
		}

		a:hover {
		    color:#000;
			text-decoration: none;
		}

		a:active {
		    color:#000;
			text-decoration: none;
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

	    .general_table {
			width: 100%;
	        text-align: left;
	        border: 0px solid #ccc;
	        border-collapse: collapse;
	        
		}

		@media only screen and (max-width: 760px) {
			.general_table {
				display: block;
	        	overflow: auto;
			}
		}

		.general_table > thead > tr {
			box-shadow: 0px 5px 5px #ccc;
		}

		.general_table > thead > tr > th {
			padding: 10px;
		}

		.general_table > tbody > tr {
			border-bottom: 1px solid #ccc;
		}

		.general_table > tbody > tr > td {
			padding: 15px;
		}

		#msg_nav_x{
			margin-left: 70%;
			background-color: #fff;
			width: 30%;
		}

		.suspend_icon{
			  font-size: 1000%;
			  font-weight: lighter;
			  -webkit-text-stroke: 6px white;
		}

		::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
	      color: #ccc;
	    }

	    #img_preview_modal {
	        display: none; /* Hidden by default */
	        z-index: 50000 !important; /* Sit on top */
	        left: 15%;
	        top: 15%;
	        width: 70%; /* Full width */
	        height: 70%; /* Full height */
	        overflow: auto; /* Enable scroll if needed */
	        background-color: rgb(0,0,0);  /*Fallback color */
	        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
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

		.arrow{
			left: 95%;
		}
		.po-markup > .popover {
			width: 100%;
			left: 30px;
			max-width: 90%;
			margin-right: 10px;
		}

		.ui-widget {
	        z-index: 30000 !important;
	    }
</style>
</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
				<span class="mdl-layout-title"><?php echo $title; ?></span>
				<div class="mdl-layout-spacer" style="text-align: right;">
					<button class="mdl-button" id="mobile_cart"><i class="material-icons">shopping_cart</i></button>
					<!-- <i class="material-icons">shopping_cart</i> Cart<span class="mdl-badge" style="margin-left:15px;" data-badge="'+ d +'"></span> -->
				</div>
				<?php if($search=="true") {
					echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">';
					echo '<label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp"><i class="material-icons">search</i></label>'; 
					echo '<div class="mdl-textfield__expandable-holder"><input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp"></div></div>';
				}?>
			</div>
			<?php if (isset($tabs)) {
				echo $tabs;
			} ?>
		</header>
		<div class="mdl-layout__drawer" id="menu_nav_x">
			<span class="mdl-layout-title" style="height:150px;border-radius: 0px 0px 300px 0px;">
				<div style="margin-top: 75px;">
					<div style="font-size: 1.2em;line-height: 100%;margin-bottom: 15px;"><?php echo "Hey, ".$name; ?></div>
				</div>
			</span>
			<nav class="mdl-navigation" style="text-align: center;">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone mdl-cell--4-col-tablet" style="padding: 10px;">
						<a class="mdl-navigation__link ani" style="padding: 10px;" href="<?php echo base_url().'Mobile_app/cosmos_home/'.$code; ?>"><i class="material-icons">dashboard</i> Home</a>
					</div>
					<div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone mdl-cell--4-col-tablet" style="padding: 10px;">
						<a class="mdl-navigation__link ani" style="padding: 10px;" href="<?php echo base_url().'Mobile_app/cosmos_setting/'.$code; ?>"><i class="material-icons">settings</i> Settings</a>
					</div>
					<div class="mdl-cell mdl-cell--12-col" style="border :0.5px solid #ccc"></div>
					<div class="mdl-cell mdl-cell--12-col" id="module_nav" style="text-align: left;">
						<a class="mdl-navigation__link select_mod ani" href="#" id="Support"><i class="material-icons">label_outline</i>Support</a>
						<a class="mdl-navigation__link select_mod ani" href="#" id="Subscription"><i class="material-icons">label_outline</i>Subscription</a>
						<a class="mdl-navigation__link select_mod ani" href="#" id="Products"><i class="material-icons">label_outline</i>Products</a>
						<a class="mdl-navigation__link select_mod ani" href="#" id="Invoice"><i class="material-icons">label_outline</i>My Invoice</a>
					</div>
					<hr>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: left;"><a class="mdl-navigation__link ani logout" href="#"><i class="material-icons">power_settings_new</i> Logout</a></div>
				</div>
			</nav>
		</div>
		<div class="mdl-grid loader" style="display: none;">
			<div class="mdl-cell mdl-cell--4-col"></div>
		</div>
<script type="text/javascript">
	$(document).ready(function() {
		if (localStorage.getItem("myKey") == null || localStorage.getItem("myKey") == '' || localStorage.getItem("myKey") == 'null' ) {
			localStorage["myKey"] = null;
		}else{
			$.post('<?php echo base_url()."Mobile_app/check_mobile_sess/";?>'+localStorage["myKey"],
	 		function(data, status, xhr) {
     			if (data == 'true' || data == true) {
		       	}else{
		       		logout_sess(localStorage["myKey"]);
		       	}
	       	});
		}

		$.post("<?php echo base_url().'Mobile_app/cosmos_add_cart/'.$code; ?>",
		function(data,xhr,status){
			$('#mobile_cart').empty();
			if (data == 0) {
				$('#mobile_cart').append('<i class="material-icons">shopping_cart</i> Cart');
			}else{
				$('#mobile_cart').append('<i class="material-icons">shopping_cart</i> Cart<span class="mdl-badge" style="margin-left:15px;" data-badge="'+ data +'"></span>');
			}
		},'text')

		$('.select_mod').click(function(e){
			e.preventDefault();
			var mod_name = $(this).prop('id');
			$.post('<?php echo base_url()."Mobile_app/redirect_module/".$code;?>',{
				'mod_name' : mod_name
			},function(data, status, xhr) {
				var abc = JSON.parse(data);
				if (mod_name == 'Support') {
					var path = "<?php echo base_url();?>"+'Mobile_app/cosmos_support_home/'+abc.mid+'/'+"<?php echo $code;?>";
				}else if(mod_name == 'Subscription'){
					var path = "<?php echo base_url();?>"+'Mobile_app/cosmos_subscription_home/'+abc.mid+'/'+"<?php echo $code;?>";
				}else if(mod_name == 'Products'){
					var path = "<?php echo base_url();?>"+'Mobile_app/cosmos_product_home/'+abc.mid+'/'+"<?php echo $code;?>";
				}else if(mod_name == 'Invoice'){
					var path = "<?php echo base_url();?>"+'Mobile_app/cosmos_invoice/'+abc.mid+'/'+"<?php echo $code;?>";
				}

        		window.location = path;
	       	});
		});

		$('.logout').click(function(e){
			e.preventDefault();
			logout_sess(localStorage.getItem("myKey"));
		});

		function logout_sess(key) {
			$.post('<?php echo base_url()."Mobile_app/logout/";?>'+key,
			function(data, status, xhr) {
        		if (data == 'true') {
        			localStorage["myKey"] = null;
        			window.location = "<?php echo base_url()."Mobile_app/index/1";?>";
        		}
        	});
		}

		$('#mobile_cart').click(function(e){
			e.preventDefault();
			window.location = "<?php echo base_url()."Mobile_app/cosmos_mobile_cart/".$code;?>";
		});
	});
</script>

