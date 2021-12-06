<style>
		.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    padding: 10px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
    background-color: #ccc;
    border-radius: 10px;
}
.panel {
    /*padding: 0 18px;*/
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}

</style>
<main class="mdl-layout__content">
	<button class="accordion btn-lg" style="font-size: 1.5em; text-align: left;box-shadow: 0px 5px 0px #ccc;border-radius: 10px;"><i class="material-icons">filter_list</i> Filter Records</button>
    <div class="panel">
    	<div class="mdl-grid">
    		<div class="mdl-cell mdl-cell--2-col">
            	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" data-type="Date" id="f_date">
                    <label class="mdl-textfield__label" for="f_date">From Date</label>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--2-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" data-type="Date" id="t_date">
                    <label class="mdl-textfield__label" for="t_date">To Date</label>
                </div>   
            </div>
            <div class="mdl-cell mdl-cell--2-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                    <input class="mdl-textfield__input" type="text" id="f_title">
                    <label class="mdl-textfield__label" for="f_title">Title</label>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--2-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                    <input class="mdl-textfield__input" type="text" id="f_created">
                    <label class="mdl-textfield__label" for="f_created">Created By</label>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--2-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <select class="mdl-textfield__input" id="op_status">
                        <option value="null">Select status</option>
                        <?php 
                            if (isset($opp_status)) {
                                for($i=0; $i < count($opp_status); $i++) {
                                    echo '<option value="'.$opp_status[$i]->iextetop_status.'">'.$opp_status[$i]->iextetop_status.'</option>';
                                }    
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--2-col">
    			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="filters"><i class="material-icons">search</i> Filter</button>
    		</div>

            <div class="mdl-cell mdl-cell--2-col">
    			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="longest"><i class="material-icons">schedule</i> Longest Duration</button>
    		</div>
    		<div class="mdl-cell mdl-cell--2-col">
    			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="likelihood"><i class="material-icons">thumb_up</i> Most Likelihood</button>
    		</div>
    		<div class="mdl-cell mdl-cell--2-col">
    			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="recent"><i class="material-icons">recent_actors</i> Recent</button>
    		</div>
    		
    	</div>
	</div>
	<div class="mdl-grid" style="width: 100%;">	
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
			<thead>
				<th class="mdl-data-table__cell--non-numeric">Title</th>
				<th class="mdl-data-table__cell--non-numeric">Date</th>
				<th class="mdl-data-table__cell--non-numeric">Status</th>
			</thead>
			<tbody id="display_opportunity">
				
			</tbody>
		</table>
				
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
</div>
</body>
<script type="text/javascript">
	var oppo_arr = [];
	<?php
			if (isset($opportunity)) {
				for ($i=0; $i <count($opportunity) ; $i++) { 
					echo "oppo_arr.push({'id':".$opportunity[$i]->iextetop_id.", 'title' : '".$opportunity[$i]->iextetop_title."','date': '".$opportunity[$i]->iextetop_created."', 'status' : '".$opportunity[$i]->iextetop_status."' });";
				}
			}
	?>

	$(document).ready(function() {
		display_opportunity();

		$( "#f_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});
        $( "#t_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});

		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			    if (panel.style.maxHeight){
			      panel.style.maxHeight = null;
			    } else {
			      panel.style.maxHeight = panel.scrollHeight + "px";
			    } 
			});
		}

		$("#add").click(function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url()."Sales/opportunity_details/".$code."/view"; ?>";
		});

		$("#display_opportunity").on('click','.edit',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = "<?php echo base_url()."Sales/opportunity_details/".$code."/save/";?>"+id;
		});

		$('#recent').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/opportunity_filters/recent/".$code; ?>'
            ,function(data, status, xhr) {
                var a=JSON.parse(data);
                oppo_arr = [];

                if (a.filters.length > 0) {
                	for (var i = 0; i < a.filters.length; i++) {
                		oppo_arr.push({'id' : a.filters[i].iextetop_id, 'title' : a.filters[i].iextetop_title, 'date' : a.filters[i].iextetop_created, 'status' : a.filters[i].iextetop_status});
                	}
                }
                display_opportunity();
            });
		});

		$('#likelihood').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/opportunity_filters/likelihood/".$code; ?>'
            ,function(data, status, xhr) {
                var a=JSON.parse(data);
                oppo_arr = [];

                if (a.filters.length > 0) {
                	for (var i = 0; i < a.filters.length; i++) {
                		oppo_arr.push({'id' : a.filters[i].iextetop_id, 'title' : a.filters[i].iextetop_title, 'date' : a.filters[i].iextetop_created, 'status' : a.filters[i].iextetop_status});
                	}
                }
                display_opportunity();
            });
		});

		$('#longest').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/opportunity_filters/longest/".$code; ?>'
            ,function(data, status, xhr) {
                var a=JSON.parse(data);
                oppo_arr = [];

                if (a.filters.length > 0) {
                	for (var i = 0; i < a.filters.length; i++) {
                		oppo_arr.push({'id' : a.filters[i].iextetop_id, 'title' : a.filters[i].iextetop_title, 'date' : a.filters[i].iextetop_created, 'status' : a.filters[i].iextetop_status});
                	}
                }
                display_opportunity();
            });
		});

		$('#filters').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Sales/opportunity_filters/null/".$code; ?>', {
                'f_title' : $('#f_title').val(),
                'f_date' : $('#f_date').val(),
                't_date' : $('#t_date').val(),
                'f_created' : $('#f_created').val(),
                'opp_status' : $('#op_status').val()
            }, function(data, status, xhr) {
                var a=JSON.parse(data);
                oppo_arr = [];

                if (a.filters.length > 0) {
                	for (var i = 0; i < a.filters.length; i++) {
                		oppo_arr.push({'id' : a.filters[i].iextetop_id, 'title' : a.filters[i].iextetop_title, 'date' : a.filters[i].iextetop_created, 'status' : a.filters[i].iextetop_status});
                	}
                }
                display_opportunity();
            });
        });

        var a_flg = 'false';

        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

         $('#submit').click(function(e) {
            e.preventDefault();
            if($('#search_modal').css('display') != 'none'){
                var note = $('#notes_text').html();
                $('#ATags > li').each(function(index) {
                    var tmpstr = $(this).text();
                    var len = tmpstr.length - 1;
                    if(len > 0) {
                        tmpstr = tmpstr.substring(0, len);
                        activity_tags.push(tmpstr);
                    }
                });
                var date = $('.s_date').val();
                var e_date = $('.e_date').val();
                $.post('<?php echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
                    'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
                }, function(data, status, xhr) {
                        location.reload();
                }, 'text');
            }
        });
        // function get_animate(path){
        //     $('#redirect_modal').animate({
        //         opacity: '1',
        //         height: '100vh',
        //         width: '100%',
        //     }, 300, function() { window.location = path; });
        // }

		function display_opportunity() {
			var out = '';
			var path = '';
			if (oppo_arr.length > 0) {
				for (var i = 0; i < oppo_arr.length; i++) {
					out +='<tr class="tbl_view edit" id='+oppo_arr[i].id+'><td class="mdl-data-table__cell--non-numeric">'+oppo_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+oppo_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+oppo_arr[i].status+'</td></tr>';
				}		
			}
			$('#display_opportunity').empty();	
			$('#display_opportunity').append(out);
		}

	});
</script>