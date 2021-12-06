<style type="text/css">
	input:focus{
	    outline: none;
	}
</style>
<main>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
				<input type="text" id="tax_g_name" name="tax_g_name" class="mdl-textfield__input" value="<?php if(isset($g_name)) { echo $g_name; } ?>" placeholder="Enter tax group name" style="font-size: 3em;outline: none;">
		</div>
		<div class="mdl-cell mdl-cell--6-col"></div>
		<div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet taxes" style="background-color: #fff;border-radius: 10px;">
			<div style="text-align: center;margin-top: 5%;">
				<button class="mdl-button mdl-button--colored add_tax">Add Taxes</button>
				<?php
					if (isset($g_name)) {
						echo '<button class="mdl-button mdl-button--colored delete_tax"><i class="material-icons">delete</i> Delete</button>';
					}
				?>
			</div>
			<div class="mdl-grid tax_list"></div>
		</div>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit_tax">
		<i class="material-icons">done</i>
	</button>
</main>
</div>
</body>
<script>
	var taxes = [];
	var t_flg = 0;
	<?php
		if (isset($taxes)) {
			for ($i=0; $i <count($taxes) ; $i++) {
				$id = $i+1;
				echo "taxes.push({'id':'".$id."','name' : '".$taxes[$i]->itx_name."','per' : '".$taxes[$i]->itx_percent."'});";
			}
		}
	?>
	$(document).ready(function() {
		$('#tax_g_name').focus();
		display_taxes();
		$('.add_tax').click(function (e) {
			e.preventDefault();
			$('.taxes').css('display','block');
			var a = '';
			t_flg = t_flg + 1;
			a+='<div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield"><input class="mdl-textfield__input" type="text" id="tname'+t_flg+'" placeholder="Tax Name"></div></div>';
			a+='<div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield"><input class="mdl-textfield__input tax_precent" type="text" id="tamt'+t_flg+'" placeholder="Tax in percent"></div></div>';
			a+='<div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-button--colored mdl-button--icons sub_tax_delete" id="'+t_flg+'"><i class="material-icons">delete</i> delete</button></div>';
			$('.tax_list').append(a);
		});

		$('.tax_list').on('click','.sub_tax_delete',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			taxes = [];
			for (var j = 1; j <= t_flg; j++) {
				taxes.push({id : j , name : $('#tname'+j).val() , per : $('#tamt'+j).val()});
			}
			for (var i = 0; i < taxes.length; i++) {
				if(taxes[i].id == id){
					taxes.splice(i, 1);
					break;
				}
			}
			t_flg = 0;
			display_taxes();
		});

		$('.delete_tax').click(function (e) {
			e.preventDefault();
			window.location = '<?php if (isset($taxes)) { echo base_url()."Enterprise/delete_tax/".$tid."/".$code; } ?>';
		});

		$('#submit_tax').click(function(e) {
			e.preventDefault();
			var tax_arr = [];
			var tax_group = $('#tax_g_name').val();
			for (var j = 1; j <= t_flg; j++) {
				tax_arr.push({id : j , t_name : $('#tname'+j).val() , t_amt : $('#tamt'+j).val()});
			}
			$.post('<?php if (isset($taxes)) { echo base_url()."Enterprise/update_tax/".$tid."/".$code; } else { echo base_url()."Enterprise/save_tax/".$code; } ?>', {
				'name' : tax_group,
				'taxes' : tax_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/tax/0/".$code; ?>';
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

		function display_taxes() {
			var a = '';
			$('.taxes').css('display','block');
			for (var i = 0; i < taxes.length; i++) {
				t_flg = t_flg + 1;
				a+='<div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield"><input class="mdl-textfield__input" type="text" id="tname'+t_flg+'" placeholder="Tax Name" value="'+taxes[i].name+'"></div></div><div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield"><input class="mdl-textfield__input tax_precent" type="text" id="tamt'+t_flg+'" placeholder="Tax in percent" value="'+taxes[i].per+'"></div></div><div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-button--colored mdl-button--icons sub_tax_delete" id="'+t_flg+'"><i class="material-icons">delete</i> delete</button></div>';
			}
			$('.tax_list').empty();
			$('.tax_list').append(a);
		}
	});
</script>
</html>