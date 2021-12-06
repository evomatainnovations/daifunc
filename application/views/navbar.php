<!DOCTYPE>
<html>
<head>
	<title>DAIFUNC | <?php echo $title; ?></title>
	<script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
	<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.min.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material_icon.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.red-deep_orange.min.css'; ?> ">
    <link rel="shortcut icon" type="image/x-icon" href="http://evomata.com/assets/images/logo-2587x2829.png" />
    
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
	<style type="text/css">
	    html, body ,h1 ,h2 ,h3 ,h4 ,h5 ,h6 {
	        font-family: 'Muli', sans-serif !important;
	    }

	    .scroll-auto {
		  -webkit-overflow-scrolling: auto; /* Stops scrolling immediately */
		}
	    
		.mdl-card {
			text-align: center;
		}

		.mdl-card {
			width: 100% !important;
		}

		.mdl-cell {
			/*border: 1px #000 solid;*/
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
			/*box-shadow: 2px 5px 10px #999999;*/
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
			outline: none;
			padding: 10px;
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
	        opacity: 2;
	    }

		#msg_nav_x{
			margin-left: 70%;
			background-color: #fff;
			width: 30%;
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
		/*.general_table {
			width: 100%;
	        text-align: left;
	        font-size: 1em;
	        border: 1px solid #ccc;
	        border-collapse: collapse;
	        border-radius: 10px;
	    }*/

/*		@media only screen and (max-width: 760px) {
			.general_table {
				display: block;
	        	overflow: auto;
			}

			#msg_nav_x{
				margin-left: 0px;
				width: 100%;
			}
		}

		.general_table > thead > tr {
			/*box-shadow: 0px 5px 5px #ccc;*/
			/*border: 1px solid #ccc;
		}

		.general_table > thead > tr > th {
			padding: 10px;
		}

		.general_table > tbody {
			border: 1px solid #ccc;
		}
		.general_table > tbody > tr {
			border-bottom: 1px solid #ccc;
		}

		.general_table > tbody > tr > td {
			padding: 15px;
		}

		.general_table > tfoot > tr {
			border: 1px solid #ccc;
		}

		.general_table > tfoot > tr > td {
			padding: 10px;
		}*/

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
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
				<span class="mdl-layout-title"><?php echo $title; ?></span>
				<div class="mdl-layout-spacer"></div>
				<?php if($search=="true") {
					echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">';
					echo '<label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp"><i class="material-icons">search</i></label>'; 
					echo '<div class="mdl-textfield__expandable-holder">
							<input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp">
						</div>
					</div>';
				}?>
				<!-- <a class="ani" href="<?php echo base_url()."Messaging/index/".$code; ?>"> -->
				<button class="mdl-button mdl-js-button" id="msg_btn"><i class="material-icons ">mail_outline</i></button>
				<!-- </a> -->
				<button class="mdl-button mdl-button--ico" id="ask_irene" style="background: url('<?php echo base_url();?>assets/images/dai_func.png') no-repeat; background-size: contain;"><span class="mdl-badge ask_irene"></span></button>
				<!-- <button class="mdl-button mdl-js-button notifications"  id="notifications"><i class="material-icons" style="color: #fff !important;">notifications</i></button> -->
			</div>
			<?php if (isset($tabs)) {
				echo $tabs;
			} ?>
		</header>
		<div class="mdl-layout__drawer" id="menu_nav_x">
			<span class="mdl-layout-title" style="/*background-image: url('<?php #echo base_url()."assets/images/pattern_nav.svg"; ?>');*/ height:auto;border-radius: 0px 0px 300px 0px;">
				<!-- <img src="<?php //echo base_url().'assets/images/Logo_white.pn'; ?>" style="width: 80%;bottom: 20%;"> -->
				<div style="margin-top: 75px;">
					<div style="font-size: 1.2em;line-height: 100%;margin-bottom: 15px;"><?php echo "Hey, ".$name; ?></div>
					<!-- <button class="mdl-button mdl-button--raised" value="0" id="f_place">My Account</button> -->
					<!-- <button class="mdl-button mdl-button--raised switch" value="0" id="" style="margin-right: 10px">My Account</button> -->
                        <!-- <option value="0">My Account</a></option> -->
                    <!-- <div style="font-size: 0.6em;line-height: 150%;" id="quote"></div> -->
				</div>
			</span>
			<nav class="mdl-navigation" style="text-align: center;">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone mdl-cell--4-col-tablet" style="padding: 10px;">
						<a class="mdl-navigation__link ani" style="padding: 10px;" href="<?php echo base_url().'Home/index/'.$code; ?>"><i class="material-icons">dashboard</i> Home</a>
					</div>
					<div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone mdl-cell--4-col-tablet" style="padding: 10px;">
						<a class="mdl-navigation__link ani" style="padding: 10px;" href="<?php echo base_url().'Home/collection/home/'.$code; ?>" id=""><i class="material-icons">store</i> Collection</a>
					</div>
					<div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone mdl-cell--4-col-tablet" style="padding: 10px;">
						<a class="mdl-navigation__link ani" style="padding: 10px;" href="<?php echo base_url().'Account/index/'.$code; ?>"><i class="material-icons">settings</i> Settings</a>
					</div>
					<div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone mdl-cell--4-col-tablet" style="padding: 10px;">
						<?php 
							if ($gid == 0) {
								echo '<a class="mdl-navigation__link switch_s" id="0" style="padding:10px;"><i class="material-icons">person</i><br>My Groups</a>';
							}
							if (isset($user_connection)) {
								for ($i=0; $i < count($user_connection); $i++) {
									if ($gid == $user_connection[$i]->iug_id) {
										echo '<a class="mdl-navigation__link switch_s" id="'.$user_connection[$i]->iug_id.'" style="padding:10px;"><i class="material-icons">group</i><br> '.$user_connection[$i]->iug_name.'</a>';
									}
								}
							}
						?>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<a class="mdl-navigation__link ani" style="padding: 10px;" href="<?php echo base_url().'Home/client_view/'.$code; ?>"><i class="material-icons">supervisor_account</i> My Network</a>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div style="color: #000;padding: 20px;border-radius: 10px;box-shadow: 0px 5px 10px #aaa;">
						<input class="mdl-textfield__input" type="text" placeholder="Search" id="mod_search" style="outline: none;">
					</div>
				</div>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col" id="module_nav" style="text-align: left;"></div>
					<hr>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: left;"><a class="mdl-navigation__link ani logout" href="#"><i class="material-icons">power_settings_new</i> Logout</a></div>
				</div>
			</nav>
		</div>
		
		<div class="modal fade" id="msg_nav_x">
			<div class="mdl-grid" style="margin: 3px;" id="main_screen_x">
				<div class="mdl-cell mdl-cell--12-col" style="display: flex; padding-bottom: 20px;">
					<h3 style="margin: 3px; width: 100%; font-weight: bold;">Messaging</h3>
					<button class="mdl-button mdl-js-button" data-dismiss="modal"><i class="material-icons">close</i></button>	
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<input type="text" style="outline: none; border: 0px; background-color: inherit; border-bottom: 1px solid #ccc; width: 100%; font-size: 1.2em; padding: 5px;" class="contact_window_search_chats" placeholder="Search Messages">
				</div>
				<div class="mdl-cell mdl-cell--12-col" id="msg_list_x"></div>
			</div>

			<div class="mdl-grid" style="margin: 3px; display: none;" id="msg_screen_x">
				<div class="mdl-cell mdl-cell--12-col" style="display: flex; padding-bottom: 20px;">
					<button class="mdl-button mdl-js-button" id="msg_back_x"><i class="material-icons">keyboard_arrow_left</i></button>
					<i class="material-icons mdl-list__item-avatar">person</i>
					<h4 style="margin: 15px; width: 100%; font-weight: bold;margin-top:10px;" id="msg_title_x"></h4>
					<button class="mdl-button mdl-js-button" data-dismiss="modal"><i class="material-icons">close</i></button>
				</div>
				<div class="mdl-cell mdl-cell--12-col msg_screen_data_scroll" id="" style="height: 77vh; overflow-y: scroll;">
					<ul class="mdl-list" id="msg_screen_data_x">
					
					</ul>
				</div>
				<div class="mdl-cell mdl-cell--12-col sending_msgs" style="height: 65px;">
					<table style="width: 100%; box-shadow: 0px 2.5px 6px #666; border-radius: 10px;">
						<tr>
							<td style="padding: 5px;">
								<textarea style="outline: none; border: 0px;width: 100%; font-size: 1.2em; padding: 15px; height: auto; height: 50px; max-height: 70px;" placeholder="Type Here" class="chat_window_tools_text"></textarea>
							</td>
							<td style="text-align: center;">
								<button class="mdl-button mdl-js-button mdl-button--icon" id="msg_send"><i class="material-icons">send</i></button>
							</td>
							<td style="text-align: center;">
								<div class="po-markup">
									<button class="mdl-button mdl-js-button mdl-button--icon" id="msg_extn"><i class="material-icons expand_less">expand_less</i></button>
					                <div class="po-content" style="display: none;">
					                	<!-- <div class="po-title"><h4><i class="material-icons">extension</i>  Extension</h4></div> -->
					                	<div class="po-body">
					                		<div class="mdl-grid">
					                			<div class="mdl-cell mdl-cell--12-col">
					                				<button class="mdl-button oppo_modal" style="display: none;"><i class="material-icons">screen_share</i> Share Opportunity data</button>
					                				<button class="mdl-button req_modal" style="display: none;"><i class="material-icons">screen_share</i> Share Requirement data</button>
					                				<button class="mdl-button dm_modal" style="display: none;"><i class="material-icons">screen_share</i> Share Design Manager data</button>
					                				<button class="mdl-button boq_modal" style="display: none;"><i class="material-icons">screen_share</i> Share BOQ data</button>
					                				<button class="mdl-button project_modal" style="display: none;"><i class="material-icons">screen_share</i> Share Project data</button>
					                			</div>
					                		</div>
					                    </div>
					                 </div>
					            </div>
							</td>
						</tr>
					</table>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="text-align: right;">
					
				</div>
			</div>
		</div>
		<div class="modal fade" id="oppo_share_modal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body">
	                	<h3>Share Opportunity data</h3>
	                    <hr>
	    				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="oppo_txn_title">
							<label class="mdl-textfield__label" for="oppo_txn_title">Enter opportunity name</label>
						</div>
						<table style="width: 100%;">
							<tbody class="oppo_det_table">
							</tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="mdl-button send_oppo" data-dismiss="modal"><i class="material-icons">send</i> Send</button>
	                	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="req_share_modal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body">
	                	<h3>Share Requirement data</h3>
	                    <hr>
	    				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="req_txn_title">
							<label class="mdl-textfield__label" for="req_txn_title">Enter requirement name</label>
						</div>
						<table style="width: 100%;">
							<tbody class="req_det_table">
							</tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="mdl-button send_req" data-dismiss="modal"><i class="material-icons">send</i> Send</button>
	                	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="dm_share_modal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body">
	                	<h3>Share Design Manager data</h3>
	                    <hr>
	                    <div class="mdl-cell mdl-cell--12-col">
		                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"style="height: 30px;" >
		                        <select class="mdl-textfield__input" id="dm_txn_list" style="height: 30px;">
		                            <option value="null">Select design type</option>
		                            <option value="contact">Contact</option>
		                            <option value="project">Project</option>
		                            <option value="oppo">Opportunity</option>
		                        </select>
		                    </div>  
		                </div>
		                <div class="mdl-cell mdl-cell--12-col">
		    				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input class="mdl-textfield__input" type="text" id="dm_txn_title">
								<label class="mdl-textfield__label" for="dm_txn_title">Enter type name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<label>Category</label>
							<ul id="cat_tag"></ul>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="mdl-button send_dm" data-dismiss="modal"><i class="material-icons">send</i> Send</button>
	                	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="boq_share_modal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body">
	                	<h3>Share BOQ data</h3>
	                    <hr>
	                    <div class="mdl-cell mdl-cell--12-col">
		                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"style="height: 30px;" >
		                        <select class="mdl-textfield__input" id="boq_txn_list" style="height: 30px;">
		                            <option value="null">Select boq type</option>
		                            <option value="contact">Contact</option>
		                            <option value="project">Project</option>
		                            <option value="oppo">Opportunity</option>
		                        </select>
		                    </div>  
		                </div>
		                <div class="mdl-cell mdl-cell--12-col">
		    				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input class="mdl-textfield__input" type="text" id="boq_txn_title">
								<label class="mdl-textfield__label" for="boq_txn_title">Enter boq name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col boq_user_list"></div>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="mdl-button send_boq" data-dismiss="modal"><i class="material-icons">send</i> Send</button>
	                	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="project_share_modal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body">
	                	<h3>Share Project data</h3>
	                    <hr>
	                    <div class="mdl-cell mdl-cell--12-col">
		                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input class="mdl-textfield__input" type="text" id="project_txn_title">
								<label class="mdl-textfield__label" for="project_txn_title">Enter project name</label>
							</div>
		                </div>
		                <div class="mdl-cell mdl-cell--12-col">
							<label>Project Group</label>
							<ul id="project_tag"></ul>
						</div>
						<table style="width: 100%;">
							<tbody class="project_det_table"></tbody>
						</table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="mdl-button send_project" data-dismiss="modal"><i class="material-icons">send</i> Send</button>
	                	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="share_data_modal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body share_data_view">

	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
		<div class="modal" id="suspend_Modal" role="dialog" style="display: none" data-backdrop="false">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-body">
	                	<div style="text-align: center;">
	                		<i class="material-icons suspend_icon">sentiment_dissatisfied</i>
	                	</div>
	                	<div style="margin-left: 20px;margin-right: 20px;">
	                		<h4>Look's like your subscription for <?php if(isset($mname)) echo $mname; ?> Module has expired, you can renew by clicking on the renew button.</h4>
	                	</div>
	                	<div style="text-align: center;">
	                		<button class="mdl-button mdl-button--colored renew"><i class="material-icons">refresh</i> Renew</button>
	                		<button class="mdl-button mdl-button--colored home"><i class="material-icons">home</i> Home</button>
	                	</div>
	                </div>
	            </div>
	        </div>
	    </div>
		<div class="modal" id="account_Modal" role="dialog" style="display: none">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h2>Switch Account To</h2>
	                    <button type="button" class="mdl-button close" data-dismiss="modal">&times;</button>
	                </div>
	                <div class="modal-body">
	                	<button class="mdl-button mdl-button--colored create_group" style="width: 100%;"><i class="material-icons">create</i> Create Group</button>
	                	<div class="mdl-cell mdl-cell--12-col">
	                		<div class="mdl-textfield mdl-js-textfield">
							    <input class="mdl-textfield__input" type="text" id="g_search">
							    <label class="mdl-textfield__label" for="g_search">Group</label>
							</div>
							<button class="mdl-button mdl-js-button mdl-button--colored" id="account_search"><i class="material-icons">search</i> Search</button>
	                	</div>
						<div id="account_body">
							
						</div>
	                </div>
	                <div class="modal-footer">
			        	<button type="button" class="mdl-button close" data-dismiss="modal">Close</button>
			        </div>
	            </div>
	        </div>
	    </div>
		<div class="modal fade" id="activity_modal" role="dialog">
		    <div class="modal-dialog">
		        <div class="modal-content"></div>
		    </div>
		</div>
		<div id="img_preview_modal" class="modal fade">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col"><button class="mdl-button close" data-dismiss="modal" style="color: #fff;"><i class="material-icons" style="color: #fff;font-weight: bolder;font-size: 30px;">close</i> close</button></div>
			</div>
	        <div class="mdl-grid img_preview"></div>
	        <div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col"><button class="mdl-button close" data-dismiss="modal" style="color: #fff;"><i class="material-icons" style="color: #fff;font-weight: bolder;font-size: 30px;">close</i> close</button></div>
			</div>
	    </div>
<script type="text/javascript">
	var msg_data = [];
	var sel_cid = null ;
	var lists = [];
	var oppo_det = [];
	var req_det = [];
	var contact_det = [];
	var boq_det = [];
	var project_det = [];
	var project_det_arr = [];
	var dm_cat_det = [];
	var p_grp_det = [];
	var grp_data = [];

	var oppo_det_arr = [];
	var req_det_arr = [];
	var boq_det_arr = [];

	var share_data_type = '';
	var share_data_type_name = '';
	var share_data_type_id = 0;
	var temp_oid=0;
	<?php
	if (isset($mod)) {
		for ($il=0; $il < count($mod) ; $il++) {
			if($mod[$il]->mname == 'Opportunity') {
				echo "$('.oppo_modal').css('display','block');";
			}
			if($mod[$il]->mname == 'Requirement') {
				echo "$('.req_modal').css('display','block');";
			}
			if($mod[$il]->mname == 'Design Manager') {
				echo "$('.dm_modal').css('display','block');";
			}
			if($mod[$il]->mname == 'BOQ') {
				echo "$('.boq_modal').css('display','block');";
			}
			if($mod[$il]->mname == 'Projects') {
				echo "$('.project_modal').css('display','block');";
			}
		}
	}
	?>
	$(document).ready(function() {
		get_chat_history();
		get_extension_data();

		$('.po-markup > #msg_extn').popover({
            trigger: 'click',
            html: true,
            title: function() {
                return $(this).parent().find('.po-title').html();
            },
            content: function() {
                return $(this).parent().find('.po-body').html();
            },
            placement: 'top'
        }).on('shown.bs.popover', function () {
	   
        	$('.oppo_modal').click(function (e) {
        		e.preventDefault();
        		share_data_type = 'oppo';
        		var data_oppo = [];
        		for (var i = 0; i < oppo_det.length; i++) {
        			data_oppo.push(oppo_det[i].name);
        		}
        		$("#oppo_txn_title").autocomplete({
	                source: function(request, response) {
	                    var results = $.ui.autocomplete.filter(data_oppo, request.term);
	                    response(results.slice(0, 10));
	                },select: function(event, ui) {
                		var value =  ui.item.value;
                		for (var i = 0; i < oppo_det.length; i++) {
                			if (oppo_det[i].name == value) {
                				share_data_type_id = oppo_det[i].id;
                			}
		        		}
						var out = '';
		        		for (var i = 0; i < oppo_det_arr.length; i++) {
		        			out+= '<tr style="width:100%;"><td><input type = "checkbox" id = "'+oppo_det_arr[i].id+'" class = "mdl-checkbox__input"></td><td><h4>'+oppo_det_arr[i].name+'</h4></td></tr>';
		        		}
		        		$('.oppo_det_table').empty();
		        		$('.oppo_det_table').append(out);
		            }
	            });

        		oppo_det_arr.push({'id' : '1' ,'name' : 'Likeihood of conversion' ,'flg' : 'false' });
        		oppo_det_arr.push({'id' : '2' ,'name' : 'Basic Details' ,'flg' : 'false' });
        		oppo_det_arr.push({'id' : '3' ,'name' : 'Notes' ,'flg' : 'false' });
        		oppo_det_arr.push({'id' : '4' ,'name' : 'Send information' ,'flg' : 'false' });
        		oppo_det_arr.push({'id' : '5' ,'name' : 'Proposal' ,'flg' : 'false' });
        		oppo_det_arr.push({'id' : '6' ,'name' : 'Activity' ,'flg' : 'false' });
        		oppo_det_arr.push({'id' : '7' ,'name' : 'Status' ,'flg' : 'false' });
        		$('#oppo_share_modal').modal('show');
        		$('#msg_extn').popover('hide');
        		$('#oppo_txn_title').focus();
        	});

        	$('.req_modal').click(function (e) {
        		e.preventDefault();
        		share_data_type = 'req';
        		var data_req = [];
        		for (var i = 0; i < req_det.length; i++) {
        			data_req.push(req_det[i].name);
        		}
        		$("#req_txn_title").autocomplete({
	                source: function(request, response) {
	                    var results = $.ui.autocomplete.filter(data_req, request.term);
	                    response(results.slice(0, 10));
	                },select: function(event, ui) {
                		var value =  ui.item.value;
                		for (var i = 0; i < req_det.length; i++) {
                			if (req_det[i].name == value) {
                				share_data_type_id = req_det[i].id;
                			}
		        		}
						var out = '';
		        		for (var i = 0; i < req_det_arr.length; i++) {
		        			out+= '<tr style="width:100%;"><td><input type = "checkbox" id = "'+req_det_arr[i].id+'" class = "mdl-checkbox__input"></td><td><h4>'+req_det_arr[i].name+'</h4></td></tr>';
		        		}
		        		$('.req_det_table').empty();
		        		$('.req_det_table').append(out);
		            }
	            });

        		req_det_arr.push({'id' : '1' ,'name' : 'Images And notes' ,'flg' : 'false' });
        		req_det_arr.push({'id' : '2' ,'name' : 'Requirement List' ,'flg' : 'false' });

        		$('#req_share_modal').modal('show');
        		$('#msg_extn').popover('hide');
        		$('#req_txn_title').focus();
        	});

        	$('.dm_modal').click(function (e) {
        		e.preventDefault();
        		share_data_type = 'dm';
        		$('#dm_share_modal').modal('show');
        		$('#msg_extn').popover('hide');
        	});

        	$('.boq_modal').click(function (e) {
        		e.preventDefault();
        		share_data_type = 'boq';
        		$('#boq_share_modal').modal('show');
        		$('#msg_extn').popover('hide');
        	});

        	$('.project_modal').click(function (e) {
        		e.preventDefault();
        		share_data_type = 'project';
        		$('#project_share_modal').modal('show');
        		$('#msg_extn').popover('hide');
        		var data_req = [];
        		for (var i = 0; i < project_det.length; i++) {
        			data_req.push(project_det[i].name);
        		}
        		$("#project_txn_title").autocomplete({
			        source: function(request, response) {
			            var results = $.ui.autocomplete.filter(data_req, request.term);
			            response(results.slice(0, 10));
			        },select: function(event, ui) {
			    		var value =  ui.item.value;
			    		share_data_type_name = value;
		    			for (var i = 0; i < project_det.length; i++) {
		        			if (project_det[i].name == value) {
		        				share_data_type_id = project_det[i].id;
		        			}
		        		}
		        		var grp_data = [];
		        		for (var i = 0; i < p_grp_det.length; i++) {
		        			if (p_grp_det[i].id == share_data_type_id) {
		        				grp_data.push(p_grp_det[i].name);
		        			}
			    		}
			    		$('#project_tag').tagit({
				    		autocomplete : { delay: 0, minLenght: 1},
				    		allowSpaces : true,
				    		availableTags : grp_data,
				    		singleField : true
				    	});
					}
			    });

			    project_det_arr.push({'id' : '1' , 'name' : 'Uploaded Files' , 'flg' : 'false'});
			    project_det_arr.push({'id' : '2' , 'name' : 'Product List' , 'flg' : 'false'});
			    project_det_arr.push({'id' : '3' , 'name' : 'Project Status' , 'flg' : 'false'});
			    project_det_arr.push({'id' : '4' , 'name' : 'Group Status' , 'flg' : 'false'});
			    var out = '';
        		for (var i = 0; i < project_det_arr.length; i++) {
        			out+= '<tr style="width:100%;"><td><input type = "checkbox" id = "'+project_det_arr[i].id+'" class = "mdl-checkbox__input"></td><td><h4>'+project_det_arr[i].name+'</h4></td></tr>';
        		}
        		$('.project_det_table').empty();
        		$('.project_det_table').append(out);
        	});
	    });

	    $('#boq_share_modal').on('change','#boq_txn_list',function (e) {
			e.preventDefault();
			var type = $(this).val();
			var data_req = [];
			share_data_type_name = type;
    		if (type == 'oppo') {
    			for (var i = 0; i < oppo_det.length; i++) {
        			data_req.push(oppo_det[i].name);
        		}
    		}else if(type == 'project' ){
    			for (var i = 0; i < project_det.length; i++) {
        			data_req.push(project_det[i].name);
        		}
    		}else{
    			for (var i = 0; i < contact_det.length; i++) {
        			data_req.push(contact_det[i].name);
        		}
    		}

    		$("#boq_txn_title").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(data_req, request.term);
                    response(results.slice(0, 10));
                },select: function(event, ui) {
            		var value =  ui.item.value;
            		if (type == 'oppo') {
		    			for (var i = 0; i < oppo_det.length; i++) {
	            			if (oppo_det[i].name == value) {
	            				share_data_type_id = oppo_det[i].id;
	            			}
		        		}
		    		}else if(type == 'project' ){
		    			for (var i = 0; i < project_det.length; i++) {
	            			if (project_det[i].name == value) {
	            				share_data_type_id = project_det[i].id;
	            			}
		        		}
		    		}else{
		    			for (var i = 0; i < contact_det.length; i++) {
	            			if (contact_det[i].name == value) {
	            				share_data_type_id = contact_det[i].id;
	            			}
		        		}
		    		}
		    		$.post('<?php echo base_url()."Messaging/get_boq_users/".$code."/"; ?>',{
		    			'val' : value,
		    			'type' : type
		            },function(d,s,x) {
		            	var a = JSON.parse(d);
		            	var out = '';
		        		for (var i = 0; i < a.boq_user.length; i++) {
		        			boq_det_arr.push({'id' : a.boq_user[i].ic_id ,'name' : a.boq_user[i].ic_name ,'flg' : 'false' });
		        		}
		        		for (var i = 0; i < boq_det_arr.length; i++) {
		        			out+= '<tr style="width:100%;"><td><input type = "checkbox" id = "'+boq_det_arr[i].id+'" class = "mdl-checkbox__input"></td><td><h4> '+boq_det_arr[i].name+'</h4></td></tr>';
		        		}
		        		$('.boq_user_list').empty();
		        		$('.boq_user_list').append(out);
		            }, "text");
	            }
            });
		});

		$('#dm_share_modal').on('change','#dm_txn_list',function (e) {
			e.preventDefault();
			var type = $(this).val();
			var data_req = [];
			share_data_type_name = type;
    		if (type == 'oppo') {
    			for (var i = 0; i < oppo_det.length; i++) {
        			data_req.push(oppo_det[i].name);
        		}
    		}else if(type == 'project' ){
    			for (var i = 0; i < project_det.length; i++) {
        			data_req.push(project_det[i].name);
        		}
    		}else{
    			for (var i = 0; i < contact_det.length; i++) {
        			data_req.push(contact_det[i].name);
        		}
    		}

    		$("#dm_txn_title").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(data_req, request.term);
                    response(results.slice(0, 10));
                },select: function(event, ui) {
            		var value =  ui.item.value;
            		if (type == 'oppo') {
		    			for (var i = 0; i < oppo_det.length; i++) {
	            			if (oppo_det[i].name == value) {
	            				share_data_type_id = oppo_det[i].id;
	            			}
		        		}
		    		}else if(type == 'project' ){
		    			for (var i = 0; i < project_det.length; i++) {
	            			if (project_det[i].name == value) {
	            				share_data_type_id = project_det[i].id;
	            			}
		        		}
		    		}else{
		    			for (var i = 0; i < contact_det.length; i++) {
	            			if (contact_det[i].name == value) {
	            				share_data_type_id = contact_det[i].id;
	            			}
		        		}
		    		}
					$.post('<?php echo base_url()."Design_manager/get_dm_details/".$code."/"; ?>'+type+'/'+share_data_type_id
					, function(d,s,x) {
		                var a = JSON.parse(d);
		                for (var i = 0; i < a.edit_dmc.length; i++) {
			            	dm_cat_det.push(a.edit_dmc[i].iextetdmc_name);
			            }
			            $('#cat_tag').tagit({
				    		autocomplete : { delay: 0, minLenght: 1},
				    		allowSpaces : true,
				    		availableTags : dm_cat_det,
				    		singleField : true,
				    		tagLimit: 1
				    	});
		            });
	            }
            });
		});

        function get_extension_data(){
			$.post('<?php echo base_url()."Messaging/get_extension_data/".$code."/"; ?>'
			, function(d,s,x) {
                var a = JSON.parse(d);
                for (var i = 0; i < a.oppo.length; i++) {
                	oppo_det.push({'id' : a.oppo[i].iextetop_id , 'name' : a.oppo[i].iextetop_title });
                }
                for (var i = 0; i < a.req.length; i++) {
                	req_det.push({'id' : a.req[i].iextetr_id , 'name' : a.req[i].iextetr_title });
                }
                for (var i = 0; i < a.contact.length; i++) {
                	contact_det.push({'id' : a.contact[i].ic_id , 'name' : a.contact[i].ic_name });
                }
                for (var i = 0; i < a.boq.length; i++) {
                	boq_det.push({'id' : a.boq[i].iextetboq_id , 'name' : a.boq[i].iextetboq_title });
                }
                for (var i = 0; i < a.projects.length; i++) {
                	project_det.push({'id' : a.projects[i].iextpp_id , 'name' : a.projects[i].iextpp_p_name });
                }
                for (var i = 0; i < a.p_grp.length; i++) {
                	p_grp_det.push({'id' : a.p_grp[i].iextpp_id , 'name' : a.p_grp[i].iextptg_name });
                }
            });
		}

		$('#cat_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 1},
    		allowSpaces : true,
    		availableTags : dm_cat_det,
    		singleField : true,
    		tagLimit: 1
    	});

    	$('#project_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 1},
    		allowSpaces : true,
    		availableTags : grp_data,
    		singleField : true
    	});

		$('#boq_share_modal').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < boq_det_arr.length; i++) {
            	if(boq_det_arr[i].id == a){
            		if(!ischecked){
				    	boq_det_arr[i].flg = 'false';
				    }else{
				    	boq_det_arr[i].flg = 'true';
				    }
            	}
            }
        });

		$('#req_share_modal').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < req_det_arr.length; i++) {
            	if(req_det_arr[i].id == a){
            		if(!ischecked){
				    	req_det_arr[i].flg = 'false';
				    }else{
				    	req_det_arr[i].flg = 'true';
				    }
            	}
            }
        });

        $('#oppo_share_modal').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < oppo_det_arr.length; i++) {
            	if(oppo_det_arr[i].id == a){
            		if(!ischecked){
				    	oppo_det_arr[i].flg = 'false';
				    }else{
				    	oppo_det_arr[i].flg = 'true';
				    }
            	}
            }
        });

        $('#project_share_modal').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < project_det_arr.length; i++) {
            	if(project_det_arr[i].id == a){
            		if(!ischecked){
				    	project_det_arr[i].flg = 'false';
				    }else{
				    	project_det_arr[i].flg = 'true';
				    }
            	}
            }
        });

		$('#req_share_modal').on('click','.send_req',function (e) {
			e.preventDefault();
			send_data();
		});

		$('#oppo_share_modal').on('click','.send_oppo',function (e) {
			e.preventDefault();
			send_data();
		});

		$('#dm_share_modal').on('click','.send_dm',function (e) {
			e.preventDefault();
			send_data();
		});

		$('#boq_share_modal').on('click','.send_boq',function (e) {
			e.preventDefault();
			send_data();
		});

		$('#project_share_modal').on('click','.send_project',function (e) {
			e.preventDefault();
			send_data();
		});

		function send_data(){
			var cat_list = [];
			$('#cat_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					cat_list.push(tmpstr1);
				}
			});
			var grp_list = [];
			$('#project_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					grp_list.push(tmpstr1);
				}
			});
			$.post('<?php echo base_url()."Messaging/send_share_data/".$code; ?>', {
                'type' : share_data_type,
                'type_name' : share_data_type_name,
                'type_id' : share_data_type_id,
                'req_arr' : req_det_arr,
                'oppo_arr' : oppo_det_arr,
                'boq_arr' : boq_det_arr,
                'project_arr' : project_det_arr,
                'dm_cat' : cat_list,
                'share_to' : sel_cid,
   				'grp_list' : grp_list
            }, function(d,s,x) {
            	if (share_data_type == 'oppo') {
					var msg ='Opportunity Share Data';
				}else if (share_data_type == 'req') {
					var msg ='Requirement Share Data';
				}else if(share_data_type == 'dm'){
					var msg = share_data_type_name+' '+cat_list[0]+' final design.';
				}else if(share_data_type == 'boq'){
					var msg ='BOQ Share Data';
				}else if(share_data_type == 'project'){
					var msg = share_data_type_name+' Project Share Data';
				}
				send_msg(msg, sel_cid , share_data_type , d);
            }, "text");
		}

		$('#msg_screen_data_x').on('click','.msg_view_data',function (e) {
			e.preventDefault();
			var msg_index = $(this).prop('id');
			var ext_type = msgs[msg_index].data[0].msg_type;
			var ext_id = msgs[msg_index].data[0].msg_type_id;
			$.post('<?php echo base_url()."Messaging/get_extension_view/".$code."/"; ?>'+ext_type+'/'+ext_id
			, function(d,s,x) {
                var a = JSON.parse(d);
                console.log(a);
                var out = '';
                if (ext_type == 'oppo') {
                	var path = '<?php echo base_url().'assets/uploads/';?>'+a.save_opportunity[0].iextetop_owner;
                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>'+a.save_opportunity[0].iextetop_title+'</h3></div>';
                	out+='<div class="mdl-cell mdl-cell--12-col"><h5>( '+a.save_opportunity[0].iextetop_status+' )</h5></div><hr>';
                	if (a.cust_details.length > 0 ) {
	                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>Details</h3>';
	                		for (var i = 0; i < a.cust_details.length; i++) {
	                			out+='<p>'+a.cust_details[i].ip_property+' => '+a.cust_details[i].icbd_value+'</p>';
	                		}
	                	out+='</div>';
	                }
                	if (a.likehood.length > 0) {
                		if (a.likehood[0].oppo_rate != null) {
	                		out+='<div class="mdl-cell mdl-cell--12-col"><h3>Likeihood of conversion <h3>';
	                		out+='<p>'+a.likehood[0].oppo_rate+'</p>';
	                		out+='</div>';
	                	}
                	}
                	if (a.oppo_note.length > 0) {
                		out+='<div class="mdl-cell mdl-cell--12-col"><h3>Notes</h3>';
                		for (var i = 0; i < a.oppo_note.length; i++) {
                			out+='<p>'+a.oppo_note[i].iexteon_note+' - '+a.oppo_note[i].iexteon_created+'</p>';
                		}
                		out+='</div>';
                	}
                	if (a.info.length > 0) {
	                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>Send information</h3>';
	                		for (var i = 0; i < a.info.length; i++) {
	                			out+='<p>'+a.info[i].iexteoi_title+' - '+a.info[i].iexteoi_created+'</p>';
	                		}
	                	out+='</div>';
	                }
                	if (a.proposal.length > 0) {
	                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>Proposal</h3>';
	                		for (var i = 0; i < a.proposal.length; i++) {
	                			out+='<p>'+a.proposal[i].iextepro_txn_id+' - '+a.proposal[i].iextepro_status+'</p>';
	                		}
	                	out+='</div>';
	                }
                	if (a.activity.length > 0) {
		            	out+='<div class="mdl-cell mdl-cell--12-col"><h3>Activity</h3>';
		            		for (var i = 0; i < a.activity.length; i++) {
		            			out+='<p>'+a.activity[i].iua_title+' - '+a.activity[i].iua_status+'</p>';
		            		}
		            	out+='</div>';
		            }
                }else if(ext_type == 'req'){
                	var path = '<?php echo base_url().'assets/uploads/';?>'+a.req[0].iextetr_owner;
                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>'+a.req[0].iextetr_title+'</h3></div><hr>';
                	if (a.edit_req_list.length > 0 ) {
	                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>Requirement List</h3>';
	                		for (var i = 0; i < a.edit_req_list.length; i++) {
	                			out+='<p>'+a.edit_req_list[i].ip_product+' => '+a.edit_req_list[i].iextetrp_qty+'</p>';
	                		}
	                	out+='</div>';
	                }

	                if (a.edit_notes.length > 0 ) {
	                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>Images And notes</h3>';
	                		for (var i = 0; i < a.edit_notes.length; i++) {
	                			if (a.edit_notes[i].iextetrn_type == 'note') {
	                				out+= '<p>'+a.edit_notes[i].iextetrn_content+'</p>';
	                			}else{
	                				out+= '<img src="'+path+'/'+a.edit_notes[i].iextetrn_content+'" style="width:150px;height:150px;margin:10px;" />'
	                			}
	                		}
	                	out+='</div>';
	                }
                }else if(ext_type == 'dm'){
                	var file_name = '';
                	temp_oid = a.oid;
                	out+='<div class="mdl-cell mdl-cell--12-col"><h3>'+a.dm_details[0].iextetdm_title+'</h3></div><hr>';

                	for (var j = 0; j < a.edit_dmc.length; j++) {
                		for (var i = 0; i < a.edit_dmc_upload.length; i++) {
		                	for (var ij = 0; ij < a.edit_dmc_upload[i].length; ij++) {
		                		if (a.edit_dmc[j].iextetdmc_id == a.edit_dmc_upload[i][ij].iextetdmcu_dmc_id) {
		                			if (a.edit_dmc_upload[i][ij].iextetdmcu_final == 'true') {
		                				out+='<div class="mdl-grid"><div class="mdl-cell mdl-cell--8-col"><h4>'+a.edit_dmc[j].iextetdmc_name+'</h4></div>';
		                				file_name = a.edit_dmc_upload[i][ij].iextetdmcu_timestamp;
		                				out+='<div class="mdl-cell mdl-cell--4-col"><button class="mdl-button mdl-button--colored upload_view" id="'+file_name+'"><i class="material-icons">cloud_download</i> download</button></div>';
			                			var path = '<?php echo base_url()."assets/uploads/"; ?>'+a.oid;
						                out+= '<div class="mdl-cell mdl-cell--12-col" style="text-align:center;"><img class="" id="'+file_name+'" src="'+path+'/'+file_name+'" style="max-width:100%;max-height:100%;border:0px solid #ccc;" alt="your image" /></div></div>';
			                		}
		                		}
		                	}
		                }
                	}
                }else if (ext_type == 'boq'){
                	data_arr = [];
	                mutual_arr = [];
	                user_arr = [];
	                column_count = 0;
	                col_compare = [];
	                out += '<h3>'+a.boq_title+'</h3><hr>';
	                for (var i = 0; i < a.boq_arr.length; i++) {
	                    if (a.boq_arr[i]['full_width'] == 'no') {
	                        if (data_arr.length == 0 ) {
	                            for (var ij = 0; ij < a.boq_arr[i]['row_data'].length; ij++) {
	                                var type = a.boq_arr[i]['row_data'][ij]['data'];
	                                data_arr.push({'level' : i , 'col' : ij , 'data' : type});
	                            }
	                        }else{
	                            for (var ij = 0; ij < a.boq_arr[i]['row_data'].length; ij++) {
	                                var type = a.boq_arr[i]['row_data'][ij]['data'];
	                                data_arr.push({'level' : i , 'col' : ij , 'data' : type});
	                                if (type == '') {
	                                    col_id = ij;
	                                }
	                            }
	                        }
	                    }
	                }

	                for (var i = 0; i < a.users.length; i++) {
	                    user_arr.push({'uid' : a.users[i].iextetboqm_uid , 'uname' : a.users[i].ic_name , 'amount' : 0 , 'final' : 'no'});
	                }

	                for (var i = 0; i < a.mutual_arr.length; i++) {
	                    for (var k = 0; k < a.mutual_arr[i]['data'].length; k++) {
	                        var m_uid = a.mutual_arr[i]['uid'];
	                        var m_uname = a.mutual_arr[i]['uname'];
	                        if (a.mutual_arr[i]['data'][k]['full_width'] == 'no') {
	                            if (mutual_arr.length == 0 ) {
	                                for (var ij = 0; ij < a.mutual_arr[i]['data'][k]['row_data'].length; ij++) {
	                                    var type = a.mutual_arr[i]['data'][k]['row_data'][ij]['data'];
	                                    mutual_arr.push({'uid' : m_uid , 'u_name' : m_uname ,'level' : k , 'col' : ij , 'data' : type});
	                                }
	                            }else{
	                                for (var ij = 0; ij < a.mutual_arr[i]['data'][k]['row_data'].length; ij++) {
	                                    var type = a.mutual_arr[i]['data'][k]['row_data'][ij]['data'];
	                                    mutual_arr.push({'uid' : m_uid , 'u_name' : m_uname , 'level' : k , 'col' : ij , 'data' : type});
	                                }
	                            }
	                        }
	                    }
	                }
	                var flg = 0;
		            if (data_arr.length > 0 ) {
		                flg = data_arr[0].level;
		            }
		            out += '<table class="general_table" style="width: 100%;border: 1px solid #ccc;"><thead>';
		            for (var j = 0; j < data_arr.length; j++) {
		                if(data_arr[j].level == flg){
		                    if (data_arr[j].col != col_id) {
		                        out += '<th>'+data_arr[j].data+'</th>';
		                    }else{
		                        for (var i = 0; i < user_arr.length; i++) {
		                            out += '<th>'+user_arr[i].uname+'<br>('+data_arr[j].data+')</th>';
		                        }
		                    }
		                }
		            }
		            out += '</thead>';
		            out += '<tbody>';
		            out += '<tr>';
		            for (var j = 0; j < data_arr.length; j++) {
		                if(data_arr[j].level != flg){
		                    var flg_id = data_arr[j].level;
		                    if (data_arr[j].col != col_id) {
		                        out += '<td>'+data_arr[j].data+'</td>';
		                    }else{
		                        var f = 0;
		                        for (var i = 0; i < mutual_arr.length; i++) {
		                            if(mutual_arr[i].level == flg_id){
		                                if (mutual_arr[i].col == col_id) {
		                                    if (mutual_arr[i].data == '') {
		                                        out += '<td>  N/A  </td>';
		                                    }else{
		                                        out += '<td>'+mutual_arr[i].data+'</td>';
		                                        for (var ik = 0; ik < user_arr.length; ik++) {
		                                            if(user_arr[ik].uid == mutual_arr[i].uid){
		                                                user_arr[ik].amount = Number(user_arr[ik].amount) + Number(mutual_arr[i].data);
		                                            }
		                                        }
		                                    }
		                                    f++;
		                                }
		                            }
		                        }
		                        if (f > 0) {
		                            out += '</tr>';
		                        }
		                    }
		                }
		            }
		            out += '<tr>';
		            var count_flg = 0;
		            for (var j = 0; j < data_arr.length; j++) {
		                if(data_arr[j].level == flg){
		                    if (data_arr[j].col != col_id) {
		                        count_flg ++;
		                    }else{
		                        out += '<td colspan="'+count_flg+'">Total Amount</td>';
		                        for (var i = 0; i < user_arr.length; i++) {
		                            if (user_arr[i].amount == 0) {
		                                out += '<td>N/A</td>';
		                            }else{
		                                out += '<td>'+user_arr[i].amount+'</td>';
		                            }
		                        }
		                    }
		                }
		            }
		            out += '</tr>';
		            out += '</tbody></table>';
                }else if (ext_type == 'project'){
                	if (a.pro.length > 0 ) {
                		out += '<h2>'+a.pro[0].iextpp_p_name+'</h2><hr>';
                	}
                	if (a.project_chart) {
                		out += '<h4>Project Status : </h4>';
                		out += a.project_chart;
                		console.log(a.project_chart);
                	}
                	if (a.doc.length > 0 ) {
                		out += '<hr><h4>Project Files : </h4>';
	                	out += '<div class="mdl-grid" style="width:100%;margin-top:10px;">';
	                	for (var i = 0; i < a.doc.length; i++) {
	                		path = "<?php echo base_url().'assets/uploads/';?>"+a.oid+'/'+a.doc[i].icd_timestamp;
			                out += '<div style="width:25%;height:100px;"><img src="'+ path+'" style="max-width:100%;max-height:100%;border: 1px solid #000;" alt="File not found !" /></div>';
			            }
			            out += '</div>';
                	}
                	if (a.group_chart) {
                		out += '<hr><h4>Group Status : </h4>';
                		out += a.group_chart;
                	}
                	if (a.prod_list.length > 0 ) {
                		var p_flg = 1;
                		out += '<hr><h4>Product List : </h4>';
                		for (var il = 0; il < a.pro_grp.length; il++) {
                			out += '<h5 style="font-weight:bold;">'+p_flg+') '+a.pro_grp[il].iextptg_name+'</h5>';
                			p_flg++;
                			out += '<div class="mdl-cell mdl-cell--12-col"><table class="general_table"><thead><th>Sr. no</th><th>Product name</th><th>Rate</th><th>Qty</th><th>Total</th></thead><tbody class="prod_table">';
		                	var t_amount = 0;
		                	var srno = 1;
		                	var flg = 0;
		                	for (var i = 0; i < a.prod_list.length; i++) {
		                		if (a.pro_grp[il].iextptg_id == a.prod_list[i].iextppl_project_group) {
		                			out += '<tr>';
									out +='<td>'+srno+'</td><td>'+a.prod_list[i].ip_product+'</td><td>'+a.prod_list[i].iextppl_rate+'</td><td>'+a.prod_list[i].iextppl_qty+'</td>';
									var amt = Number(a.prod_list[i].iextppl_qty) * Number(a.prod_list[i].iextppl_rate) ;
									out += '<td>'+amt+'</td>';
									out += '</tr>';
									t_amount = Number(t_amount) + Number(amt);
									srno++;
									flg++;
		                		}
		                	}
		                	if (flg > 0) {
		                		out += '<tr style="border: 1px solid #ccc;"><td colspan="4">Grand Total</td><td>'+t_amount+'</td></tr></tbody></table></div>';
		                	}else{
		                		out += '<tr style="border: 1px solid #ccc;text-align:center;"><td colspan="5">No records found !</td></tr></tbody></table></div>';
		                	}
                		}
                	}
                }
                $('.share_data_view').empty(); 
                $('.share_data_view').append(out);
                $('#share_data_modal').modal('show');
            });
		});

		$('#share_data_modal').on('click','.upload_view',function(e){
			e.preventDefault();
			var file_name = $(this).prop('id');
			window.location = "<?php echo base_url().'Messaging/download_msg_doc/'.$code.'/'; ?>"+file_name+'/'+temp_oid;
		});

		function get_chat_history(){
			$.post('<?php echo base_url()."Messaging/get_chat_history/".$code."/"; ?>'
			, function(d,s,x) {
                var a = JSON.parse(d);
                lists = [];
                for (var i = 0; i < a.customer.length; i++) {
                	lists.push({ "id" : i, "photo" : "", "title" : a.customer[i].title , "msg_id" : a.customer[i].msg_id , "msg_short" : "", "star" : 'true' , 'uid' : a.customer[i].uid , 'invite' : a.customer[i].invite });
                }
                load_lists();
            });
		}

		setInterval(function(){
	        if (sel_cid != null) {
	        	var mid = null;
	        	for (var i = 0; i < lists.length; i++) {
		            if (sel_cid == lists[i].id) {
		                mid=lists[i].msg_id;
		            }
		        }
		        if (mid != null) {
		        	load_msgs(mid);
		        }
	        }
	    }, 1000);

		$('#msg_btn').click(function(e) {
	        e.preventDefault();
	        $('#main_screen_x').css('display', 'block');
			$('#msg_screen_x').css('display', 'none');
			$('#msg_title_x').empty();
	        $('#msg_nav_x').modal('show');
	    });

		var flg=false;
		var a="";

		$('#msg_list_x').on('click', 'li', function(e) {
			e.preventDefault();
			sel_cid = $(this).prop('id');
			for (var i = 0; i < lists.length; i++) {
	            if (sel_cid == lists[i].id) {
	                mid=lists[i].msg_id;
	            }
	        }
	        if (mid == 0) {
	        	$.post('<?php echo base_url()."Messaging/check_chat_history/".$code."/"; ?>'+sel_cid
				, function(d,s,x) {
	                var a = JSON.parse(d);
	                if (a.msg_id == 0) {
	                	$('#main_screen_x').css('display', 'none');
						$('#msg_screen_x').css('display', 'block');
						$('#msg_screen_data_x').empty();

						for (var i = 0; i < lists.length; i++) {
							if(lists[i].id = sel_cid){
								$('#msg_title_x').empty();
								$('#msg_title_x').append(lists[i].title);
								var m ='';
								if (lists[i].uid == null) {
									m+= '<p style="text-align:center;margin-top:35%;"><button class="btn btn-lg btn-danger pic_button send_invite_cid">Invite</button><p>';
									m+= '<p style="text-align:center;">Click on invite button for send message.</p>';
									$('.sending_msgs').css('display','none');
									$('#msg_screen_data_x').append(m);
								}else if (lists[i].invite == 0 || lists[i].invite == '' || lists[i].invite == null) {
									m+= '<p style="text-align:center;margin-top:20%;"><i class="material-icons" style="background-color:rgb(121, 169, 8);font-size:100px;border-radius: 50%;color: #fff;">done</i><p>';
									m+= '<p style="text-align:center;font-weight:bold;font-size:20px;">Invite Sent.</p>';
									m+= '<p style="text-align:center;margin-top:20%;">Click on invite button for sent invite again.</p>';
									m+= '<p style="text-align:center;"><button class="btn btn-lg btn-danger pic_button send_invite_cid">Invite</button><p>';
									$('.sending_msgs').css('display','none');
									$('#msg_screen_data_x').append(m);
								}else{
									m+= '<p style="text-align:center;">Now you can send message to '+lists[i].title+' .</p>';
									$('#msg_screen_data_x').append(m);
									$('.chat_window_tools_text').focus();
								}
							}
						}
	                }else{
	                	for (var i = 0; i < lists.length; i++) {
							if(lists[i].id = sel_cid){
								lists[i].msg_id = a.msg_id;
							}
						}
						load_msgs(a.msg_id);
	                }
	            });
	        }else{
	        	load_msgs(mid);
	        }
		});

		$('#msg_screen_data_x').on('click','.send_invite_cid',function (e) {
			e.preventDefault();
			$('.loader').show();
			$.post('<?php echo base_url()."Messaging/send_invite_chat/".$code."/"; ?>'+sel_cid,
			function(d,s,x) {
				var m ='';
				$('.loader').hide();
                if (d == 'true') {
                	m+= '<p style="text-align:center;margin-top:20%;"><i class="material-icons" style="background-color:rgb(121, 169, 8);font-size:100px;border-radius: 50%;color: #fff;">done</i><p>';
					m+= '<p style="text-align:center;font-weight:bold;font-size:20px;">Invite Sent.</p>';
					m+= '<p style="text-align:center;margin-top:20%;">Click on invite button for sent invite again.</p>';
					m+= '<p style="text-align:center;"><button class="btn btn-lg btn-danger pic_button send_invite_cid">Invite</button><p>';
					$('#msg_screen_data_x').empty();
					$('#msg_screen_data_x').append(m);
					$('.sending_msgs').css('display','none');
                }else{

                }
            });
		});

		$('#msg_back_x').click(function(e) {
			e.preventDefault();
			sel_cid = null;
			$('.contact_window_search_chats').val('');
			$('.msg_list_x').empty();
			get_chat_history();
			$('#main_screen_x').css('display', 'block');
			$('#msg_screen_x').css('display', 'none');
		});

		$('.contact_window_search_chats').keyup(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Messaging/search_messages_contacts/".$code; ?>', {
                's' : $(this).val()
            }, function(d,s,x) {
                var a=JSON.parse(d); lists=[];

                for (var i = 0; i < a.customer.length; i++) {
                	if (a.customer[i].ic_uid != a.owner) {
                		lists.push({ "id" : a.customer[i].ic_id, "photo" : "", "title" : a.customer[i].ic_name , "msg_id" : "0" , "msg_short" : "", "star" : 'true' , 'uid' : a.customer[i].ic_uid , 'invite' : a.customer[i].ic_msg_invite });
                	}
                }
                load_lists();
            });
        });

		function load_lists() {
	        a="";
	        for (var i = 0; i < lists.length; i++) {
	        	a+= '<li class="mdl-list__item mdl-list__item--three-line" id="' + lists[i].id + '"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-avatar">person</i><span>' + lists[i].title + '</span> </span> <span class="mdl-list__item-secondary-content">';
	        	//  <span class="mdl-list__item-text-body">welcome</span>
				if (lists[i].starred == 'true') {
					a+='<a class="mdl-list__item-secondary-action" href="#"><i class="material-icons">star</i></a>';	
				}
				a+='</span> </li>';
	        }
	        $('#msg_list_x').empty();
	        $('#msg_list_x').append(a);
	    }

	    $('.chat_window_tools_text').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                send_msg($('.chat_window_tools_text').val(), sel_cid , 'msg' , '0');
                $(this).val('');
                $(this).focus();
            }
        });

        $('#msg_send').click(function(e) {
            e.preventDefault();
            send_msg($('.chat_window_tools_text').val(), sel_cid , 'msg' , '0');
        });

	    function send_msg(message, id, msg_type , msg_type_id) {
	        var mid=0;
	        var title = '';
	        var to = 0;
	        for (var i = 0; i < lists.length; i++) {
	            if (id==lists[i].id) {
	                mid=lists[i].msg_id;
	                title = lists[i].title;
	                to = lists[i].uid;
	            }
	        }
	        if (message!="") {
	            $.post('<?php echo base_url()."Messaging/update_messages/".$code; ?>', {
	                'm' : message, 'mid' : mid, 'title' : title, 'uid_to' : to , 'msg_type' : msg_type , 'msg_type_id' : msg_type_id
	            }, function(d,s,x) {
	            	for (var i = 0; i < lists.length; i++) {
						if(lists[i].id = sel_cid){
							lists[i].msg_id = d;
						}
					}
	                load_msgs(d);
	                $('.chat_window_tools_text').val('');
	                $('.chat_window_tools_text').focus();
	            }, "text");
	        }
	    }

	    function load_msgs(id) {
	        $.post('<?php echo base_url()."Messaging/get_messages/".$code; ?>', {
	            'i' : id
	        },function(d,s,x) {
	        	var b=JSON.parse(d);
	            var title = '';
	            var a = '';
	            owner = b.m_owner;
	            uname =[];
	            msgs=[];
	            var msg_member = Number(b[0][0].data.unread.length) + Number(b[0][0].data.read.length);

	            for (var i = 0; i < b[0].length; i++) {
	                msgs.push({ 'mid' : b[0][i].mid, 'title' : b[0][i].title, 'data' :  [{'from': b[0][i].data.from,'name': b[0][i].data.name ,'read' : b[0][i].data.read , 'unread' : b[0][i].data.unread ,'message' : b[0][i].data.message, 'date' : b[0][i].data.date, 'attachment' : b[0][i].data.attachment, 'remind' : b[0][i].data.remind, "star" : b[0][i].data.star , 'status' : 'read' , 'msg_type' : b[0][i].data.msg_type , 'msg_type_id' : b[0][i].data.msg_type_id }] });
	            }

	    		for (var i = 0; i < lists.length; i++) {
	    			if(lists[i].msg_id == id){
						$('#msg_title_x').empty();
						$('#msg_title_x').append(lists[i].title);
	    			}
	    		}

	            for (var i = 0; i < b.uname.length; i++) {
	                uname.push({'id' : b.uname[i].ic_uid , 'name' : b.uname[i].ic_name});
	            }
	            
	            if (msgs.length > 0) {
	                for (var i = 0; i < msgs.length; i++) {
	                    if (msgs[i].data[0].attachment != "null") {
	                        a+='<div class="today_header" style="width:100%;text-align:right;"><a href="' +msgs[i].data[0].attachment +'" style="color:black;" id="attach_download" download><i class="material-icons" style="margin-right : 80px">attach_file</i></a></div>';
	                    }else if (msgs[i].data[0].msg_type == 'grp_create') {
	                    	for (var ij = 0; ij < uname.length; ij++) {	                    		
								if(owner == msgs[i].data[0].from){
									a+='<div class="today_header" style="width:100%;text-align:center;"><span>You '+msgs[i].data[0].message+' "'+msgs[i].data[0].msg_type_id+'"</span></div>';
									break;
								}else{
	                    			a+='<div class="today_header" style="width:100%;text-align:center;"><span>'+uname[ij].name+' '+msgs[i].data[0].message+' "'+msgs[i].data[0].msg_type_id+'"</span></div>';
	                    			break;
								}
	                    	}
	                    }else if (msgs[i].data[0].msg_type != 'msg') {
	                    	if(msgs[i].data[0].from == owner) {
								a+= '<li class="mdl-list__item mdl-list__item--three-line" style="text-align:right; padding-left: 25%;height:auto;" id="' + msgs[i].mid + '" ><span class="mdl-list__item-primary-content" style="border-radius: 10px; background-color: #000;color:#fff;padding: 15px;height:auto;text-align:center;">' + msgs[i].data[0].message + '<hr style="width:100%;color:#fff;"><button class="mdl-button msg_view_data"style="color:#fff;" id="'+ i +'"><i class="material-icons">remove_red_eye</i> view</button> </span><span class="mdl-list__item-secondary-content">';
								a+='</span> </li>';
							} else {
								a+= '<li class="mdl-list__item mdl-list__item--three-line" style="text-align:left; padding-right: 25%;height:auto;" id="' + i + '" >';
								if (msg_member > 1) {
									for (var ij = 0; ij < uname.length; ij++) {
										if(uname[ij].id == msgs[i].data[0].from){
											a+= '<span class="mdl-list__item-primary-content" style="border-radius: 10px; background-color: #e3e3e3;padding: 15px;height:auto;text-align:center;"><p style="color:rgb(255, 15, 5);font-weight:bold;text-align:left;">'+ uname[ij].name +'</p>' + msgs[i].data[0].message + '<hr style="width:100%;color:#fff;"><button class="mdl-button msg_view_data" id="'+ i +'"><i class="material-icons">remove_red_eye</i> view</button></span> <span class="mdl-list__item-secondary-content">';
										}
									}
								}else{
									a+= '<span class="mdl-list__item-primary-content" style="border-radius: 10px; background-color: #e3e3e3;padding: 15px;height:auto;text-align:center;">' + msgs[i].data[0].message + '<hr style="width:100%;color:#000;"><button class="mdl-button msg_view_data" id="'+ i +'"><i class="material-icons">remove_red_eye</i> view</button></span> <span class="mdl-list__item-secondary-content">';
								}
								a+='</span> </li>';
							}
	                    }else{
							if(msgs[i].data[0].from == owner) {
								a+= '<li class="mdl-list__item mdl-list__item--three-line" style="text-align:right; padding-left: 25%;height:auto;" id="' + i + '" ><span class="mdl-list__item-primary-content" style="border-radius: 10px; background-color: #000;color:#fff;padding: 15px;height:auto;">' + msgs[i].data[0].message + '</span> <span class="mdl-list__item-secondary-content">';
								a+='</span> </li>';
							} else {
								a+= '<li class="mdl-list__item mdl-list__item--three-line" style="text-align:left; padding-right: 25%;height:auto;" id="' + i + '" >';
								if (msg_member > 2) {
									for (var ij = 0; ij < uname.length; ij++) {
										if(uname[ij].id == msgs[i].data[0].from){
											a+= '<span class="mdl-list__item-primary-content" style="border-radius: 10px; background-color: #e3e3e3;padding: 15px;height:auto;"><p style="color:rgb(255, 15, 5);font-weight:bold;">'+ uname[ij].name +'</p>' + msgs[i].data[0].message + '</span> <span class="mdl-list__item-secondary-content">';
										}
									}
								}else{
									a+= '<span class="mdl-list__item-primary-content" style="border-radius: 10px; background-color: #e3e3e3;padding: 15px;height:auto;">' + msgs[i].data[0].message + '</span> <span class="mdl-list__item-secondary-content">';
								}
								a+='</span> </li>';
							}
	                    }
	                }
	            }

	            $('#msg_screen_x').css('display','block');
	            $('#main_screen_x').css('display','none');
	            $('#msg_screen_data_x').empty();
	            $('#msg_screen_data_x').append(a);
	            $(".msg_screen_data_scroll").scrollTop(1e4);
	        });
	    }

	});
</script>

<script>
	var key = '';
	var user_data = [];
	var mod_nav_arr = [];
	var mod_cart = [];
	var gid = "<?php echo $gid; ?>";
	var myKey = '';
	<?php
		if (!isset($mname)) {
			$mname = '';
		}
		if (isset($user_connection)) {
			for ($i=0; $i < count($user_connection); $i++) {
	    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
			}
		}
		if (isset($mod)) {
			for ($il=0; $il < count($mod) ; $il++) {
				if($mod[$il]->domain != "NONE") {
					if ($mod[$il]->m_alias == null || $mod[$il]->m_alias == "" || $mod[$il]->m_alias == 'null' ) {
						$alias = $mod[$il]->mname;
					}else{
						$alias = $mod[$il]->m_alias;
					}
					echo "mod_nav_arr.push({'mid' : ".$mod[$il]->mid.", 'mname' : '".$mod[$il]->mname."', 'domain' : '".$mod[$il]->domain."', 'status' : '".$mod[$il]->status."' , 'alias' : '".$alias."' });";
				}
			}
		}
	?>

	$(document).ready(function() {
		get_module();
		suspend_module();
		get_not_number();
		// var m = "The design business continues to navel gaze. Designers are still designing for other designers rather than working to convince the business world of the importance of design in our everyday lives.";
		// $.getJSON("http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=40&callback=", function(a) {
		// 	var x = Math.floor((Math.random() * 40) + 1);
		// 	if(a[x].content.length <= 199) {
		// 		var quo = a[x].content;
		// 		var len = quo.length - 4;
		// 		quo = quo.substr(3, len);

		// 		$("#quote").append(quo + '<i>-' + a[x].title + '</i>');	
		// 	} else {
		// 		$("#quote").append("<p>I hope your having a nice day</p>");
		// 	}
			
		// })
		// .fail(function( jqxhr, textStatus, error ) {
		// 	var err = textStatus + ", " + error;
		// 	$("#quote").append("<p>I hope your having a great day today !!!</p>");
		// });;

		$('#module_nav').on('click','.select_mod',function(e){
			 e.preventDefault();
			$.post('<?php echo base_url()."Home/user_history/".$code; ?>', {
        		's_mod_id' : $(this).prop('id')
        	}, function(data, status, xhr) {
        		var abc = JSON.parse(data);
        		var path = "<?php echo base_url();?>"+ abc.dom_name +'/'+ abc.fun_name +'/'+abc.mid+'/'+"<?php echo $code;?>";
        		$('#redirect_modal').css('z-index','99999');
        		$('#redirect_modal').animate({
				    opacity: '1',
				    height: '100vh',
				    width: '100%'
				}, 300, function() { window.location = path; });
        	});
		});

		$('.renew').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Home/collection/0/'.$code; ?>";
		});

		$('.home').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Home/index/'.$code; ?>";
		});

		$('.create_group').click(function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Account/invite_setting/'.$code?>";
		})

		// var cookiename = 'CI_key';
		// var cookiestring=RegExp(""+cookiename+"[^;]+").exec(document.cookie);
		// myKey = decodeURIComponent(!!cookiestring ? cookiestring.toString().replace(/^[^=]+./,"") : "");

		// if (myKey == '') {
		// 	key = 'null';
		// 	logout_sess();
		// }else{
		// 	key = myKey;
		// }
		// console.log("local_ci_key : "+localStorage["myKey"] );
		if (localStorage.getItem("myKey") == null || localStorage.getItem("myKey") == '' || localStorage.getItem("myKey") == 'null') {
			logout_sess(localStorage.getItem("myKey"));
		}else{
			$.post('<?php echo base_url()."Account/check_ses/";?>'+localStorage["myKey"],
	 		function(data, status, xhr) {
     			if (data == 'false') {
         			localStorage["myKey"] = null;
         			logout_sess(localStorage["myKey"]);
		       	}
	       	});
		}
		
		function logout_sess(key) {
			$.post('<?php echo base_url()."Account/logout/";?>'+key,
			function(data, status, xhr) {
        		if (data == 'true') {
        			localStorage["myKey"] = null;
        			window.location = "<?php echo base_url();?>";
        		}
        	});
		}

		$('.logout').click(function (e) {
			e.preventDefault();
			logout_sess(localStorage.getItem("myKey"));
		});

		$('.switch_s').click(function(e) {
			e.preventDefault();
			$('#g_search').val('');
			$('#account_Modal').show();
			switch_account();
		});

		$('input[type=text]').keyup(function(e) {
			$(this).attr("autocomplete","off");
		});

		$('.close').click(function(e) {
			e.preventDefault();
			$('#account_Modal').hide();
		});

		$('#account_body').on('click', '.switch', function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Account/switch_account/'.$code.'/'; ?>" + $(this).prop('id');
		});

		$('#account_search').click(function(e) {
			e.preventDefault();
			
			$.post('<?php echo base_url()."Home/account_search/".$code; ?>', {
        		's_account' : $('#g_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		user_data = [];
        		for (var i=0; i < d.account.length; i++) {
            		user_data.push({'id' : d.account[i].iug_id, 'name' : d.account[i].iug_name});
        		}
        		switch_account();
        	});
		});

		setInterval(function(){
            get_not_number();
        }, 100000);

		function get_not_number() {
			// $.post('<?php //echo base_url()."Home/get_notification_count/".$code; ?>',
			var today = new Date();
			var d = today.getDate();
			var m = today.getMonth() + 1;
			var y = today.getFullYear();
			var h = today.getHours();
			var i = today.getMinutes();

			$.post('<?php echo base_url()."Home/getnotification/".$code."/"; ?>'+y+'/'+m+'/'+d+'/'+h+'/'+i+'/true',
			function(d, status, xhr) {
				var a = JSON.parse(d);
				if (a.notification.length > 0 ) {
					$('.ask_irene').attr('data-badge',a.notification.length);
				}
        	});	
		}

		$("#mod_search").keyup(function(e){
			e.preventDefault();
			var m_name = $('#mod_search').val();
			$.post('<?php echo base_url()."Home/module_search/".$code; ?>',{
        		'm_name' : m_name
        	},function(data, status, xhr) {
        		var d = JSON.parse(data);
        		mod_nav_arr = [];
        		for (var i=0; i < d.module.length; i++) {
        			var alias = d.module[i].m_alias;
    				if (d.module[i].m_alias == '' || d.module[i].m_alias == null) {
    					alias = d.module[i].mname;
    				}
    				mod_nav_arr.push({'mid' : d.module[i].mid, 'mname' : d.module[i].mname, 'domain' : d.module[i].domain, 'status' : d.module[i].status , 'alias' : alias});
        		}
        		get_module();
        	});
		});
	});

	function suspend_module() {
		for (var i = 0; i < mod_nav_arr.length; i++) {
			if(mod_nav_arr[i].mid == <?php if (isset($mid)) {echo $mid;}else{echo 0;} ?> ){
				if (mod_nav_arr[i].status == 'suspend') {
					$('#suspend_Modal').show();
				}
			}
		}
	}

	function get_module(){
		var a = '';
		for (var i = 0; i < mod_nav_arr.length; i++) {
				if (mod_nav_arr[i].status == 'active') {
					a+='<a class="mdl-navigation__link select_mod ani" href="#" id="'+mod_nav_arr[i].mid+'"><i class="material-icons">label_outline</i>'+mod_nav_arr[i].alias+'</a>';
				}else{
					a+='<a class="mdl-navigation__link select_mod ani" href="#" id="'+mod_nav_arr[i].mid+'"><i class="material-icons">label_outline</i> '+mod_nav_arr[i].alias+'<br><span style="font-size:0.7em;font-style:italic;">( '+mod_nav_arr[i].status+' )</span></a>';
				}
		}
		$('#module_nav').empty();
		$('#module_nav').append(a);
	}

	function switch_account(){
		var out = '';
		if (gid == 0 ) {
			out += '<button class="mdl-button mdl-button--raised mdl-button--colored switch" id="0" style="margin-right: 10px;width: 100%"><i class="material-icons">person</i> My Account</button>';
		}else{
			out+='<button class="mdl-button mdl-button--raised switch" id="0" style="margin-right: 10px;width: 100%"><i class="material-icons">person</i> My Account</button>';
		}

		for (var i=0; i < user_data.length; i++) {
    		if (gid == user_data[i].id) {
    			out+= '<button class="mdl-button mdl-button--raised mdl-button--colored switch" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
    		}else{
    			out+= '<button class="mdl-button switch" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
    		}
		}
		$('#account_body').empty();
    	$('#account_body').append(out); 

	}
</script>
