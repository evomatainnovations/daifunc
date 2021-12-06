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
    .general_table > tbody > tr {
        border-bottom: 1px solid #ccc;
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
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
			<h4>Total amount for <?php echo date('F'); ?> month</h4>
			<hr style="width: 80%;margin-left: 10%;">
			<h4 id="inr_amt"></h4>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-shadow--4dp" style="border-radius: 15px;text-align: center;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="from_date" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="from_date">Select From Date</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="to_date" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="to_date">Select To Date</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<button class="mdl-button mdl-button--colored mdl-button--raised filter">Filter</button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<table class="general_table" style="width: 100%;">
				<thead>
					<th>Sr. no.</th>
					<th>Name</th>
					<th>Amount</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</main>
<script type="text/javascript">
	var u_data = [];
	var f_timestamp = 0 ;
	var t_timestamp = 0 ;
	<?php
		for ($i=0; $i < count($u_amount) ; $i++) { 
			$amt = number_format((float)$u_amount[$i]->s_amount, 2, '.', '');
			// if (count($u_status) > 0 ) {
			// 	for ($j=0; $j < count($u_status) ; $j++) { 
			// 		if ($u_status[$j]->iushtxn_uid == $u_amount[$i]->iushtxn_uid ) {
			// 			echo "u_data.push({'id' : '".$u_amount[$i]->i_uid."', 'name' : '".$u_amount[$i]->iud_name."' , 'amount' : '".$amt."' , 'status' : 'Unpaid'});";
			// 		}else{
			// 			echo "u_data.push({'id' : '".$u_amount[$i]->i_uid."', 'name' : '".$u_amount[$i]->iud_name."' , 'amount' : '".$amt."' , 'status' : 'Paid'});";
			// 		}
			// 	}
			// }else{
				echo "u_data.push({'id' : '".$u_amount[$i]->i_uid."', 'name' : '".$u_amount[$i]->iud_name."' , 'amount' : '".$amt."'});";
			// }
		}
	?>
	$(document).ready( function() {
		display_details();
		<?php echo 'var amount = "'.$s_amount.'";'; ?>
		amount = Number(amount);
		document.getElementById('inr_amt').innerHTML = amount.toLocaleString('en-IN', {
		    maximumFractionDigits: 2,
		    style: 'currency',
		    currency: 'INR'
		});

		$('#from_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		$('#to_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		$('.filter').click(function (e) {
			e.preventDefault();
			var f_date = $('#from_date').val();
			var t_date = $('#to_date').val();
			$.post('<?php echo base_url()."Portal/scheme_payout_filter"; ?>',{
				'f_date' : f_date,
				't_date' : t_date
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				u_data = [];
				f_timestamp = a.f_timestamp;
				t_timestamp = a.t_timestamp;
				console.log(a);
				for (var i=0; i < a.u_amount.length ; i++) {
					var amt = Number(a.u_amount[i].s_amount);
					u_data.push({id : a.u_amount[i].i_uid, name : a.u_amount[i].iud_name , amount : parseFloat(amt).toFixed(2)});
				}
				display_details();
			}, "text");
		});

		$('.general_table').on('click','.user_details',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = '<?php echo base_url()."Portal/scheme_payout_details/"; ?>'+id+'/'+f_timestamp+'/'+t_timestamp;
		});
	});
	function display_details(){
			var out = '';
			var srno = 1;
			for (var i = 0; i < u_data.length; i++) {
				out += '<tr class="user_details" id="'+u_data[i].id+'">';
				out += '<td>'+srno+'</td><td>'+u_data[i].name+'</td><td>'+u_data[i].amount+'</td>';
				out += '</tr>';
				srno++;
			}

			$('.general_table > tbody').empty();
			$('.general_table > tbody').append(out);
		}

</script>