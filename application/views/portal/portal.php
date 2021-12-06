<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--3-col mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
			<h4>No. Of User's Registered</h4>
			<hr style="width: 80%;margin-left: 10%;">
			<h4><?php echo $no_usr; ?></h4>
		</div>
		<div class="mdl-cell mdl-cell--3-col mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
			<h4>Paid User's</h4>
			<hr style="width: 60%;margin-left: 20%;">
			<h4><?php echo $paid; ?></h4>
		</div>
		<div class="mdl-cell mdl-cell--3-col mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
			<h4>Unpaid User's</h4>
			<hr style="width: 60%;margin-left: 20%;">
			<h4><?php echo $unpaid; ?></h4>
		</div>
		<div class="mdl-cell mdl-cell--3-col mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
			<h4>Total amount collection</h4>
			<hr style="width: 80%;margin-left: 10%;">
			<h4 id="inr_amt"></h4>
		</div>
	</div>
	<div class="mdl-grid">
		<!-- <?php $user_details = $this->session->userdata()['admin_details'];
			    for ($i=0; $i < count($user_details); $i++) {
			    	if($user_details[$i]->ia_super == "true"){ ?> -->
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/customers'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Add, Edit Customers</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/modules'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Add, Edit Modules</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/modules_shortcuts'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Add Modules Shortcuts</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/allot_modules'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Allot Modules</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/system_domains'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">System Domains</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/create_user'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Create Users</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/explore_collection'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Explore Collection</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/pricing'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Pricing</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/purchase_history'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Purchase</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/user_scheme'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Scheme</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/scheme_payout'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Scheme Payout</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/module_activity_type'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Module activity type</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<a href="<?php echo base_url().'Portal/mobile_users'; ?>">
								<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Mobile Users</h2>
									</div>
								</div>
							</a>
						</div>

				<!-- <?php }else if ($user_details[$i]->ia_general == "true") { ?>
						<div class="mdl-cell mdl-cell--2-col"></div>
						<div class="mdl-cell mdl-cell--4-col">
							<a href="<?php echo base_url().'Portal/customers'; ?>">
								<div class="mdl-card mdl-shadow--4dp">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Add, Edit Customers</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--4-col">
							<a href="<?php echo base_url().'Portal/allot_modules'; ?>">
								<div class="mdl-card mdl-shadow--4dp">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Allot Modules</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--2-col"></div>
				<?php }else if ($user_details[$i]->ia_developer == "true") { ?>
						<div class="mdl-cell mdl-cell--2-col"></div>
						<div class="mdl-cell mdl-cell--4-col">
							<a href="<?php echo base_url().'Portal/modules'; ?>">
								<div class="mdl-card mdl-shadow--4dp">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">Add, Edit Modules</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--4-col">
							<a href="<?php echo base_url().'Portal/system_domains'; ?>">
								<div class="mdl-card mdl-shadow--4dp">
									<div class="mdl-card__title mdl-card--expand">
										<h2 class="mdl-card__title-text">System Domains</h2>
									</div>
								</div>
							</a>
						</div>
						<div class="mdl-cell mdl-cell--2-col"></div>
			<?php }
		} ?> -->
	</div>
</main>
</body>
</html>

<script type="text/javascript">
	<?php echo 'var amount = "'.$t_amt.'";'; ?>
	amount = Number(amount) / 100 ;
	document.getElementById('inr_amt').innerHTML = amount.toLocaleString('en-IN', {
	    maximumFractionDigits: 2,
	    style: 'currency',
	    currency: 'INR'
	});
</script>