<style type="text/css">
	.ui-widget {
        width: auto;
        z-index: 30000;
    }
	.ond-card-name {
		box-shadow: 1px 1px 2px #999!important;
		border-radius: 2px!important;
		padding: 10px;
	}
	.pic_button {
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc;
/*		margin: 20px;*/
		position: relative;
		overflow: hidden;
	}
	.pic_button input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}

	.btn-explore {
       	background-color: #fff;
		color: #404040;
		border: 0px;
		padding: 25px 20px;
		border-radius: 10px;
		margin: 10px;
		box-shadow: 0px 3px 10px #ccc;
		font-size: 1.2em;
    }
</style>

<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-grid" id="display_cat" style="height: 35vh; overflow-y: auto;box-shadow: 0px 3px 10px #ccc;border-radius: 10px;">
			</div>
			<div class="mdl-grid" id="details">
				<div class="mdl-cell mdl-cell--6-col">
					<h3>Products</h3>
				</div>
				<div class="mdl-cell mdl-cell--6-col" style="text-align: right;">
					<button class="mdl-button mdl-js-button" style="color: #666;" id="import_file"><i class="material-icons">backup</i> Import File</button>
					<button class="mdl-button mdl-js-button" style="color: #666;" id="add_cat"><i class="material-icons">add</i> Add Categories</button>
				</div>
				<div class="mdl-cell mdl-cell--2-col"></div>
				<div class="mdl-cell mdl-cell--8-col">
					<div class="mdl-grid" id="display_product" style="height: 30vh; overflow-y: auto;">
					</div>
				</div>
				<div class="mdl-cell mdl-cell--2-col"></div>
			</div>
		</div>
	</div>
	<a href="<?php echo base_url().'Enterprise/product_add/'.$code; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>
</main>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
</body>
<div class="modal" id="cat_Modal" role="dialog" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            	<h3>Add category</h3>	
            </div>
            <div class="modal-body">
            	<div class="mdl-grid">
            		<div class="mdl-cell mdl-cell--12-col">
            			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="cat_name" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="cat_name">Enter category name</label>
						</div>
            		</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<label>Select Parent Category</label>
							<ul id="cat_tag">
							</ul>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
							<i class="material-icons">note</i>  Upload Image for Category
							<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
						</div>
					</div>
				</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="mdl-button mdl-button--colored cat_save"><i class="material-icons">save</i> Save</button>
	        	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
	        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	var cat_arr=[];
	var product_arr = [];
	var cat_list=[];
	<?php
		if (isset($p_cat)) {
			for ($i=0; $i <count($p_cat) ; $i++) { 
				echo "cat_arr.push('".$p_cat[$i]->iproc_name."');";
			}
		}
		if (isset($cat_list) && count($cat_list) > 0) {
			for ($i=0; $i <count($cat_list) ; $i++) { 
				echo "cat_list.push({'id':'".$cat_list[$i]->iproc_id."','name':'".$cat_list[$i]->iproc_name."','img':'".$cat_list[$i]->iproc_img."'});";
			}
		}

		if (isset($product)) {
			for ($i=0; $i <count($product) ; $i++) { 
				echo "product_arr.push({'id':'".$product[$i]->ip_id."','name':'".$product[$i]->ip_product."','img':'".$product[$i]->ipp_timestamp."'});";
			}
		}
	?>
	$(document).ready(function() {
		var snackbarContainer = document.querySelector('#demo-toast-example');
		display_cat();
		$('#cat_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : cat_arr,
    		tagLimit : 1,
    		singleField : true
    	});

		$('#details').on('click', '.ond-card-name', (function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Enterprise/product_details/'.$code."/"; ?>" + $(this).prop('id');
		}));

		$('.import_file').click(function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url().'Enterprise/excel_import_file/Product/'.$code; ?>';
		});

		$('.cat_save').click(function (e) {
			e.preventDefault();
			var cat = [];
			$('#cat_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					cat.push(tmpstr1);
				}
			});
			$.post('<?php echo base_url()."Enterprise/save_category/".$code ?>',{
				'cname': $('#cat_name').val(),
				'pcat' : cat
			},function (d,s,x) {
				if (d=='exist') {
					var data = {message: 'Category alredy exist!'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}else{
					upload_files(d);
				}
			});
		});

		$('#display_cat').on('click','.categories',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = '<?php echo base_url()."Enterprise/products/".$mid."/".$code."/";?>'+id;
		});

		$('#display_product').on('click', '.products', (function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Enterprise/product_details/'.$code."/"; ?>" + $(this).prop('id');
		}));

		function upload_files(inid){
    		if($('.proposal_doc')[0].files[0]) {
				var datat = new FormData();
	            var ins = $('.proposal_doc')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.proposal_doc')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Enterprise/cat_doc_upload/'.$code.'/';?>"+inid, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						window.location = '<?php echo base_url()."Enterprise/products/".$mid."/".$code;?>';
					}
				});
			}else{
				window.location = '<?php echo base_url()."Enterprise/products/".$mid."/".$code;?>';
			}
    	}

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/product_search/".$code; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#display_product').empty();
				var out = "";
				cat_list =[];product_arr=[];
				for (var i = 0; i < abc.p_cat.length; i++) {
					cat_list.push({id : abc.p_cat[i].iproc_id ,name : abc.p_cat[i].iproc_name, img : abc.p_cat[i].iproc_img });
				}
				for (var i = 0; i < abc.product.length; i++) {
					product_arr.push({id : abc.product[i].ip_id ,name : abc.product[i].ip_product });
				}
				display_cat();
			})
		});

		$('#add_cat').click(function (e) {
			e.preventDefault();
			$('#cat_Modal').modal('show');
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

		function display_cat(){
			var a='';
			if (cat_list.length > 0 ) {
				for (var i=0; i < cat_list.length ; i++) {
					a+='<div class="mdl-cell mdl-cell--2-col categories" id="'+cat_list[i].id+'">';
					a+='<div class= mdl-card mdl-shadow--4dp" style="border-radius:10px;">';
					if(cat_list[i].img != '') {
						var path = '<?php echo base_url()."assets/uploads/".$oid."/"; ?>'+cat_list[i].img;
						a+='<div class="mdl-card__title mdl-card--expand" style="height:50px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url('+path+');background-size: 100%;">';
					} else {
						a+='<div class="mdl-card__title mdl-card--expand" style="height:50px;">';
					}
					a+='<h2 class="mdl-card__title-text">'+cat_list[i].name+'</h2>';
					a+='</div>';
					a+='</div>';
					a+='</div>';
				}
				$('#display_cat').empty();
				$('#display_cat').append(a);
			}else{
				$('#display_cat').css('display','none');
			}

			a= '';
			a+='<div class="mdl-cell mdl-cell--12-col">';
			if (product_arr.length > 0 ) {
				a+='<table style="width:100%;">';
				for (var i=0; i < product_arr.length ; i++) {
					a+='<tr class="products" style="border-bottom : 1px solid #ccc;" id="'+product_arr[i].id+'"><td style="padding:20px;font-size: 1.3em;">'+product_arr[i].name+'</td></tr>'
				}
				a+='</table>';
			}else{
				a+='<h5 style="text-align:center;">No records found !</h5>';
			}
			a+='</div>';
			$('#display_product').empty();
			$('#display_product').append(a);
		}
	});
</script>
</html>