<main class="mdl-layout__content">
<div class="mdl-grid">
	<div id="cy" style="border:5px solid #999;width: 100%;height: 80vh;"></div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.1.3/cytoscape.js"></script>
	<!-- <script src="<?php echo base_url().'assets/js/sigma.parsers.json.js'; ?>"></script> -->
	<script>
		var main_data = [];
		<?php
			for ($i=0; $i < count($tags) ; $i++) { 
				echo "main_data.push({data : { id : 't".$tags[$i]->it_id."', label : '".$tags[$i]->it_value."'}});";
			}

			for ($j=0; $j < count($product) ; $j++) { 
				echo "main_data.push({data : { id : 'p".$product[$j]->ip_id."', label : '".$product[$j]->ip_product."'}});";
			}

			for ($k=0; $k < count($customer) ; $k++) { 
				echo "main_data.push({data : { id : 'c".$customer[$k]->ic_id."', label : '".$customer[$k]->ic_name."'}});";
			}

			for ($j=0; $j < count($product) ; $j++) { 
				$pid = $product[$j]->ip_id;
				for ($ij=0; $ij < count($p_tags) ; $ij++) { 
					$ptid = $p_tags[$ij]->ipft_product_id;

					$tgid = $p_tags[$ij]->ipft_tag_id;
					if ($pid==$ptid) {
						echo "main_data.push({data: { id: 'p".$pid."_t".$tgid."', source: 'p".$pid."', target: 't".$tgid."' }});";
					}
				}
			}

			for ($k=0; $k < count($customer) ; $k++) { 
				$cid = $customer[$k]->ic_id;
				for ($ik=0; $ik < count($c_tags) ; $ik++) { 
					$ctid = $c_tags[$ik]->ictp_customer_id;

					$tgid = $c_tags[$ik]->ictp_tag_id;
					if ($cid==$ctid) {
						echo "main_data.push({data: { id: 'c".$cid."_t".$tgid."', source: 'c".$cid."', target: 't".$tgid."' }});";
					}
				}
			}

			

		?>
		// {data: { id: 'ab', source: 'a', target: 'b' }}

		console.log(JSON.stringify(main_data));

		var cy = cytoscape({
			container:document.getElementById('cy'),
			elements: main_data,
			style: [{
				selector: 'node',
				style: {
					'background-color': 'red',
					'label': 'data(label)'
				}
			},{
				selector: 'edge',
				style: {
					'width': 3,
					'line-color': '#ccc',
					'target-arrow-color': '#ccc',
					'target-arrow-shape': 'triangle'
				}
			}],
			layout: {
				name: 'grid',
				rows: 1
			}
		});
	 </script>
</div>
</div>
</div>
</body>
</html>