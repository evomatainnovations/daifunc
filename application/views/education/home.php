<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
	.mdl-card__title {
		/*height: auto;*/
		height: 170px;
	}
</style>
<main class="mdl-layout__content">
	<!-- <div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp" style="background-color: #ff9933; color: white;padding: 20px;">
				<h3 style="text-align: left;">Count of students in a batch</h3>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff; color: #ff9933;">
						<h5>12th Thakur village</h5>
						<h1>4</h1>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff; color: #ff9933;">
						<h5>12th Thakur village</h5>
						<h1>4</h1>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff; color: #ff9933;">
						<h5>12th Thakur village</h5>
						<h1>4</h1>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff; color: #ff9933;">
						<h5>12th Thakur village</h5>
						<h1>4</h1>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--4-col">
			<div class="">
				<label>Type Section</label>
				<ul id="section" class="mdl-textfield__input">
				</ul>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="">
				<label>Type Data Elements</label>
				<ul id="modules" class="mdl-textfield__input">
				</ul>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="">
				<label>Type the Fields you want in your results</label>
				<ul id="property" class="mdl-textfield__input">
				</ul>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="">
				<label>Type filters</label>
				<ul id="filters" class="mdl-textfield__input">
				</ul>
			</div>
		</div>
		<?php //for ($i=0; $i < count($display) ; $i++) { 
			//print_r($display[$i]);
		//}
		 ?>
	</div>
	<div id="result"></div>
</main>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var section_data = [];
    	<?php
    		for ($i=0; $i < count($section) ; $i++) { 
    			echo "section_data.push('".$section[$i]->ic_section."');";
    		}
    	?>
    	
    	var section = [];
    	var module = [];
    	var prop = [];
    	var filter = [];

    	$('#section').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : section_data,
    		afterTagAdded : (function(event, ui) {
    			section.push(ui.tag[0].innerText);
    			getproperty(section, module, prop, filter);
    		}),
    		afterTagRemoved : (function(event, ui) {
    			section.pop();
    			getproperty(section, module, prop, filter);
    		})
    	});

    	var module_data = [];
    	<?php
    		for ($i=0; $i < count($join_index) ; $i++) { 
    			echo "module_data.push('".$join_index[$i]->iji_name."');";
    		}
    	?>
    	
    	
    	$('#modules').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : module_data,
    		afterTagAdded : (function(event, ui) {
    			module.push(ui.tag[0].innerText);
    			getproperty(section, module, prop, filter);
    		}),
    		afterTagRemoved : (function(event, ui) {
    			module.pop();
    			getproperty(section, module, prop, filter);
    		})
    	});

    	var property_data = [];
    	$('#property').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : property_data,
    		afterTagAdded : (function(event, ui) {
    			prop.push(ui.tag[0].innerText);
    			getproperty(section, module, prop, filter);
    		}),
    		afterTagRemoved : (function(event, ui) {
    			prop.pop();
    			getproperty(section, module, prop, filter);
    		})
    	});

    	var filter_data = [];
    	$('#filters').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : filter_data,
    		afterTagAdded : (function(event, ui) {
    			filter.push(ui.tag[0].innerText);
    			getproperty(section, module, prop, filter);
    		}),
    		afterTagRemoved : (function(event, ui) {
    			filter.pop();
    			getproperty(section, module, prop, filter);
    		})
    	});

    	function getproperty(section, module, prop, filter) {
    		$.post("<?php echo base_url().'Education/query_details'; ?>", {
    			'm' : module,
    			's' : section,
    			'p' : prop,
    			'f' : filter
    		}, function(data, status, xhr) {
    			console.log(data);
    			var abc = JSON.parse(data);
    			console.log(abc);
    			var tbl = "<table border='1'><tr>";

    			for (var i = 0; i < abc.columns.length; i++) {
    				tbl+="<th>" + abc.columns[i] + "</th>";
    			}
    			tbl += "</tr>";

    			for (var i = 0; i < abc.values.length; i++) {
    				tbl += "<tr>";
    				for (var j = 0; j < abc.columns.length; j++) {
    					tbl+="<td>" + abc.values[i][abc.columns[j]];
    				}
    				tbl+="</tr>"
    			}
    			tbl+="</table>";

    			$('#result').html(tbl);
    		}, "text");
    	}
    });
</script>

</html>