<style>
.mdl-card {
	background: white;  
	width: 300px;
	height: 400px;
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<?php for ($i=0; $i < count($mod_temp); $i++) { 
			$flg = 0;
			for ($j=0; $j < count($template); $j++) { 
				if($mod_temp[$i]->itemp_module==$template[$j]->itemp_module) {
					$flg=1;
					break;
				} else {

				}
			}
			if($flg == 1) { 
				echo '<div class="mdl-cell mdl-cell--4-col" id="select">
						<div class="mdl-card mdl-shadow--4dp">
							<div class="mdl-card__title">
				    			<h2 class="mdl-card__title-text">Select '.$mod_temp[$i]->im_name.' Template</h2>
							</div>
							<div class="mdl-card__supporting-text">
								<div class="mdl-grid">
									<div class="mdl-cell mdl-cell--6-col">
										<h3>'.$template[$j]->itemp_title.'</h3>
									</div>
									<div class="mdl-cell mdl-cell--6-col">
										<a href="'.base_url().'Account/template_list/'.$mod_temp[$i]->im_id.'"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"><i class="material-icons">settings</i> Choose</button></a>
									</div>
								</div>
							</div>
						</div>
					</div>';
			} else { 
				echo '<div class="mdl-cell mdl-cell--4-col" id="choose">
						<div class="mdl-card mdl-shadow--4dp">
							<div class="mdl-card__title">
				    			<h2 class="mdl-card__title-text">Select '.$mod_temp[$i]->im_name.'Template</h2>
							</div>
							<div class="mdl-card__supporting-text">
								<div class="mdl-grid">
									<div class="mdl-cell mdl-cell--6-col">
										<h3>Please choose template</h3>
									</div>
									<div class="mdl-cell mdl-cell--6-col">
										<a href="'.base_url().'Account/template_list/'.$mod_temp[$i]->im_id.'"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"><i class="material-icons">settings</i> Choose</button></a>
									</div>
								</div>
							</div>
						</div>
					</div>';
			}
	 	} ?>
</div>
</main>
</body>
</html>