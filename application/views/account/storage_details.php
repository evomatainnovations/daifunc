<style>
.modal-dialog {
    z-index: 10000000 !important;
    transform: translate(0, -50%);
    top: 40%;
    margin: 0 auto;
}
.demo-card-square.mdl-card {
  width: 320px;
  height: 220px;
}
.demo-card-square > .mdl-card__title {
  color: #fff;
}
</style>
<main class="mdl-layout__content" style="z-index:3;">
    <div class="mdl-grid" style="height:80px;" id="display_today">
        <div class="mdl-cell mdl-cell--6-col navigation">
            <?php
                if (isset($m_list)) {
                    echo '<button class="mdl-button"><i class="material-icons">home</i> Home</button>';
                }
            ?>
        </div>
        <div class="mdl-cell mdl-cell--6-col percents">
            <h3 id="storage_use_digit" style="right: 10px;top: 0px;position: absolute;margin-top: 10px;"></h3>
            <h3 id="storage_use_digit1" style="right: 100px;top: 0px;position: absolute;margin-top: 10px;"></h3>
        </div>
        <div class="mdl-cell mdl-cell--6-col">
        </div>
        <div class="mdl-cell mdl-cell--6-col">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" id="storage_use"></div>
            </div>
        </div>
	</div>
    <div class="mdl-grid" id="mod_folder">
        <div class="mdl-cell mdl-cell--12-col"><hr><h3 style="font-weight: bold;">System folders</h3><hr></div>
        <?php
            if (isset($m_list)) {
                for ($i=0; $i < count($m_list) ; $i++) {
                    if ($m_list[$i]->m_alias == '') {
                        $alias = $m_list[$i]->mname;
                    }else{
                        $alias = $m_list[$i]->m_alias;
                    }
                    echo '<button class="mdl-button mdl-button--colored folder_icons" style="height:10em;color:black;" id="'.$m_list[$i]->mid.'"><i class="material-icons" style="font-size:6em;color:rgba(10, 144, 255, 0.61);">folder</i> <p style="text-align:center;font-size:0.9em;">'.$alias.'</p></button>';
                }
            }
        ?>
    </div>
    <div class="mdl-grid" id="users_folders">
        <div class="mdl-cell mdl-cell--12-col"><hr><h3 style="font-weight: bold;">Your folders <button class="mdl-button mdl-button--icons mdl-button--colored doc_paste" style="display: none;"><i class="material-icons">file_copy</i> paste</button></h3></div>
        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-grid" id="user_folder">
                <div class="mdl-cell mdl-cell--1-col" style="text-align:center;">
                    <button class="mdl-button mdl-button--fab add_folder" id="'+<?php echo $mid; ?>+'" style="text-align:center;margin-top:15%;"><i class="material-icons">add</i> </button>
                </div>
            </div>
        </div>
    </div>
	<div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col"><hr><h3 style="font-weight: bold;">Your files </h3></div>
        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-grid" id="folders">
            </div>
        </div>
    </div>
</main>
</body>
<div class="modal fade" id="delete_user_folder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body delete_content">
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-button--colored folder_delete_yes" id="yes" data-dismiss="modal">Yes</button>
                <button type="button" class="mdl-button mdl-button--colore folder_delete_yes" id="no" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_user_doc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body delete_content_doc">
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-button--colored doc_delete_yes" id="yes" data-dismiss="modal">Yes</button>
                <button type="button" class="mdl-button mdl-button--colore doc_delete_yes" id="no" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<script>
var total_storage = <?php echo $total_storage; ?>;
var doc_arr = [];
var mod_folder = [];
var folder_arr = [];
var delete_flg = 0;
<?php
    if (isset($doc)) {
        for ($i=0; $i <count($doc) ; $i++) {
            $ext = pathinfo($doc[$i]->icd_timestamp, PATHINFO_EXTENSION);
            echo "doc_arr.push({'id' : '".$doc[$i]->icd_id."', 'cid' : '".$doc[$i]->icd_cid."', 'file' : '".$doc[$i]->icd_file."','owner' : '".$doc[$i]->icd_owner."', 'file_id' : '".$doc[$i]->icd_timestamp."' , 'ext' : '".$ext."' ,'mid' : '".$doc[$i]->icd_mid."'});";
        }
    }

    if (isset($u_folder)) {
        for ($i=0; $i <count($u_folder) ; $i++) {
            echo "folder_arr.push({'id' : '".$u_folder[$i]->iuf_id."', 'name' : '".$u_folder[$i]->iuf_folder_name."' , 'flg' : 'true' });";
        }
    }
    if ($mid != 0 ) {
        echo "var mname = '".$mname."';";
        echo "$('#users_folders').css('display','none');";
    }else{
        echo "var mname = '';";
    }
    if (!isset($m_list)) {
        echo "$('#mod_folder').css('display','none');";
    }

    if (isset($move_doc)) {
        if ($move_doc != '' || $move_doc != null) {
            echo "$('.doc_paste').css('display','block');";
        }
    }

?>
$(document).ready(function() {
doc_display();
display_nav();
display_u_folder();
var size1 = '';var perc='';var p = '';
<?php
	if ($size == '') {
		echo 'size1 = 0;';
	}else{
		echo 'size1 = '.$size.';';
	}
?>
perc = size1 / 500000 * 100;
size2 = size1/1000;
update_progress(perc);
var files_array = [];

	$('#folders').on('click','.doc_download',function(e){
        e.preventDefault();
        var fid = $(this).prop('id');
        for (var i = 0; i < doc_arr.length; i++) {
            if(doc_arr[i].id == fid){
                fid = i;
                break;
            }
        }
        window.location = "<?php echo base_url()."Account/doc_download/".$code."/"; ?>"+ doc_arr[fid].file_id ;
    });

    $('#folders').on('click','.doc_delete',function(e){
        e.preventDefault();
        delete_flg = $(this).prop('id');
        for (var i = 0; i < doc_arr.length; i++) {
            if(doc_arr[i].id == delete_flg){
                var fname = doc_arr[i].file;
                break;
            }
        }
        $('.delete_content_doc').append('<h3>Are you sure you want to delete "'+fname+'" ? </h3>');
        $('#delete_user_doc').modal('show');
    });

    $('.doc_delete_yes').click(function (e) {
        e.preventDefault();
        if ($(this).prop('id') == 'no') {
            delete_flg = 0;
        }else{
            var fid;
            for (var i = 0; i < doc_arr.length; i++) {
                if(doc_arr[i].id == delete_flg){
                    fid = i;
                    break;
                }
            }
            $.post('<?php echo base_url()."Account/doc_delete/".$code."/".$mid."/".$fid."/"; ?>'+ doc_arr[fid].file_id +'/'+ doc_arr[fid].id
            , function(data, status, xhr) {
                var a = JSON.parse(data);
                if (data != 'false') {
                    window.location = "<?php echo base_url()."Account/storage_details/".$code."/".$mid."/".$fid; ?>";
                }
            }, "text");
        }
    });

    $('#folders').on('click','.doc_move',function(e){
        e.preventDefault();
        var doc_id = $(this).prop('id');
        $.post('<?php echo base_url()."Account/doc_move/".$code."/".$mid."/".$fid."/"; ?>'+ doc_id
        , function(data, status, xhr) {
            if (data == 'true') {
                window.location = "<?php echo base_url()."Account/storage_details/".$code."/0/0"; ?>";
            }
        }, "text");
    });

    $('#folders').on('click','.doc_copy',function(e){
        e.preventDefault();
        var doc_id = $(this).prop('id');
        $.post('<?php echo base_url()."Account/doc_copy/".$code."/".$mid."/".$fid."/"; ?>'+ doc_id
        , function(data, status, xhr) {
            if (data == 'true') {
                window.location = "<?php echo base_url()."Account/storage_details/".$code."/0/0"; ?>";
            }
        }, "text");
    });

    $('.doc_paste').click(function(e){
        e.preventDefault();
        $.post('<?php if (isset($move_doc)) echo base_url()."Account/doc_paste/".$code."/".$mid."/".$fid."/".$move_doc; ?>'
        , function(data, status, xhr) {
            if (data == 'true') {
                window.location = "<?php echo base_url()."Account/storage_details/".$code."/".$mid."/".$fid; ?>";
            }
        }, "text");
    });

    $('.folder_icons').on('click',function(e){
        e.preventDefault();
        var mid = $(this).prop('id');
        window.location = "<?php echo base_url()."Account/storage_details/".$code."/"; ?>"+ mid + '/' + '0' ;
    });

    $('#user_folder').on('click','.add_folder',function (e) {
        e.preventDefault();
        var id = $(this).prop('id');
        var out = '';
        var f_name = 'untitled folder';
        $.post('<?php echo base_url()."Account/add_folder/".$code."/".$fid; ?>',{
            'f_name' :f_name
        }, function(data, status, xhr) {
            var a = JSON.parse(data);
            var id = a.add_fid;
            folder_arr = [];
            if (a.u_folder.length > 0 ) {
                for (var i = 0; i < a.u_folder.length; i++) {
                    if(a.u_folder[i].iuf_id == id ){
                        folder_arr.push({id : a.u_folder[i].iuf_id, name : a.u_folder[i].iuf_folder_name , flg : 'false' });
                    }else{
                        folder_arr.push({id : a.u_folder[i].iuf_id, name : a.u_folder[i].iuf_folder_name , flg : 'true' });
                    }
                }
            }
            display_u_folder();
            // window.location = "<?php //echo base_url()."Account/storage_details/".$code."/".$mid."/".$fid; ?>";
        }, "text");
    });

    $('#user_folder').on('keyup','.folder_name',function (e) {
        e.preventDefault();
        if (e.keyCode == 13) {
            var f_id = $(this).prop('id');
            var f_name = $(this).val();
            $.post('<?php echo base_url()."Account/update_folder/".$code."/"; ?>',{
                'f_name' :f_name , 'f_id' : f_id
            }, function(data, status, xhr) {
                window.location = "<?php echo base_url()."Account/storage_details/".$code."/".$mid."/".$fid; ?>";
            }, "text");
        }
    });

    $('#user_folder').on('click','.folder_rename',function (e) {
        e.preventDefault();
        var id = $(this).prop('id');
        for (var i=0; i < folder_arr.length ; i++) {
            if (folder_arr[i].id == id ) {
                folder_arr[i].flg = 'false';
            }
        }
        display_u_folder();
    });

    $('#user_folder').on('click','.folder_delete',function (e) {
        e.preventDefault();
        delete_flg = $(this).prop('id');
        $('.delete_content').append('<h3>Are you sure you want to delete this folder ? </h3>');
        $('#delete_user_folder').modal('show');
    });

    $('.folder_delete_yes').click(function (e) {
        e.preventDefault();
        if ($(this).prop('id') == 'no') {
            delete_flg = 0;
        }else{
            $.post('<?php echo base_url()."Account/delete_folder/".$code."/"; ?>',{
                'f_id' : delete_flg
            }, function(data, status, xhr) {
                window.location = "<?php echo base_url()."Account/storage_details/".$code."/".$mid."/".$fid; ?>";
            }, "text"); 
        }
    });

    $('#user_folder').on('click','.folder_open',function (e) {
        e.preventDefault();
        window.location = "<?php echo base_url()."Account/storage_details/".$code."/"; ?>"+ '0' + '/' + $(this).prop('id') ;
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
    
    function display_nav() {
        var out = '';
        if (mname != '' ) {
            out += '<button class="mdl-button folder_icons" id="0"><i class="material-icons">home</i> Home</button> >> <button class="mdl-button">'+mname+'</button>';
            $('.navigation').empty();
            $('.navigation').append(out);
        }else{
            out += '<button class="mdl-button folder_icons" id="0"><i class="material-icons">home</i> Home</button>';
            $('.navigation').empty();
            $('.navigation').append(out);
        }
    }

    function display_u_folder() {
        var out = '';
        for (var i = 0; i < folder_arr.length; i++) {
            if (folder_arr[i].flg == 'true') {
                out += '<div class="" id="u_folder'+folder_arr[i].id+'">';
                out += '<button class="mdl-button mdl-button--colored" style="height:10em;color:black;"><i class="material-icons" style="font-size:6em;color:rgba(10, 144, 255, 0.61);">folder</i> <p style="text-align:center;font-size:0.9em;">'+folder_arr[i].name+'<p></button>';
                out += '</div>';
                out += '<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" for="u_folder'+folder_arr[i].id+'" style="background-color:lightgray;"><li class="mdl-menu__item folder_open" id="'+folder_arr[i].id+'">Open</li><li class="mdl-menu__item folder_rename" id="'+folder_arr[i].id+'">Rename</li><li class="mdl-menu__item folder_delete" id="'+folder_arr[i].id+'">Delete</li></ul>';
            }else{
                out += '<button class="mdl-button mdl-button--colored" style="height:10em;color:black;" id="'+folder_arr[i].id+'"><i class="material-icons" style="font-size:6em;color:rgba(10, 144, 255, 0.61);">folder</i><br><input type="text" style="text-align:center" class="folder_name" id="'+folder_arr[i].id+'" value="'+folder_arr[i].name+'"></button>';
            }
        }
        out += '<div class="mdl-cell mdl-cell--1-col" style="text-align:center;"><button class="mdl-button mdl-button--fab add_folder" id="'+<?php echo $mid; ?>+'" style="text-align:center;margin-top:15%;"><i class="material-icons">add</i> </button></div>';

        $('#user_folder').empty();
        $('#user_folder').append(out);
        $('.folder_name').focus();
    }   

	function doc_display() {
		var out ='';
        var path = '';
		if (doc_arr.length > 0) {
            for (var i = 0; i < doc_arr.length; i++) {
                var oid ='';
                path = "<?php echo base_url().'assets/uploads/'.$oid.'/';?>"+doc_arr[i].file_id;
                out += '<div class="mdl-cell mdl-cell--2-col document" id="doc'+doc_arr[i].id+'"><a href="#sign_up" id="'+doc_arr[i].id+'"><div class="mdl-card__title mdl-card--expand" style="background: linear-gradient(0deg,rgba(0,0,0,0.5),rgba(200, 15, 15, 0.3)),url('+path+');background-size: contain;width: 256px;background-repeat: no-repeat;height: 256px;"><h2 class="mdl-card__title-text">'+doc_arr[i].file+'</h2></div></a></div>';
                out += '<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect" style="background-color:lightgray;" for="doc'+doc_arr[i].id+'"><li class="mdl-menu__item doc_copy" id="'+doc_arr[i].id+'">Copy</li><li class="mdl-menu__item doc_move" id="'+doc_arr[i].id+'">Move to</li><li class="mdl-menu__item doc_download" id="'+doc_arr[i].id+'">Downlaod</li><li class="mdl-menu__item doc_delete" id="'+doc_arr[i].id+'">Delete</li></ul>'
            }
        }
        $('#folders').empty();
        $('#folders').append(out);
	}
	function update_progress(p) {
		
		if (p>=85) {
            $('#storage_use').removeClass('bg-warning bg-danger');
            $('#storage_use').addClass('bg-success');
        } else if(p<=15) {
            $('#storage_use').removeClass('bg-warning bg-success');
            $('#storage_use').addClass('bg-danger');
        } else {
            $('#storage_use').removeClass('bg-success bg-danger');
            $('#storage_use').addClass('bg-warning');
        }
        $('#storage_use').css('width', p+'%');
        $('#storage_use_digit').html(p.toFixed(2) + '%');
        $('#storage_use_digit1').html('( '+size2 + 'Mb/ '+ total_storage +'Mb )');
        return p;
    }  

});
</script>
</html>