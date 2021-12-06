<script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
<button class="submit">submit</button>

<script type="text/javascript">
	$(document).ready( function() {
		$('.submit').click(function (e) {
			$.post('http://127.0.0.1:1880/send_mail/',{
				'payload' : "smtp",
				'topic' : 'Sent from krishnakant',
		        'from' : "noreply@evomata.com",
		        'to' : "krishnakant@evomata.com",
		        'desc' : "sent from node red."
			},function (d,s,x) {

			},'text')
		});
	});
</script>