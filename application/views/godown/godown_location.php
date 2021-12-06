<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<style type="text/css">
    .jstree-contextmenu {
        z-index: 1 !important;
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col" style="text-align: left;">
			<button class="mdl-button mdl-button--colored add_loc_cat"><i class="material-icons">add</i>Add Location</button>
		</div>
		<div class="mdl-cell mdl-cell--12-col gd_cat_temp" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 80vh;overflow-y: scroll;width: 100%;">
		</div>
		<button class="mdl-button lower-button mdl-button--fab mdl-button--colored save_gd"><i class="material-icons">done</i></button>
	</div>
</main>
<div class="modal fade" id="add_location_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col loc_name"></div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="add_location">
                            <label class="mdl-textfield__label" for="add_location">Location barcode</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal" id="save_loc">Add</button>
                <button type="button" class="mdl-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
    var arrayCollection = [];
    var id_flg = 0;
    var gd_temp_arr = [];
    var edit_temp_flg = 0;
    var loc_arr = [];
    var sel_id = 0;
    <?php
        if (isset($gd_temp)) {
            for ($i=0; $i < count($gd_temp) ; $i++) { 
                echo "arrayCollection.push({'id' : '".$gd_temp[$i]->id."','parent' : '".$gd_temp[$i]->parent."','text' : '".$gd_temp[$i]->text."'});";
                echo "loc_arr.push({'id' : '".$gd_temp[$i]->id."', 'loc_barcode' : '".$gd_temp[$i]->barcode."'});";
            }
        }
    ?>
    $(document).ready( function() {
        var snackbarContainer = document.querySelector('#demo-toast-example');
        if (arrayCollection.length > 0 ) {
            add_location_display();
        }
        $('.add_loc_cat').click(function (e){
            e.preventDefault();
            var arr= [];
            if (arrayCollection.length > 0) {
                arrayCollection = [];
                arr = $('.gd_cat_list').jstree(true).get_json('#', {flat:true});
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
            add_location_display();
        });

        function add_location_display(){
            var out = '';
            out += '<div class="mdl-grid gd_cat_list"></div>';
            $('.gd_cat_temp').empty();
            $('.gd_cat_temp').append(out);
            $(".gd_cat_list").jstree({"core": {"check_callback": true,"data": arrayCollection},"plugins": ["json_data","contextmenu","dnd"]});

            var tree = $(".gd_cat_list");
            tree.bind("loaded.jstree", function (event, data) {
                tree.jstree("open_all");
            });
        }

        $('.save_gd').click(function (e) {
            e.preventDefault();
            var t_name = $('#title_name').val();
            arrayCollection = [];
            arr = $('.gd_cat_list').jstree(true).get_json('#', {flat:true});
            for (var i = 0; i < arr.length; i++) {
                arrayCollection.push({"id": arr[i].id, "parent": arr[i].parent, "text": arr[i].text , "barcode" : ''});
            }

            for (var i = 0; i < arrayCollection.length; i++) {
                for (var ij = 0; ij < loc_arr.length; ij++) {
                    if (arrayCollection[i].id == loc_arr[ij].id) {
                        arrayCollection[i].barcode = loc_arr[ij].loc_barcode;
                    }
                }
            }
            var path = '<?php echo base_url()."Godown/gd_template_save/".$code."/";?>';
            $.post(path,{
                'arr' : arrayCollection,
                'title' : t_name
            }, function(data, status, xhr) {
                window.location = '<?php echo base_url()."Godown/home/0/".$code."/";?>';
            });
        });

        $('.gd_cat_temp').on('click','.gd_cat_list' ,function (e, data) {
            sel_id = $(this).jstree('get_selected');
            var arr1 = $('.gd_cat_list').jstree(true).get_json('#', {flat:true});
            for (var i = 0; i < arr1.length; i++) {
                if (sel_id[0] == arr1[i].id) {
                    $('.loc_name').empty();
                    $('.loc_name').append('<h3>'+arr1[i].text+'</h2>');
                    break;
                }
            }
            $('#add_location').val('');
            for (var ij = 0; ij < loc_arr.length; ij++) {
                if (loc_arr[ij].id == sel_id[0]) {
                    $('#add_location').val(loc_arr[ij].loc_barcode);
                    break;
                }
            }
            $('#add_location_modal').modal('show');
        });

        $('#add_location_modal').on('click','#save_loc',function(e){
            e.preventDefault();
            save_location();
            var data = {message: 'Barcode save !'};
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        });

        $('#add_location_modal').on('keyup','#add_location',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                save_location();
                $('#add_location_modal').modal('hide');
                var data = {message: 'Barcode save !'};
                snackbarContainer.MaterialSnackbar.showSnackbar(data);
            }
        });

        function save_location(){
            var loc = $('#add_location').val();
            var l_flg = 0;
            if (loc_arr.length > 0 ) {
                for (var i = 0; i < loc_arr.length; i++) {
                    if(loc_arr[i].id == sel_id[0]){
                        loc_arr[i].loc_barcode = loc;
                        l_flg++;
                    }
                }
            }
            if (l_flg == 0 ) {
                loc_arr.push({'id' : sel_id[0], 'loc_barcode': loc});
            }
            $('#add_location').val('');
        }
    });
</script>