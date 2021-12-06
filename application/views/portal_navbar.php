<!DOCTYPE html>
<html>
<head>
	<title>IRENE - Portal</title>
<script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>	<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.min.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material_icon.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url().'assets/css/material.light_blue-blue.min.css'; ?>" />

	<script src="<?php echo base_url().'assets/js/moment-with-locales.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material-calender.css'; ?>">
	<script src="<?php echo base_url().'assets/js/material-calender.js'; ?>" type="text/javascript" charset="utf-8"></script>	


	<script src="<?php echo base_url().'assets/js/jquery-ui.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url().'assets/js/tag-it.js'; ?>" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery-ui.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.tagit.css'; ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<style type="text/css">
		.mdl-card {
			text-align: cent er;
		}

		.mdl-card {
			width: 100% !important;
		}

		.mdl-cell {
			/*border: 1px #000 solid;*/
		}

		.mdl-card__title {
			width: 100%!important;
			height: 125px;
			color: #fff;
			background-color: rgb(3,169,244);
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
		<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
				<span class="mdl-layout-title"><?php echo $title; ?></span>
				<div class="mdl-layout-spacer"></div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">
					<?php if($search=="true") {
						echo '<label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp"><i class="material-icons">search</i></label>'; 
						}?>

					<div class="mdl-textfield__expandable-holder">
						<input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp">
					</div>
				</div>
			</div>
			<?php if (isset($tabs)) {
				echo $tabs;
			} ?>
		</header>
		<div class="mdl-layout__drawer">
			<span class="mdl-layout-title">OneDynamics-IRENE Demo</span>
			<nav class="mdl-navigation">
				<?php $user_details = $this->session->userdata()['admin_details'];
				    for ($i=0; $i < count($user_details); $i++) { 
				    	if($user_details[$i]->ia_super == "true"){ ?>
				    		<a class="mdl-navigation__link" href="<?php echo base_url().'Portal'; ?>">Home</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/customers'; ?>">Customers</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/system_domains'; ?>">Domains</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/system_functions'; ?>">Functions</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/modules'; ?>">Modules</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/modules_shortcuts'; ?>">Add shortcuts</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_document_id'; ?>">Create Document Id</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/allot_modules'; ?>">Allot</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/column_index'; ?>">Column Index</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/join_index'; ?>">Join Index</a>
							<hr>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/view_template'; ?>">Template</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_user_kpi'; ?>">Key performance indicators</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/module_helper'; ?>">Module Helper</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/module_data_export'; ?>">Module Wise Data Export</a>
							<hr>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_time_constraint'; ?>">Time Constraint</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_display'; ?>">Display Elements</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_kpi'; ?>">KPI Selection</a>
				    	<?php }else if ($user_details[$i]->ia_general == "true") { ?>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/customers'; ?>">Customers</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_document_id'; ?>">Create Document Id</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/allot_modules'; ?>">Allot</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/module_data_export'; ?>">Module Wise Data Export</a>
							<hr>
				    	<?php }else if ($user_details[$i]->ia_developer == "true") { ?>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/system_domains'; ?>">Domains</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/system_functions'; ?>">Functions</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/modules'; ?>">Modules</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/modules_shortcuts'; ?>">Add shortcuts</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/column_index'; ?>">Column Index</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/join_index'; ?>">Join Index</a>
							<hr>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/view_template'; ?>">Template</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_user_kpi'; ?>">Key performance indicators</a>
							<hr>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_time_constraint'; ?>">Time Constraint</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_display'; ?>">Display Elements</a>
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/create_kpi'; ?>">KPI Selection</a>
							<hr>

				    	<?php }

				    } ?>
				    		
							<a class="mdl-navigation__link" href="<?php echo base_url().'Portal/logout'; ?>">Logout</a>	
			</nav>
		</div>
		