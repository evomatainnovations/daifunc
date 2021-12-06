<style>
	.modal-dialog {
        z-index: 10000000 !important;
    }

    .modal-content{
        border-radius: 0px;
        box-shadow: 1px 5px 77px #000;
        min-height:500px !important;
        max-height: 500px !important;
    }

    .modal-footer{
        /*padding: 30px;*/
        padding-bottom: 0px;
    }

    .modal-header{
        padding: 30px;
        padding-bottom: 0px;
    }

    .modal{
        padding-left: 0px;
    }

    .pdflink:after {
	    /*background-image: url('/images/pdf.png');*/
	    background-size: 10px 20px;
	    display: inline-block;
	    width: 10px; 
	    height: 20px;
	    content:"";
	}
    .showSlide img {  
            width: auto;  
        }  
    .slidercontainer {  
        max-width: 1000px;  
        position: relative;  
        margin: auto;  
    }  
    .left, .right {  
        cursor: pointer;  
        position: absolute;  
        top: 50%;  
        width: auto;  
        padding: 16px;  
        margin-top: -22px;  
        color: white;  
        font-weight: bold;  
        font-size: 18px;  
        transition: 0.6s ease;  
        border-radius: 0 3px 3px 0;  
    }  
    .right {  
        right: 0;  
        border-radius: 3px 0 0 3px;  
    }  
        .left:hover, .right:hover {  
            background-color: rgba(115, 115, 115, 0.8);  
        }  
    .content {  
        color: #eff5d4;  
        font-size: 30px;  
        padding: 8px 12px;  
        position: absolute;  
        top: 10px;  
        width: 100%;  
        text-align: center;  
    }  
    .active {  
        background-color: #717171;  
    }
    
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col" id="domain">
			
		</div>
	</div>
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent submit"><i class="material-icons">done</i></button>
</main>
</body>
	<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
	  <div class="mdl-snackbar__text"></div>
	  <button class="mdl-snackbar__action" type="button"></button>
	</div>
    <div class="modal fade" id="details_Modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                </div>
                <div class="modal-body">
                    <!-- <div class="mdl-grid" id="module">
                    	
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="mdl-button mdl-button-fab" data-dismiss="modal" id="e_add"><i class="material-icons">add</i> Add to My Account</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">

	

	var domain_arr = []; var module_arr = []; var mid ='';
	var invite_send = [],g_image = [];
    var images = [],    // array of img src from PHP
    preloads = [];  // array of preloaded images
    
	<?php
		if (isset($domain)) {
			for ($i=0; $i <count($domain) ; $i++) { 
				echo "domain_arr.push({'id' : ".$domain[$i]->idom_id.", 'name' : '".$domain[$i]->idom_name."'});";
			}
			for ($i=0; $i <count($module) ; $i++) { 
				echo "module_arr.push({'id' : ".$module[$i]->im_id.", 'name' : '".$module[$i]->im_name."', 'dom_id' : ".$module[$i]->im_domain.", 'desc' : '".$module[$i]->im_desc."' });";
				
			}
			for ($j=0; $j <count($g_image) ; $j++) { 
				echo "g_image.push({'mid' : ".$g_image[$j]->imf_mid.", 'file' : '".$g_image[$j]->imf_file."'});";		
			}
			for ($j=0; $j <count($files) ; $j++) { 
				echo "images.push({'mid' : ".$files[$j]->imf_mid.", 'file' : '".$files[$j]->imf_file."'});";		
			}
		}
	?>
	$(document).ready(function() {

		domain_laod();
		
		<?php
			if (isset($modal)) {
				echo "modal(".$modal.");";
				echo "mid = ".$modal.";";
			}
		?>	
		var snackbarContainer = document.querySelector('#demo-toast-example');

		$('.modal-footer').on('click','#e_add',function(e){
			e.preventDefault();
			invite_send.push(mid);
		});
		

		$('.domain_list').click(function(e){
			e.preventDefault();
			var d_id = $(this).prop('id')
			$.post('<?php echo base_url()."Store/module_list/"; ?>'+d_id
			, function(d,s,x) {
				var a = JSON.parse(d);
					for (var i = 0; i < a.module_list.length; i++) {
						module_arr.push({'id' : a.module_list[i].im_id, 'name' : a.module_list[i].im_name, 'file' : a.module_list[i].im_file , 'desc' : a.module_list[i].im_desc });
					}
				module_load();
					
            }, "text");
		});
		
		$('a[href="#sign_up"]').click(function(){
		 	mid = $(this).prop('id');
		 	modal(mid);
		}); 

		$('.submit').click(function(e){
			e.preventDefault();
			$.post('<?php echo base_url()."Store/send_email_module/"; ?>',{ 
				'mid' : invite_send 
			},function(d,s,x) {
				var data = {message: 'Email sent.'};
    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
            }, "text");

		});

		var slideIndex = 2;
		
		function showSlides() {
		    // var lslides = document.getElementsByClassName("showSlide");
		    var lslides = $('.showSlide');
		    console.log("count" + lslides.length);
		    for (var i = 0; i < lslides.length; i++) {
		       lslides[i].style.display = "none";
		    }
		    slideIndex++;
		    if (slideIndex > lslides.length) {
		    	slideIndex = 2;
		    }
		    lslides[slideIndex-1].style.display = "block";  
		    setTimeout(showSlides, 3000); // Change image every 3 seconds
		}

		function modal(mid) {
			var path = '';
			var name = '';
			var out = '';
			for (var i = 0; i < module_arr.length; i++) {
				if (module_arr[i].id == mid) {
					name = module_arr[i].name;
					out +='<h3>'+module_arr[i].desc+'</h3><div class="slidercontainer">';
					for (var j = 0; j < images.length; j++) {
						if(images[j].mid == mid){
							// console.log("Module ID:" + module_arr[i].id + " Img Id: " + images[j].file + " Mid: " + mid);
							path = "<?php echo base_url().'assets/data/portal/';?>"+module_arr[i].name+'/details/'+images[j].file;
							out +='<div class="showSlide"><img src="'+path+'" style=" height:170px;width:500px;"></div>';
						}path = '';
					}
					out +='</div>';
				}
			}

			$('#details_Modal').modal('show');
			$('.modal-body').empty();
			$('.modal-header').empty();
			$('.modal-header').append('<h2>'+name+'</h2><button type="button" class="close" data-dismiss="modal">&times;</button>');
			$('.modal-body').append(out);
			showSlides();  
		}
	

		function domain_laod(){
			var out = '';
			var path = '';
			var count = 0;
			for (var i = 0; i < domain_arr.length; i++) {
				out +='<h2 class="mdl-card__title-text" >'+domain_arr[i].name+'</h2><hr>';
				out +='<div class="mdl-grid " style="margin-bottom: ;">';
				for (var j = 0; j < module_arr.length; j++) {
					if(module_arr[j].dom_id == domain_arr[i].id){
						for (var k = 0; k < g_image.length; k++) {
							if (module_arr[j].id == g_image[k].mid) {
								path = "<?php echo base_url().'assets/data/portal/';?>"+module_arr[j].name+'/details/'+g_image[k].file;
								count++;
								out +='<div class="mdl-cell mdl-cell--2-col module_list" id="'+module_arr[j].id+'"><a href="#sign_up" id="'+module_arr[j].id+'"><div class="mdl-card__title mdl-card--expand" style="background: linear-gradient(0deg,rgba(0,0,0,0.5),rgba(200, 15, 15, 0.3)),url('+path+');background-size: cover;width: 256px;height: 256px;"><h2 class="mdl-card__title-text">'+module_arr[j].name+'</h2></div></a></div>';
								break;
								
							}
						}
						if (path == '') {
							out +='<div class="mdl-cell mdl-cell--2-col module_list" id="'+module_arr[j].id+'"><a href="#sign_up" id="'+module_arr[j].id+'"><div class="mdl-card__title mdl-card--expand" style="background-size: cover;width: 256px;height: 256px;"><h2 class="mdl-card__title-text">'+module_arr[j].name+'</h2></div></a></div>';
						}
						
					}path = '';
				}
				out +='</div>';

			}
			
			$('#domain').empty();
			$('#domain').append(out);
		}

		
	});
	

	
</script>
</html>