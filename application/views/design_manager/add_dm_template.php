<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
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
		background-color: #666;
		color: #fff;
	}

	.general_table > tbody {
		border: 1px solid #ccc;
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

    .jstree-contextmenu {
        z-index: 1 !important;
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<input type="text" id="title_name" name="title_name" class="mdl-textfield__input" placeholder="Enter Title" style="font-size: 2.5em;outline: none;">
					<div style="display: flex;">
						<button class="mdl-button mdl-button--colored delete_temp" style="display: none;"><i class="material-icons">delete</i>delete</button>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<button class="mdl-button mdl-button--colored add_dm_cat"><i class="material-icons">add</i>Add Category</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col dm_cat_temp" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 60vh;overflow-y: scroll;width: 100%;">
				</div>
				<button class="mdl-button lower-button mdl-button--fab mdl-button--colored save_dm"><i class="material-icons">done</i></button>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col dm_template_list" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; margin-top: 20px;margin-bottom: 20px;"></div>
	</div>
</main>
<script>
    var arrayCollection = [];
    var id_flg = 0;
    var dm_temp_arr = [];
    var edit_temp_flg = 0;
    <?php
        for ($i=0; $i < count($dm_temp_list) ; $i++) { 
            echo "dm_temp_arr.push({'id' : '".$dm_temp_list[$i]->iextetdmt_id."' , 'title' : '".$dm_temp_list[$i]->iextetdmt_title."'});";
        }
    ?>
    $(document).ready( function() {
        display_template_list();

        $('.add_dm_cat').click(function (e){
            e.preventDefault();
            var arr= [];
            if (arrayCollection.length > 0) {
                arrayCollection = [];
                arr = $('.dm_cat_list').jstree(true).get_json('#', {flat:true});
                if (arr.length > 0 ) {
                    id_flg = 0;
                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i].parent == '#') {
                            id_flg++;
                        }
                        arrayCollection.push({"id": arr[i].id, "parent": arr[i].parent, "text": arr[i].text});
                    }
                }
            }
            id_flg++;
            arrayCollection.push({"id": id_flg, "parent": "#", "text": 'Root'});
            add_category_display();
        });

        function add_category_display(){
            var out = '';
            out += '<div class="mdl-grid dm_cat_list"></div>';
            $('.dm_cat_temp').empty();
            $('.dm_cat_temp').append(out);
            $(".dm_cat_list").jstree({"core": {"check_callback": true,"data": arrayCollection},"plugins": ["json_data","contextmenu","dnd"]});
        }

        $('.save_dm').click(function (e) {
            e.preventDefault();
            var t_name = $('#title_name').val();
            arrayCollection = [];
            arr = $('.dm_cat_list').jstree(true).get_json('#', {flat:true});
            for (var i = 0; i < arr.length; i++) {
                arrayCollection.push({"id": arr[i].id, "parent": arr[i].parent, "text": arr[i].text});
            }

            if (edit_temp_flg == 0) {
                var path = '<?php echo base_url()."Design_manager/dm_template_save/".$code."/";?>';
            }else{
                var path = '<?php echo base_url()."Design_manager/dm_template_update/".$code."/";?>'+edit_temp_flg;
            }
            $.post(path,{
                'arr' : arrayCollection,
                'title' : t_name
            }, function(data, status, xhr) {
                window.location = '<?php echo base_url()."Design_manager/home/0/".$code."/";?>';
            });
        });

        $('.dm_template_list').on('click','.dm_table',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $.post('<?php echo base_url()."Design_manager/get_dm_template/".$code."/";?>'+id
            ,function(data, status, xhr) {
                var a = JSON.parse(data);
                edit_temp_flg = id;
                $('.delete_temp').css('display','block');
                arrayCollection = [];
                $('#title_name').val(a.title);
                for (var i = 0; i < a.dm_temp.length; i++) {
                    arrayCollection.push({"id": a.dm_temp[i].id, "parent": a.dm_temp[i].parent, "text": a.dm_temp[i].text});
                }
                add_category_display();
            });
        });

        $('.delete_temp').click(function (e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Design_manager/dm_delete_temp/".$code."/";?>'+edit_temp_flg
            ,function(data, status, xhr) {
                window.location = '<?php echo base_url()."Design_manager/home/0/".$code."/";?>';
            });
        });

        function display_template_list(){
            var out = '';
            out += '<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;"><thead><tr><th style="text-align:left;">Sr. No.</th><th style="text-align:left;">Title</th></tr></thead><tbody style="overflow:auto;">';
            for (var ij = 0; ij < dm_temp_arr.length; ij++) {
                srno = ij + 1;
                out += '<tr class="dm_table" id="'+dm_temp_arr[ij].id+'">';
                out += '<td style="text-align:left;">'+srno+'</td>';
                out += '<td style="text-align:left;">'+dm_temp_arr[ij].title+'</td>';
                out += '</tr>';
            }
            out += '</tbody></table>';

            $('.dm_template_list').empty();
            $('.dm_template_list').append(out);
        }
    });
</script>

