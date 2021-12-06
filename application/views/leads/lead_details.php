<style type="text/css">
	.modal-content{
        border-radius: 0px;
        box-shadow: 1px 5px 77px #000;
    }

    .modal-header{
        padding: 30px;
        padding-bottom: 0px;
    }

    .modal{
        padding-left: 0px;
    }

    .ui-widget {
        width: inherit;
        z-index: 30000;
    }
</style>
<main class="mdl-layout__content" style="z-index:3;">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col">
			<h2><?php echo $lead[0]->ic_name; ?></h2>
		</div>
		<div class="mdl-cell mdl-cell--6-col" style="text-align: right;">
			<button class="mdl-button mdl-button-raised" id="lead_forward"><i class="material-icons">forward</i></button>
			<button class="mdl-button mdl-button-raised" id="lead_edit"><i class="material-icons">edit</i></button>
		</div>
	</div>
	<div class="mdl-grid">
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
			<thead>
				<th class="mdl-data-table__cell--non-numeric" style="text-align: left;">Activity</th>
				<th class="mdl-data-table__cell--non-numeric" style="text-align: center;">Date</th>
				<th class="mdl-data-table__cell--non-numeric" style="text-align: right;">Categories</th>
			</thead>
			<tbody id="activity_list">
				
			</tbody>
		</table>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
        <i class="material-icons">add</i>
    </button>
</main>
<div class="modal" id="add_activity" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="exampleModalLongTitle"><?php if(isset($edit_activity)){echo "Edit Activity";}else{ echo "Add Activity";} ?></h1>
            <button type="button" class="mdl-button close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="add_activity_body">
            <div class="mdl-grid" id="activity_body">
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="a_title" value="<?php if(isset($edit_activity)) { echo $edit_activity[0]->iua_title; } ?>">
                        <label class="mdl-textfield__label" for="a_title">Title</label>
                    <!-- <button onclick="getLocation()">Try It</button> -->
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="a_cat" value="<?php if(isset($edit_activity)) { echo $edit_activity[0]->iua_categorise; } ?>">
                        <label class="mdl-textfield__label" for="a_cat">Category</label>
                    </div>
                    <div class="mdl-grid">
                        <?php
                            echo '<div class="mdl-cell mdl-cell--6-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><select class="mdl-textfield__input" id="a_module" style="width=100%"><option value="0">Module</option>';
                            for ($i=0; $i < count($mod) ; $i++) {
                                if($mod[$i]->status != "suspend" && $mod[$i]->status != "terminate") {
                                    if (isset($edit_activity)) {
                                        if ($edit_activity[0]->iua_m_shortcuts == $mod[$i]->mid) {
                                            // echo $shortcut;
                                           echo '<option value="'.$mod[$i]->mid.'" selected>'.$mod[$i]->mname.'</option>';
                                        }else{
                                            echo '<option value="'.$mod[$i]->mid.'">'.$mod[$i]->mname.'</option>';   
                                        }
                                    }else{
                                        echo '<option value="'.$mod[$i]->mid.'">'.$mod[$i]->mname.'</option>';
                                    }
                                }
                            }
                            echo '</select><label class="mdl-textfield__label" for="a_module">Select Module</label></div></div>';  
                        ?> 
                        <div class="mdl-cell mdl-cell--6-col" id="shortcut_icon">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <select class="mdl-textfield__input" id="a_function" name="a_function">
                                    <option value="0" selected>Select</option>
                                    
                                </select>
                                <label class="mdl-textfield__label" for="a_function">select shortcut</label>
                            </div>    
                        </div> 
                    </div>    
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--6-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" data-type="date" id="a_date" value="<?php if(isset($edit_activity)) { echo $edit_activity[0]->iua_date; }else{echo date('Y-m-d H:m');}?>">
                                <label class="mdl-textfield__label" for="a_date">Date</label>
                            </div>        
                        </div>
                        <div class="mdl-cell mdl-cell--6-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="a_place" value="<?php if(isset($edit_activity)) { echo $edit_activity[0]->iua_place; } ?>">
                                <label class="mdl-textfield__label" for="a_place">Place</label>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-grid">
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="add_person" style="margin-right: 10px;">Person</button>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="add_todo" style="margin-right: 10px;">Todo</button>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="add_notes" style="margin-right: 10px;">Notes</button>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="add_tags" style="margin-right: 10px;">Tags</button>
                    </div>
                    <div class="mdl-grid">    
                        <div id="toggle_person" style="display: none;">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="a_person">
                                <label class="mdl-textfield__label" for="a_person">Tag a persons</label>
                            </div>
                            <button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent" id="person_button"><i class="material-icons">add</i></button>
                            <div class="mdl-cell mdl-cell--12-col">
                                <table id="person_list">
                                    <?php 
                                    	if (isset($edit_person)) {
                                            for ($i=0; $i < count($edit_person); $i++) {
                                                echo '<tr style="width=100%"><td>'.$edit_person[$i]->ic_name.'</td><td><button class="mdl-button mdl-js-button delete_person" id="'.$i.'"><i class="material-icons">delete</i></button></td></tr>'; 
                                            }        
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>    
                    </div>
                    <div class="mdl-grid">
                        <div id="toggle_todo" style="display: none;">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="todo_text">
                                <label class="mdl-textfield__label" for="a_to_do">Add Item</label>
                            </div>
                            <button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent" id="todo_button"><i class="material-icons">add</i></button>
                            <table id="todo_list" style="width:100%">
                               
                            </table>
                        </div>
                    </div>
                    <div class="mdl-grid">
                        <div id="toggle_notes" style="display: none; width: 100%">
                            <div>
                                <tr>
                                   <button class="mdl-button mdl-js-button" id="font_button"><i class="material-icons">font_download</i></button>|
                                   <button class="mdl-button mdl-js-button" id="bold_button"><i class="material-icons">format_bold</i></button>
                                   <button class="mdl-button mdl-js-button" id="italic_button"><i class="material-icons">format_italic</i></button>|
                                    <!-- <button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent" id="todo_button"><i class="material-icons">link</i></button> -->
                                   <!-- <button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent" id="todo_button"><i class="material-icons">add_photo_alternate</i></button> -->
                                   <button class="mdl-button mdl-js-button" id="table_button"><i class="material-icons">table_chart</i></button>
                                </tr>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield" style="width: 100%;">
                                <div contenteditable="true" id="notes_text" class="mdl-textfield__input">
                                    <?php
                                        if (isset($note)) {
                                            if ($note != null && $note != " ") {
                                                echo $note;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>       
                        </div>
                    </div>
                    <div class="mdl-grid">
                        <div id="toggle_tags" style="display: none;">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <ul id="ATags" class="mdl-textfield__input">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if (isset($edit_activity)) {
                            for ($i=0; $i < count($edit_activity); $i++) {
                                echo '<div class="mdl-grid"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored delete_activity" id="'.$edit_activity[$i]->iua_id.'" style="width: 100%;"><i class="material-icons">delete</i></button></div>'; 
                            }          
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="mdl-button mdl-button-done mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="submit"><i class="material-icons">done</i> Save</button>
            <button type="button" class="mdl-button mdl-js-button mdl-button--" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var tag_data = [],options = [],person_array=[],todo_array=[],m_s=[],activity_tags=[],activity_arr=[];
	<?php
        for ($i=0; $i < count($tags) ; $i++) { 
            echo "tag_data.push('".$tags[$i]->it_value."');";
        }
        for ($i=0; $i <count($user_list) ; $i++) {
            echo "options.push('".$user_list[$i]->ic_name."');";
        }
        if (isset($lead)) {
        	echo "person_array.push('".$lead[0]->ic_name."');";
        }
        for ($i=0; $i <count($m_shortcuts) ; $i++) {
            echo "m_s.push({'id' : '".$m_shortcuts[$i]->ims_id."','f_id': '".$m_shortcuts[$i]->ims_function."','f_name' : '".$m_shortcuts[$i]->ifun_name."','domain': '".$m_shortcuts[$i]->idom_name."','mid' : '".$m_shortcuts[$i]->ims_m_id."','icon' : '".$m_shortcuts[$i]->ims_icon."'});";
        }
        if (isset($activity)) {
			for ($i=0; $i <count($activity) ; $i++) { 
				echo "activity_arr.push({'id' : ".$activity[$i]->iua_id.", 'title' : '".$activity[$i]->iua_title."', 'date' : '".$activity[$i]->iua_date."', 'cat' : '".$activity[$i]->iua_categorise."'});";
			}
		}
        if (isset($edit_activity)) {
            echo "$('#add_activity').modal('show');";
        }
    ?>
	$(document).ready(function() {
		append_person();
		load_activity();
		$( "#a_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm'});

		$('#add').click(function(){
			$('#add_activity').modal('show');
		});

		$('#add_person').click(function(e) {
            e.preventDefault();
            if ($('#toggle_person').css('display') == "none") {
                $('#toggle_person').css('display','block');
                $('#toggle_todo').css('display','none');
                $('#toggle_tags').css('display','none');
                $('#toggle_notes').css('display','none');
            } else {
                $('#toggle_person').css('display','none');
            }
        });

        $('#add_todo').click(function(e) {
            e.preventDefault();
            if ($('#toggle_todo').css('display') == "none") {
                $('#toggle_todo').css('display','block');
                $('#toggle_person').css('display','none');
                $('#toggle_tags').css('display','none');
                $('#toggle_notes').css('display','none');
            } else {
                $('#toggle_todo').css('display','none');
            }
        });
        
        $('#add_notes').click(function(e) {
            e.preventDefault();
            if ($('#toggle_notes').css('display') == "none") {
                $('#toggle_notes').css('display','block');
                $('#toggle_todo').css('display','none');
                $('#toggle_tags').css('display','none');
                $('#toggle_person').css('display','none');
            } else {
                $('#toggle_notes').css('display','none');
                
            }
        });

        $('#add_tags').click(function(e) {
            e.preventDefault();
            if ($('#toggle_tags').css('display') == "none") {
                $('#toggle_tags').css('display','block');
                $('#toggle_todo').css('display','none');
                $('#toggle_person').css('display','none');
                $('#toggle_notes').css('display','none');
            } else {
                $('#toggle_tags').css('display','none');
            }
        });

        $("#a_person").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(options, request.term);
                response(results.slice(0, 10));
            }
        });

        $('#ATags').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : tag_data
        });

        $('#a_person').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                person_array.push($('#a_person').val());
                $(this).val('');
                $(this).focus();
                append_person();
            }
        });

        $('#person_button').click(function(e) {
            e.preventDefault();
            
            person_array.push($('#a_person').val());
            $('#a_person').val('');
            $('#a_person').focus();
            append_person();
        });

        $('#person_list').on('click', '.delete_person', function(e) {
            e.preventDefault();
            var p=$(this).prop('id');
            person_array.splice(p,1);
            append_person();
        });

        $('#todo_text').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                todo_array.push({'title' : $(this).val(), 'status' : 'false'});
                $(this).val('');
                $(this).focus();
                append_todo();    
            }
        });

        $('#todo_button').click(function(e) {
            e.preventDefault();
            todo_array.push({'title' : $('#todo_text').val(), 'status' : 'false'});
            $('#todo_text').val('');
            $('#todo_text').focus();

            append_todo();
        });

        $('#todo_list').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            todo_array[a].status = $(this)[0].checked;
        });

        append_todo();

        $('#table_button').click(function() {
            var table = "";
            $(this).addClass('mdl-button--colored');
            table +='<table><tbody><tr><td><input type="text"></td><td><input type="text"></td></tr></tbody></table>';
            $("#notes_text").append(table);
        });

        $('#bold_button').click(function(){
            if ($(this).hasClass('mdl-button--colored')) {
                $(this).removeClass('mdl-button--colored');
                // note+='</b>';
                document.execCommand("bold");
            } else {
                $(this).addClass('mdl-button--colored');
                // note+='<b>';
                document.execCommand("bold");
            }
              // console.log(note);
        });

        $('#italic_button').click(function(){
            
            if ($(this).hasClass('mdl-button--colored')) {
                $(this).removeClass('mdl-button--colored');
                //note+='</i>';
                document.execCommand("italic");
            } else {
                $(this).addClass('mdl-button--colored');
                //note+='<i>';
                document.execCommand("italic");
            }
              //console.log(note);
        });

        $('#font_button').click(function(e) {
            e.preventDefault();
            if ($(this).hasClass('mdl-button--colored')) {
                $(this).removeClass('mdl-button--colored');
               $('#notes_text').css('font-family','arial');
            } else {
                $(this).addClass('mdl-button--colored');
                $('#notes_text').css('font-family','Times New Roman');
            }
        });

        $('#a_module').change(function(e){
            e.preventDefault();
            var a = $(this).val();
            $.post('<?php echo base_url()."Sales/leads_module_shortcuts/"; ?>', {
                'mid' : a
            }, function(d, s,x) {
                var out
                out+='<option value="0" selected>Select</option>';
                var a = JSON.parse(d);
                for (var i = 0; i < a.i_function.length; i++) {
                    out+='<option value="'+a.i_function[i].ims_function+'">' + a.i_function[i].ims_name + '</option>';
                }
                $('#a_function').empty();
                $('#a_function').append(out);
            }, "text");
        });

        $('#lead_forward').click(function(e){
        	e.preventDefault();

        	$.post('<?php echo base_url()."Sales/leads_convert/".$lid; ?>'
        	,function(d, s,x) {
                window.location = '<?php echo base_url()."Sales/leads"; ?>';
            }, "text");
        });

        $('#lead_edit').click(function(e){
        	e.preventDefault();
            window.location = '<?php echo base_url()."Sales/leads_edit/".$lid; ?>';
        });

        $('#activity_list').on('click','.activity_id',function(e) {
            e.preventDefault();
            var aid = $(this).prop('id');
            window.location = '<?php echo base_url()."Sales/lead_details/".$lid."/"; ?>'+aid;
        });

        $('#submit').click(function(e) {
			e.preventDefault();
            //var note = '';
            var note = $('#notes_text').html();
            //var note = document.getElementById('notes_text');
            //console.log(note);

            $('#ATags > li').each(function(index) {
                var tmpstr = $(this).text();
                var len = tmpstr.length - 1;
                if(len > 0) {
                    tmpstr = tmpstr.substring(0, len);
                    activity_tags.push(tmpstr);
                }
            });

            $.post('<?php if(isset($edit_activity)){echo base_url()."Sales/activity_edit/".$edit_id."/";}else{echo base_url()."Sales/activity_save";} ?>', {
                'a_title' : $('#a_title').val(),'a_date' : $('#a_date').val(),'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note, 'a_cat' :  $('#a_cat').val(),'a_module' : $('#a_module').val(),'a_function' : $('#a_function').val()
            }, function(data, status, xhr) {
                    window.location = '<?php echo base_url()."Sales/leads"; ?>';
            }, 'text');
		});
	});

	function append_person(){
        var a = "";
        for (var i = 0; i < person_array.length; i++) {
            a+='<tr style="width=100%"><td>'+ person_array[i] +'</td><td><button class="mdl-button mdl-js-button delete_person" id="'+ i +'"><i class="material-icons">delete</i></button></td></tr>';
        }
        $('#person_list').empty();
        $('#person_list').append(a);
    }

    function append_todo(){
        var a = "";
        for (var i = 0; i < todo_array.length; i++) {
            if (todo_array[i].status == "true") {
                a+='<tr><td><h4><input type = "checkbox" id = "'+i+'" class = "mdl-checkbox__input" checked >'+ todo_array[i].title +'</h4></td></tr>';
            }else{
                a+='<tr><td><h4><input type = "checkbox" id = "'+i+'" class = "mdl-checkbox__input">'+ todo_array[i].title +'</h4></td></tr>';
            }    
        }
        $('#todo_list').empty();
        $('#todo_list').append(a);
    }

    function load_activity() {
    	var a ="";
    	for (var i = 0; i < activity_arr.length; i++) {
    		a+='<tr class="activity_id" id="'+activity_arr[i].id+'"><td class="mdl-data-table__cell--non-numeric" style="text-align: left;">'+activity_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric" style="text-align: center;">'+activity_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric" style="text-align: right;">'+activity_arr
    		[i].cat+'</td></tr>';
    	}
    	$('#activity_list').empty();
    	$('#activity_list').append(a);
    }

</script>