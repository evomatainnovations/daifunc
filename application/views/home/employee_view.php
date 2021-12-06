<style type="text/css">
	.manager_main_card_event {
		width: 100%;
		padding: 10px;
		text-align: left;
		border-radius: 5px;
		border: 1px solid #ccc;
	}

	.mgr_view_card {
		padding: 5px;
		margin: 10px;
		height: auto;
	}

	.mgr_view_card_title {
		font-size: 2em;
		margin: 20px;
	}

	.mgr_view_card_details {
		width: 100%;
		overflow-x: auto;
	}

	.mgr_view_content {
		border-radius: 5px;
		border: 1px solid #ccc;
		padding-left: 10px;

	}

	.mgr_view_content_title {
		font-weight: bold !important;
	}

	.mgr_view_content_details {

	}

	.mgr_view_content_event {
		border-radius: 5px;
		padding: 5px;
		margin-right: 10px;
		background-color: #ffc107;
	}

	.mgr_view_content_image {
		width: 20%;
	}

	.mgr_view_content_person {
		border-radius: 5px;
		padding: 5px;
		margin-right: 10px;
		background-color: #8bc34a;
	}
	
	.mgr_view_content_recent {
		border-radius: 5px;
		padding: 5px;
		margin-right: 10px;
		background-color: #9c27b0;
		color: #fff;
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
<div class="mdl-grid" style="width: 100%;text-align: left;">
	<?php
		if (isset($emp_list)) {
			for ($i=0; $i < count($emp_list) ; $i++) { 
				echo '<div class="mdl-cell mdl-cell--3-col emp_veiw">';
				echo '<div class="mdl-card mdl-shadow--4dp mgr_view_card" style="text-align: left;border-radius:10px;">';
				echo '<p class="mgr_view_card_title">'.$emp_list[$i]->ic_name.'</p>';
				echo '<div class="mdl-grid mgr_view_card_details">';
				$flg = 0;
				for ($ij=0; $ij < count($emp_progress) ; $ij++) {
					if ($emp_progress[$ij]->iual_created_by == $emp_list[$i]->ic_uid && $emp_progress[$ij]->iual_title == 'progress') {
						$flg++;
						echo '<div class="mdl-cell mdl-cell--12-col mgr_view_content" style="height:15vh;background-color: rgba(255, 0, 0, 0.46);">';
						echo '<h4 class="mgr_view_content_title">'.$emp_progress[$ij]->iua_title.'</h4>';
						echo '<p>'.$emp_progress[$ij]->iual_title.'</p>';
						echo '</div>';
					}
				}
				$flg = 0;
				for ($ij=0; $ij < count($emp_progress) ; $ij++) {
					if ($flg < 3) {
						if ($emp_progress[$ij]->iual_created_by == $emp_list[$i]->ic_uid) {
							if ($emp_progress[$ij]->iual_title == 'cancel' || $emp_progress[$ij]->iual_title == 'done') {
								$flg++;
								echo '<div class="mdl-cell mdl-cell--12-col mgr_view_content" style="background-color: rgba(0, 205, 0, 0.46);">';
								echo '<p>'.$emp_progress[$ij]->iua_title.' activity marked as  '.$emp_progress[$ij]->iual_title.'</p>';
								echo '</div>';	
							}
						}	
					}
				}
				echo '</div></div></div>';
			}
		}
	?>
</div>