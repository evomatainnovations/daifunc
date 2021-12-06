<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		body{
			background-color: #fff;
			padding: 20px;
			margin: 20px;
		}

		@media only screen and (min-width: 320px) and (max-width: 767px) {
			body {
				margin: 30px;
				padding: 20px;
			}
		}

		@media only screen and (min-width: 768px) and (max-width: 1030px) {
			body {
				margin: 60px;
				padding: 20px;
			}
		}

		html, body, h1, h2, h3, h4, h5, h6, a {
			font-family: 'Muli', sans-serif !important;
			color: #000;
			text-align: center;
		}


		.pic_button {
			border-radius: 10px;
			box-shadow: 0px 4px 10px #ccc;
			padding: 20px;
			position: relative;
			overflow: hidden;
			width: 50%;
			background: rgb(244,67,54);
			color: rgb(255,255,255);
			font-size: 3em;
			box-shadow: 0px 6px 10px #ccc;
			border: 1px;
		}

		h3 {
			font-size: 2em;
		}
	</style>
</head>
<body>
	<img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;">
	<div style="background-color border-radius: 10px; ">
		<h3 style="font-weight: normal; ">Please click on the button to verify your daifunc account.</h3>
		<a href="'.base_url().'Account/reg_verify/'.urlencode($id).'"><button class="btn btn-lg btn-danger pic_button">Verify</button></a>
		<h3 style="font-size: 1em; word-break: break-all;">Please copy and paste '.base_url().'Account/reg_verify/'.urlencode($id).' in the browser.</h3>
	</div>
	<p style="font-size: 0.5em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p>
</body>
</html>

<!-- <!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3 style="font-weight: normal; ">Please click on the button to verify your daifunc account.</h3><a href="'.base_url().'Account/reg_verify/'.urlencode($id).'"><button class="btn btn-lg btn-danger pic_button">Verify</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/reg_verify/'.urlencode($id).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html> -->