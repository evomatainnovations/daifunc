<style type="text/css">
    .general_table {
        width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #ccc;
        border-collapse: collapse;
        border-radius: 10px;
    }

    @media only screen and (max-width: 760px) {
        .general_table {
            display: block;
            overflow: auto;
        }
    }

    .general_table > thead > tr {
        border: 1px solid #ccc;
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
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<table class="general_table">
				<thead>
					<th>Sr. no.</th>
					<th>Module Name</th>
					<th>Alias Name</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<button class="mdl-button mdl-button--fab lower-button mdl-button--colored submit_mod"><i class="material-icons">done</i></button>
	</div>
</main>
<script type="text/javascript">
	var u_mod = [];
	<?php
		for ($i=0; $i < count($module) ; $i++) { 
			echo "u_mod.push({'mid' : '".$module[$i]->mid."' , 'mname' : '".$module[$i]->mname."' , 'alias' : '".$module[$i]->m_alias."' });";
		}
	?>
	$(document).ready(function() {
		display_mod();

		$('.submit_mod').click(function (e) {
			e.preventDefault();
			for (var i = 0; i < u_mod.length; i++) {
				var m_alias = $('.'+u_mod[i].mid).val();
				u_mod[i].alias = m_alias;
			}
			$.post('<?php echo base_url()."Account/update_mod_name/".$code; ?>', {
				'mod_arr' : u_mod
			}, function(data, status, xhr) {
	    		window.location = "<?php echo base_url().'Account/module_rename/'.$code; ?>";
			}, 'text');
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

		function display_mod() {
			var out = '';
			var sr = 1;
			for (var i = 0; i < u_mod.length; i++) {
				out += '<tr>';
				out += '<td>'+sr+'</td><td>'+u_mod[i].mname+'</td><td>';
				if (u_mod[i].alias == '') {
					out += '<input class="mdl-textfield__input '+u_mod[i].mid+' " type="text" id="ma_name" name="ma_name" placeholder="Enter alias name" style="outline:none;"></td>';
				}else{
					out += '<input class="mdl-textfield__input '+u_mod[i].mid+'" type="text" id="ma_name" name="ma_name" value="'+u_mod[i].alias+'" style="outline:none;"></td>';
				}
				out += '</tr>';
				sr++;
			}

			$('.general_table > tbody').empty();
			$('.general_table > tbody').append(out);
		}
	});
</script>