<link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap-4.1.0.min.css'; ?>">
<script src="<?php echo base_url().'assets/js/bootstrap-4.1.0.min.js'; ?>"></script>
<style>

    html, body {
        height: 100%;
    }

    .contact_window {
        margin: 5px;
        padding: 10px;
        box-shadow: 0px 0px 20px #ccc;
        height: 85vh;
    }

    .contact_window_search {
        position: sticky;
        margin-bottom: 10px;
        background-color: #fff;
    }

    .contact_window_search_chats {
        border: 0px;
        border-bottom: 1px solid #999;
        font-size: 1.1em;
        width: 90%;
        padding: 18px 0px 18px 18px;
        outline : none; 
        font-style: italic;
        /*text-align: center;*/
    }
    
    .contact_window_list {
        height: 74vh;
        display: flex;
        overflow-y: auto;
    }
    .contact_window_record {
        border-bottom: 1px solid #eee;
        /*height: 75px;*/
        /*display: flex;*/
    }

    .contact_window_record_photo {
        background-image: url('<?php echo base_url()."assets/images/pattern_nav.svg"; ?>');
        background-repeat: no-repeat;
        background-size: contain;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin: 7px;
        float: left;
    }

    .contact_window_record_detail {
        text-align: left;
        margin: 10px;
        width: 65%;
        float: right;

    }

    .contact_window_record_detail_text {
        font-size: 0.6em;
    }

    .contact_window_record_detail_date {
        font-size: 0.6em;
        text-align: right;
    }

    .chat_window {
        /*position: relative;*/
        height: 89vh;
        /*display: none;*/
    }

    @media screen and (max-width:768px) {
        .contact_window {
            background-color: #fff;
        }

        .chat_window {
            display: none;
        }

        .contact_window {
            margin: 0px;
            padding: 0px;
            box-shadow: none;
            display: block;
        }

        .chat_window_back {
            display: block;
        }

        .chat_window_display {
            height: 63vh;
        }
    }
    
    .chat_window_header {
        display: flex;
        height: 30px;
        border-bottom: 1px solid #ccc;
    }

    .chat_window_back {
        text-align: left;
        display: none;
    }

    .chat_window_display {
        position: relative;
        display: block;
        padding: 20px;
        overflow-y: auto;
    }

    .chat_window_display_msg {
        width: 100%;
        background-color: rgba(0, 0, 0, 0);
    }

    .chat_window_display_from {
        text-align: left;
        padding: 14px;
        font-size: 0.8em;
        background-color: #eee;
        width: 80%;
        border-radius: 0px 15px 15px 15px;
        margin: 5px;
        position: relative;
        right: 2%;
        word-wrap: break-word;
    }

    .chat_window_display_from > i {
        font-size: 0.8em;
    }

    .chat_window_display_to {
        text-align: right;
        padding: 14px;
        font-size: 0.8em;
        background-color: #ffcece;
        width: 80%;
        border-radius: 15px 0px 15px 15px;
        margin: 5px;
        position: relative;
        left: 12%;
        word-wrap: break-word;
    }

    .chat_window_display_to > i {
        font-size: 0.8em;
    }
    .chat_window_tools {
        height: 95px;
    }
    .chat_window_tools_text {
        border-bottom-color: #ccc;
        color: #777;
        font-size: 0.9em;
        outline : none; 
        width: 90%;
        height: 4vh;
        border-radius: 5px;
        padding: 10px;
        box-sizing: initial;
    }

    .chat_window_tools_actions {
        text-align: right;
        padding: 10px;
    }

    .chat_window_msg_tools {
        display: none;
    }

    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 10px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .upload {
        display: none;
    }

    #attach {
        -webkit-appearance: initial;
    }

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
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
        <div class="contact_window mdl-cell mdl-cell--4-col">
            <div class=" ">
                <div class="contact_window_search">
                    <input type="text" id="" class="contact_window_search_chats" placeholder="Search ..">
                </div>
                <div class="contact_window_list mdl-card">
                    
                </div>
            </div>
        </div>
        <div class="chat_window mdl-cell mdl-cell--8-col">
            <div class="">
                <div class="chat_window_header">
                    <div class="chat_window_back"><i class="material-icons">arrow_back_ios</i> </div>
                    <div class="chat_window_title"></div>
                    <div class="mdl-layout-spacer"></div>
                    <div class="chat_window_msg_tools">
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--icon" id="msg_tools_delete"><i class="material-icons">delete</i></button>
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--icon" id="msg_tools_remind"><i class="material-icons">alarm</i></button>
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--icon" id="msg_tools_star"><i class="material-icons">star</i></button>
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--icon" id="msg_tools_label"><i class="material-icons">label</i></button>
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--icon" id="msg_tools_email"><i class="material-icons">alternate_email</i></button>
                        
                    </div>
                </div>

                <div class="chat_window_display">
                    
                </div>
                <div class="chat_window_tools">
                    <textarea class="chat_window_tools_text"></textarea>
                    <div class="chat_window_tools_actions">
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" id="module_data"><i class="material-icons">label</i></button>
                        <div type="button" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored fileUpload" id="attach">
                            <i class="material-icons">attach_file</i>
                            
                        </div>
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" id="send"><i class="material-icons">send</i></button>

                    </div>
                    <input type="file" name="attach_file" class="upload" multiple="true" style="display: none">
                </div>
            </div>
        </div>
	</div>
</main>
<div class="modal" id="remind_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Select reminder date and time</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" data-type="date" id="r_date" value="<?php echo date('Y-m-d H:m');?>">
                    <label class="mdl-textfield__label" for="r_date">Date</label>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" data-dismiss="modal" id="r">Remind</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="shortcuts_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Select module for shortcuts</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="module_list">
                    <table class="mdl-data-table" style="width: 100%;">
                            <?php
                                if (isset($modules)) {
                                    for ($i=0; $i < count($modules) ; $i++) { 
                                        echo '<tr id="'.$modules[$i]->im_id.'" class="click_modules">';
                                        echo '<td class="mdl-data-table__cell--non-numeric">'.$modules[$i]->im_name;
                                        echo "</tr>";
                                    }
                                }else{
                                    echo 'You do not have any module !';
                                }
                            ?>
                    </table>
                </div>
                <div class="shortcuts_function" style="display: none">
                    
                </div> 
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" data-dismiss="modal" id="s_module">Remind</button>
            </div> -->
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    var msgs = []; var lists=[]; var selid = -1, keyTrigger=false;var owner = 0;var tmp_id = 0;
    var m_list = [];
    var f_list = [];
    var uname = [];
    <?php 
        for ($i=0; $i < count($messages); $i++) { 
            echo 'lists.push({ "id" : "'.$messages[$i]->ime_id.'", "pseudo_id" : '.$i.',  "type" : "message", "photo" : "", "title" : "'.$messages[$i]->ime_title.'", "msg_short" : "", "date" : "'.$messages[$i]->ime_created.'"});';
        }

        // for ($i=0; $i <count($modules) ; $i++) { 
            // echo 'm_list({"mid" : '.$modules[$i]->im_id.', "m_name" : "'.$modules[$i]->im_name.'"});';
        // }

    ?>
    $(document).ready(function(){

        load_lists();
        var selected_msgs = [];
        $( "#r_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm'});
        $('.chat_window_display').css('height', (window.innerHeight-252));
        $('.chat_window').css('height', (window.innerHeight-100));

        $('.contact_window_list').on('click', '.contact_window_record', function(e) {
            e.preventDefault();
            $('.contact_window_record').css('background-color', '#fff');
            $(this).css('background-color', '#eee');
            if (window.innerWidth <= 768) {
                $('.contact_window').css('display', 'none');
                $('.chat_window_back').css('display', 'block');
                $('.chat_window').css('display','inline');
            }

            selid = $(this).prop('id');
            $('.chat_window_tools_text').focus();
            load_msgs(selid);
        });

        $('.chat_window_back').click(function(e) {
            e.preventDefault();
            $('.contact_window_record').css('background-color', '#fff');
            if (window.innerWidth <= 768) {
                $('.contact_window').css('display', 'block');
                $('.chat_window_back').css('display', 'none');
                $('.chat_window').css('display','none');    
            }
            selid=0;
        });

        $('.contact_window_search_chats').keyup(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Messaging/search_messages_contacts/".$code; ?>', {
                's' : $(this).val()
            }, function(d,s,x) {
                var a=JSON.parse(d); lists=[];
                for (var i = 0; i < a.messages.length; i++) {
                    lists.push({ "id" : a.messages[i].ime_id, "pseudo_id" : i, "type" : "message", "photo" : "", "title" : a.messages[i].ime_title , "msg_short" : "", "date" : a.messages[i].ime_created});
                }

                for (var i = 0; i < a.customer.length; i++) {
                    lists.push({ "id" : a.customer[i].ic_id, "pseudo_id" : (i + a.messages.length) , "type" : "contact", "photo" : "", "title" : a.customer[i].ic_name , "msg_short" : "", "date" : ""});
                }
                load_lists();
            });
        });

        $('.chat_window_tools_text').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13 && keyTrigger==false) {
                send_msg($('.chat_window_tools_text').val(), selid);
                $(this).val('');
                $(this).focus();
                keyTrigger=false;
            } else if(e.keyCode==16){
                keyTrigger=false;
            }
        }).keydown(function(e) {
            if(e.keyCode==16){
                keyTrigger=true;
            }
        });

        $('.chat_window_display').on('click','.chat_window_display_msg', function(e) {
            e.preventDefault();
            if($(this).css('background-color') == 'rgba(0, 0, 0, 0)') {
                $(this).css('background-color','#eee');
                selected_msgs.push($(this).prop('id'));
                if ($(this).children('.chat_window_display_from')) {
                    $(this).children('div').css('background-color','#ff7676');
                } else {
                    $(this).children('div').css('background-color','#aaa');
                }
            } else {
                for (var i = 0; i < selected_msgs.length; i++) {
                    if (selected_msgs[i]==$(this).prop('id')) {
                        selected_msgs.splice(i, 1);
                        break;        
                    }
                }
                
                $(this).css('background-color', 'rgba(0,0,0,0)');
                if ($(this).children('.chat_window_display_from')) {
                    $(this).children('div').css('background-color','#ffcece');
                } else {
                    $(this).children('div').css('background-color','#eee');
                }
            }
            if (selected_msgs.length > 0) {
                $('.chat_window_msg_tools').css('display', 'block')
            } else {
                $('.chat_window_msg_tools').css('display', 'none')
            }
        });

        $('#msg_tools_delete').click(function(e) {
            var a="", mid=0;
            for (var i = 0; i < lists.length; i++) {
                if (selid==lists[i].pseudo_id) {
                    mid=lists[i].id;
                    break;
                }
            }
            $.post('<?php echo base_url()."Messaging/delete_messages/".$code; ?>', {
                'm' : selected_msgs, 'mid' : mid
            }, function(d,s,x) {
                selected_msgs=[];
                $('.chat_window_msg_tools').css('display','none');
                load_msgs(selid);
            }) 
        });

        $('#msg_tools_remind').click(function(e) {
            e.preventDefault();
            $('#remind_modal').modal('toggle');
        });

        $('#module_data').click(function(e) {
            e.preventDefault();

            $('.module_list').show();
            $('.shortcuts_function').hide();
            $('#shortcuts_modal').modal('toggle');
        });

        $('.click_modules').click(function(e) {
            e.preventDefault();
            var m = $(this).prop('id');

            $.post('<?php echo base_url()."Messaging/get_function/".$code; ?>', {
                'm' : m
            }, function(data,s,x) {
                d=JSON.parse(data);
                var out = '';
                if (d.s_function.length > 0) {
                    out+='<table class="mdl-data-table" style="width: 100%;">';
                    for (var i=0; i < d.s_function.length ; i++) { 
                        out+= '<tr id="' + d.s_function[i].ims_function + '" class="click_function" style="width: 100%;">';
                        out+= '<td class="mdl-data-table__cell--non-numeric">' + d.s_function[i].ifun_name;
                        out+= '</tr>';
                    }  
                    out+='</table>';
                }else{
                    out+='This module do not have any shortcuts';
                }
                

                $('.module_list').hide();
                $('.shortcuts_function').show();
                $('.shortcuts_function').empty();
                $('.shortcuts_function').append(out);
            }) 

        });

        $('.shortcuts_function').click(function(e) {
            e.preventDefault();
            var m_function = $('.click_function').prop('id');
            $.post('<?php echo base_url()."Messaging/get_modules/".$code; ?>', {
                'm_function' : m_function
            }, function(data,s,x) {
                  window.location = data;
            })
        });

        $('#r').click(function(e) {
            e.preventDefault();
            var a="", mid=0;
            for (var i = 0; i < lists.length; i++) {
                if (selid==lists[i].pseudo_id) {
                    mid=lists[i].id;
                    break;
                }
            }
            $.post('<?php echo base_url()."Messaging/remind_messages/".$code; ?>', {
                'm' : selected_msgs, 'mid' : mid, 'dt' : $('#r_date').val()
            }, function(d,s,x) {
                selected_msgs=[];
                $('.chat_window_msg_tools').css('display','none');
                load_msgs(selid);
            }) 
        });

        $('#msg_tools_star').click(function(e) {
            var a="", mid=0;
            for (var i = 0; i < lists.length; i++) {
                if (selid==lists[i].pseudo_id) {
                    mid=lists[i].id;
                    break;
                }
            }
            $.post('<?php echo base_url()."Messaging/star_messages/".$code; ?>', {
                'm' : selected_msgs, 'mid' : mid
            }, function(d,s,x) {
                selected_msgs=[];
                $('.chat_window_msg_tools').css('display','none');
                load_msgs(selid);
            }) 
        });

        $('#send').click(function(e) {
            e.preventDefault();
            send_msg($('.chat_window_tools_text').val(), selid);
        });

        $('.upload').bind('change', function(){
            console.log(this.files[0].size);            
        });

        $('#attach').click(function(e) {
            e.preventDefault();
            $('.upload').focus().trigger('click');
        });
    });

    setInterval(function(){
        if (selid != -1) {
            load_msgs(selid);
        }
    }, 10000);

    function load_msgs(id) {
        var a="", mid=0;
        for (var i = 0; i < lists.length; i++) {
            if (id==lists[i].pseudo_id) {
                mid=lists[i].id;
                tmp_id = lists[i].pseudo_id;
            }
        }
        selid = mid;
        $.post('<?php echo base_url()."Messaging/get_messages/".$code; ?>', {
            'i' : mid
        },function(d,s,x) {
            msgs=[]; var b=JSON.parse(d);
            uname =[];
            var title = '';
            owner = b.m_owner;
            for (var i = 0; i < b[0].length; i++) {
                msgs.push({ 'mid' : b[0][i].mid, 'title' : b[0][i].data.title, 'data' :  [{'from': b[0][i].data.from,'name': b[0][i].data.name ,'read' : b[0][i].data.read , 'unread' : b[0][i].data.unread ,'message' : b[0][i].data.message, 'date' : b[0][i].data.date, 'attachment' : b[0][i].data.attachment, 'remind' : b[0][i].data.remind, "star" : b[0][i].data.star , 'status' : 'read' }] });
                title = b[0][i].data.title;
            }

            for (var i = 0; i < b.uname.length; i++) {
                uname.push({'id' : b.uname[i].ic_uid , 'name' : b.uname[i].ic_name});
            }

            $('.chat_window_title').empty();
            $('.chat_window_title').append(lists[tmp_id].title);
            
            if (msgs.length > 0) {
                for (var i = 0; i < msgs.length; i++) {
                    if (msgs[i].data[0].message == "start") {
                        a+='<div class="today_header" style="width:100%;text-align:center;"><i>'+msgs[i].data[0].date+'</i></div>';
                    }else if (msgs[i].data[0].message == "Group created") {
                         a+='<div class="today_header" style="width:100%;text-align:center;">created <i style="size: 1em">'+msgs[i].data[0].date+'</i></div>';
                    }else if (msgs[i].data[0].attachment!="null") {
                            a+='<div class="today_header" style="width:100%;text-align:right;"><a href="' +msgs[i].data[0].attachment +'" style="color:black;" id="attach_download" download><i class="material-icons" style="margin-right : 80px">attach_file</i></a></div>';
                    }else{
                        a+='<div class="chat_window_display_msg" id="'+i+'">';
                        if(msgs[i].data[0].from== owner) {
                            a+='<div class="chat_window_display_to">';
                        } else {
                            a+='<div class="chat_window_display_from">';
                            for (var j = 0; j < uname.length; j++) {
                                if (msgs[i].data[0].from == uname[j].id) {
                                    a+='<b>'+msgs[i].data[0].name+'</b><br>';
                                }    
                            }
                        }

                        if (msgs[i].data[0].star) {
                            a+='<i class="material-icons">star</i><br>';    
                        }

                        if (msgs[i].data[0].message!="null") {
                            a+=msgs[i].data[0].message;
                        }

                        

                        a+='<br><i>'+msgs[i].data[0].date+'</i>';
                        if (msgs[i].data[0].remind) {
                            a+='<br><i class="material-icons">alarm</i>';    
                        }
                        a+='</div></div>';

                        // if (msgs[i].data[0].attachment!="null") {
                        //     a+='<a href="' +msgs[i].data[0].attachment +'" style="color:black;" id="attach_download" download><i class="material-icons" >attach_file</i></a>';
                        // }
                    }
                }
            }
            $('.chat_window_display').empty();
            $('.chat_window_display').append(a);
            $(".chat_window_display").scrollTop($(".chat_window_display")[0].scrollHeight);
            $('.chat_window_tools_text').focus();
        });
    }

    function send_msg(message, id) {
        var mid=0;
        for (var i = 0; i < lists.length; i++) {
            if (id==lists[i].pseudo_id) {
                mid=lists[i].id;
            }
        }
        if (message!="") {
            $.post('<?php echo base_url()."Messaging/update_messages/".$code; ?>', {
                'm' : message, 'mid' : mid, 'title' : lists[id].title, 'to' : lists[id].id
            }, function(d,s,x) {
                if ($('.upload').val() != "") {
                    upload_attachments(d, id);
                } else {
                    load_msgs(id);
                }
                $('.chat_window_tools_text').val('');
                $('.chat_window_tools_text').focus();
            }, "text");
        } else if($('.upload').val() != "") {
            upload_attachments(mid, id);
            $('.chat_window_tools_text').val('');
            $('.chat_window_tools_text').focus();
        } else {
            load_msgs(id);
            $('.chat_window_tools_text').val('');
            $('.chat_window_tools_text').focus();
        }
        
        
    }

    function upload_attachments(mid, id) {
        for (var i = 0; i < lists.length; i++) {
            if (id==lists[i].pseudo_id) {
                mid=lists[i].id;
            }
        }
        
        var fl = new FormData();
        for (var i = 0; i < $('.upload')[0].files.length; i++) {
            fl.append(i, $('.upload')[0].files[i]);
        }

        if($('.upload')[0].files[0]) {
            flnm = "";
            $.ajax({
                url: "<?php echo base_url().'Messaging/uploadfile/'.$code; ?>" + mid + '/' + lists[id].id, // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: fl, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                    flnm = data.toString();
                    $('.upload').val('');
                    load_msgs(id);
                }
            });
        } else {
            load_msgs(id);
        }
    }

    function load_lists() {
        a="";
        for (var i = 0; i < lists.length; i++) {
            a+='<div class="contact_window_record" id="' + lists[i].pseudo_id + '">';
            a+='<div class="contact_window_record_photo">"' + lists[i].photo + '"</div>';
            a+='<div class="contact_window_record_detail">';
            a+='<div class="contact_window_record_detail_title">' + lists[i].title + '</div>';
            a+='<div class="contact_window_record_detail_text">' + lists[i].msg_short + '</div>';
            a+='<div class="contact_window_record_detail_date">' + lists[i].date + '</div>';
            a+='</div>';
            a+='</div>';
        }
        $('.contact_window_list').empty();
        $('.contact_window_list').append(a);
    }
</script>
</html>