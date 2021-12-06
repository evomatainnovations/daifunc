<style type="text/css">
	a {
        color: #fff;
        text-decoration: none;
    }

    a:hover {
        color: #fff;
        text-decoration: none;
    }

    /*html, body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }*/
    
    #products {
        width: 100%;
        text-align: left;
        border: 0px solid #ccc;
        border-collapse: collapse;
    }

    #products > thead > tr {
        box-shadow: 0px 5px 5px #ccc;
    }

    #products > thead > tr > th {
        padding: 10px;
    }

    #products > tbody > tr > td {
        padding: 15px;
    }

    #products > tbody > tr {
        border-bottom: 1px solid #ccc;
    }

    #products > tbody > tr > td {
        color: #666;
        text-decoration: none;
    }

</style>

<main class="mdl-layout__content">
    <div class="mdl-grid">
	    <table id="products">
            <tbody>
                <?php for($i=0; $i<count($ledgers);$i++) {
                    echo '<tr id="'.$ledgers[$i]->iextetacl_id.'"><td>'.$ledgers[$i]->iextetacl_name.'</td></tr>';    
                }
                ?>
                
            </tbody>
        </table>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">add</i>
	</button>
</div>
</div>
</body>
<script>
	$(document).ready(function() {
	    $('#fixed-header-drawer-exp').keyup(function(e) {
            $.post('<?php echo base_url()."Accounting/search_ledgers/".$code; ?>', {
                'keywords' : $(this).val()
            }, function(data, status, xhr) {
                var a = JSON.parse(data), s = ""; $('#products > tbody').empty();
                for (var i = 0; i < a.length; i++) {
                    s+="<tr id='" + a[i].iacl_id + "'><td>" + a[i].iacl_name + "</td></tr>";
                }
                $('#products > tbody').append(s);
            }, "text");
        });

        $('#submit').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Accounting/add_ledger/'.$code; ?>";
        });
        
		$('#products').on('click', 'tr', function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Accounting/ledger_details/'.$code.'/'; ?>" + $(this).prop('id');
		})
	});
</script>
</html>