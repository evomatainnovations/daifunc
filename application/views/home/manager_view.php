<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
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
		height: 80vh;
	}

	.mgr_view_card_title {
		font-size: 1em;
		margin-left: 20px;
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
	<div class="mdl-cell mdl-cell--4-col oppo_veiw">
		<div class="mdl-card mdl-shadow--4dp mgr_view_card" style="text-align: left;">
			<p class="mgr_view_card_title">Opportunity</p>
			<div class="mdl-grid mgr_view_card_details">
				<?php
					if (isset($opportunity)) {
						for ($i=0; $i < count($opportunity) ; $i++) { 
							echo '<div class="mdl-cell mdl-cell--12-col mgr_view_content">';
							echo '<h4 class="mgr_view_content_title">'.$opportunity[$i]->iextetop_title.'</h4>';
							for ($ij=0; $ij < count($oppo_activity_update) ; $ij++) {
								if ($oppo_activity_update[$ij]->iexteoa_oppo_id == $opportunity[$i]->iextetop_id) {
									echo '<p>'.$opportunity[$i]->iextetop_status.'</p>';
									echo '<p  class="mgr_view_content_recent">'.$oppo_activity_update[$ij]->iua_title,'</p>';
								}
							}
							for ($ij=0; $ij < count($oppo_activity_next) ; $ij++) {
								if ($oppo_activity_next[$ij]->iexteoa_oppo_id == $opportunity[$i]->iextetop_id) {
									$date=date_create($oppo_activity_next[$ij]->iua_date);
									echo '<p class="mgr_view_content_event">'.$oppo_activity_next[$ij]->iua_title.'  on  '.date_format($date,"jS F , Y @ H:i").'</p>';
								}
							}
							if ($opportunity[$i]->iextetop_mutual != '0') {
								for ($ij=0; $ij < count($oppo_mutual) ; $ij++) { 
									if ($oppo_mutual[$ij]->iexteom_op_id == $opportunity[$i]->iextetop_id) {
										echo '<p class="mgr_view_content_person">Managed by ';
										echo $oppo_mutual[$ij]->ic_name;
										echo '</p>';
									}
								}
							}
							echo '</div>';
						}
					}
				?>
			</div>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--4-col req_view">
		<div class="mdl-card mdl-shadow--4dp mgr_view_card" style="text-align: left;">
			<p class="mgr_view_card_title">Requirements</p>
			<div class="mdl-grid mgr_view_card_details">
				<?php
					if (isset($req)) {
						for ($i=0; $i < count($req) ; $i++) { 
							echo '<div class="mdl-cell mdl-cell--12-col mgr_view_content"><h4 class="mgr_view_content_title">'.$req[$i]->iextetr_title.'</h4>';
							echo '<p>';
							for ($j=0; $j < count($req_notes) ; $j++) { 
								$flg_count = 0 ;
								for ($ij=0; $ij < count($req_notes[$j]) ; $ij++) {
									if ($req_notes[$j][$ij]->iextetrn_req_id == $req[$i]->iextetr_id) {
										if ($req_notes[$j][$ij]->iextetrn_type == 'file') {
											$flg_count ++ ;
											if ($flg_count <= 10) {
												echo '<img class="mgr_view_content_image" src="'.base_url().'assets/uploads/'.$oid.'/'.$req_notes[$j][$ij]->iextetrn_content.'" alt="File format not found !">';
											}
										}
									}
								}	
							}
							echo '</p>';
							for ($ij=0; $ij < count($req_owner) ; $ij++) { 
								if ($req_owner[$ij]->iextetr_id == $req[$i]->iextetr_id) {
									echo '<p class="mgr_view_content_event">Created by '.$req_owner[$ij]->ic_name;
									echo '</p>';
								}
							}
							for ($ij=0; $ij < count($req_tag) ; $ij++) { 
								if ($req_tag[$ij]->iextetrm_req_id == $req[$i]->iextetr_id) {
									echo '<p class="mgr_view_content_person">Managed by '.$req_tag[$ij]->ic_name;
									echo '</p>';
								}
							}
							echo '</div>';
						}
					}
				?>
			</div>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--4-col pro_view">
		<div class="mdl-card mdl-shadow--4dp mgr_view_card" style="text-align: left;">
			<p class="mgr_view_card_title">Projects</p>
			<div class="mdl-grid mgr_view_card_details">
				<?php
					if (isset($projects)) {
						for ($i=0; $i < count($projects) ; $i++) {
							echo '<div class="mdl-cell mdl-cell--12-col mgr_view_content">';
							echo '<h4 class="mgr_view_content_title">'.$projects[$i]->iextpp_p_name.'</h4>';
							echo '<p>';
							echo '<div class="mdl-grid"><div class="mdl-cell mdl-cell--2-col"></div><div class="mdl-cell mdl-cell--8-col">';
					            if (count($pro_act) > 0 ) {
					                echo '<canvas id="ch'.$i.'" width="60" height="60"></canvas>';
					                $labels = [];
					                $tmp_lbl = [];
					                $values = [];
					                for ($ij=0; $ij < count($pro_act) ; $ij++) {
					                    if ($pro_act[$ij]['pid'] == $projects[$i]->iextpp_id ) {
					                        array_push($labels , $pro_act[$ij]['status']);
					                        array_push($values , $pro_act[$ij]['aid']);
					                    }
					                }
					                $labels_str = json_encode($labels);
					                $values_str = json_encode($values);
					                if (count($pro_act) > 0) {
					                    echo '<script>var ctx = document.getElementById("ch'.$i.'").getContext("2d");';
					                    echo 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "Project task", data: '.$values_str.', backgroundColor: ["#ff0000", "#999", "rgba(202, 200, 16, 0.79)","#800000", "#000"] }] }, options: { title : { display: true, text: "Group Status" } , rotation : -0.1 * Math.PI } });</script>';   
					                }
					            }
					        echo '</div></div>';
							echo '</p>';
							for ($ij=0; $ij < count($pro_activity_update) ; $ij++) {
								if ($pro_activity_update[$ij]->iextpt_p_id == $projects[$i]->iextpp_id) {
									echo'<p class="mgr_view_content_recent">'.$pro_activity_update[$ij]->iua_title.'</p>';
								}
							}
							for ($ij=0; $ij < count($pro_activity_next) ; $ij++) {
								if ($pro_activity_next[$ij]->iextpt_p_id == $projects[$i]->iextpp_id) {
									echo'<p class="mgr_view_content_event">'.$pro_activity_next[$ij]->iua_title.'</p>';
								}
							}
							for ($ij=0; $ij < count($pro_manage) ; $ij++) { 
								if ($pro_manage[$ij]->iextprour_pid == $projects[$i]->iextpp_id) {
									echo '<p class="mgr_view_content_person">Managed by '.$pro_manage[$ij]->ic_name.'</p>';
								}
							}
							echo '</div>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	<?php 
		if (isset($opportunity)) {
			if (count($opportunity) > 0) {
			}else{
				echo "$('.oppo_veiw').css('display','none');";
			}
		}

		if (isset($req)) {
			if (count($req) > 0) {
			}else{
				echo "$('.req_view').css('display','none');";
			}
		}

		if (isset($projects)) {
			if (count($projects) > 0) {
			}else{
				echo "$('.pro_view').css('display','none');";
			}
		}
	?>
</script>


