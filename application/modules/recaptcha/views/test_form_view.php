 <script src='https://www.google.com/recaptcha/api.js'></script>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Test Recaptcha</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="First Name">First Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Last Name">Last Name</label>
				<div class="col-xs-9">
					<input class="form-control" value="" placeholder="last_name" name="last_name" type="text" autofocus >
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Email">Email</label>
				<div class="col-xs-9">
					<input class="form-control" value="" placeholder="Email" name="email" type="email" autofocus>
				</div>
			</div>
			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		<fieldset class="captcha form-wrapper"><legend><span class="fieldset-legend">CAPTCHA</span></legend><div class="fieldset-wrapper"><div class="fieldset-description">This question is for testing whether or not you are a human visitor and to prevent automated spam submissions.</div><input type="hidden" name="captcha_sid" value="4180" />
			
			<div class="g-recaptcha" data-sitekey="{google_site_key}" data-theme="light" data-type="image"></div></div></fieldset>
			{form_close}

		</div>
	</div>