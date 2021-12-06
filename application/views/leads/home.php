
<script src="<?php echo base_url().'assets/js/bootstrap-3.3.7.min.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap-3.3.7.min.css'; ?>">
<script src="<?php echo base_url().'assets/js/Chart.bundle.min.js'; ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/smiley-styles.css'; ?>">
<script src='<?php echo base_url().'assets/js/jquery.keyframes.min.js'; ?>'></script>

<link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap-4.1.0.min.css'; ?>">
<script src="<?php echo base_url().'assets/js/bootstrap-4.1.0.min.js'; ?>"></script>
<style>
a {
    color: #fff;
    text-decoration: none;
}

a:hover {
    color: #fff;
    text-decoration: none;
}
.status{
	overflow-x: auto;
	display: -webkit-box;
}
</style>
<main class="mdl-layout__content" style="z-index:3;">
	<div class="mdl-grid">
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect" >
			<div class="mdl-tabs__tab-bar">
			  <a href="#lead-panel" class="mdl-tabs__tab is-active" style="color: #000;">Lead</a>
			  <a href="#status-panel" class="mdl-tabs__tab" style="color: #000;">Status</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="lead-panel">
				<div class="mdl-grid" id="lead_list"></div>
			</div>
			<div class="mdl-tabs__panel" id="status-panel">
				<div class="mdl-grid status" id="cat_activity"></div>
			</div>
		</div>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
        <i class="material-icons">add</i>
    </button>
</main>
<script type="text/javascript">
	var lead_arr = [], activity_arr = [], cat_arr = [],user_arr = []; var owner = '';var id_arr = [];
	<?php
		if (isset($lead)) {
			for ($i=0; $i <count($lead) ; $i++) { 
				echo "lead_arr.push({'id' : ".$lead[$i]->ic_id.", 'file' : '".$lead[$i]->icp_path."', 'name' : '".$lead[$i]->ic_name."'});";
			}
		}

		if (isset($activity_cat)) {
			for ($i=0; $i <count($activity_cat) ; $i++) { 
				echo "cat_arr.push({'id':".$i.",'cat': '".$activity_cat[$i]->iua_categorise."'});";
			}
		}

		if (isset($cat_users)) {
			for ($i=0; $i <count($cat_users) ; $i++) { 
				echo "user_arr.push({'id':".$i.",'cat': '".$cat_users[$i]->iua_categorise."','cid' : ".$cat_users[$i]->ic_id.",'name' : '".$cat_users[$i]->ic_name."','date':'".$cat_users[$i]->iua_date."'});";
			}
		}
	?>
	owner = <?php echo "$oid"; ?>;
	$(document).ready(function() {
		load_lead();load_activity();
		$('#add').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Sales/leads_add'; ?>";
        });

        $('#cat_activity').on('click','.users',function(e){
        	e.preventDefault();
        	var id = $(this).prop('id');
        	window.location = "<?php echo base_url().'Sales/lead_details/'; ?>"+id;
        });

       	function load_lead(){
       		var out = '';
       		for (var i = 0; i < lead_arr.length; i++) {
       			out += '<div class="mdl-cell mdl-cell--2-col">';
       			r_path = "<?php echo base_url().'Sales/lead_details/';?>"+lead_arr[i].id;
				out += '<a href="'+r_path+'"><div class="mdl-card mdl-shadow--4dp">';
				if(lead_arr[i].file) {
					f_path = "<?php echo base_url().'assets/upload/';?>"+owner+'/'+lead_arr[i].file;
					out += '<div class="mdl-card__title mdl-card--expand" style="height:180px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url('+f_path+');background-size: 100%;">';	
				} else {
					out += '<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
				}
				out += '<h2 class="mdl-card__title-text">'+lead_arr[i].name+'</h2>';
				out += '</div>';
				out += '</div></a>';
				out += '</div>';
       		}
       		$('#lead_list').empty();
       		$('#lead_list').append(out);
       	}

       	function load_activity() {
       		var out = '';
       		for (var i = 0; i < cat_arr.length; i++) {
       			out += '<div class="mdl-cell mdl-cell--4-col"><div class="mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+cat_arr[i].cat+'</h2></div><div class="mdl-card__supporting-text">';
       			for (var j = 0; j < user_arr.length; j++) {
       				if(user_arr[j].cat == cat_arr[i].cat){
       					if (id_arr.length <= 0) {
       						id_arr.push({'id' : user_arr[j].cid});
       						out += '<button class="mdl-button users" style="width:100%;" id="'+user_arr[j].cid+'"><span style="float:left;">'+user_arr[j].name+'</span><span style="float:right;">'+user_arr[j].date+'</span></button>';
       					}else{
       						for (var k = 0; k < id_arr.length; k++) {
       							if (id_arr[k].id != user_arr[j].cid) {
       								out += '<button class="mdl-button users" style="width:100%;" id="'+user_arr[j].cid+'"><span style="float:left;">'+user_arr[j].name+'</span><span style="float:right;">'+user_arr[j].date+'</span></button>';
       							}
       						}
       					}
       				}
       			}id_arr = [];
       			out +='</div></div></div>';
       		}
       		$('#cat_activity').empty();
       		$('#cat_activity').append(out);
       	}
	});	
</script>