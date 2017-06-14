{form_open}
<div class="panel panel-default">
	<div class="panel-heading">
		<h3>Limited Time Offer!</h3>
	</div>
	<div class="panel-body">
		<img src="/assets/admin/images/header-service.jpg " class="pull-right">
		<p>You are about to SAVE a lot of money on your New website!</p>

		<p>Use the form below to select your website package and receive a <strong>50% DISCOUNT OFF</strong> your monthly administration fee for 6 months.</p>

		<p>PLUS also automatically receive a <strong>DISCOUNT OFF</strong> your one-time setup fee.</p>

		<p>Once your application is submitted, everything will be reviewed by our Support Team and you will receive a confirmation via email that your account has been opened.</p>

		<p>If you have any questions about submitting an application or about the website building process please call 1.866.853.2980 or email: support@advisornet.ca</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Please choose the service.</h3>
	</div>
	<div class="panel-body">
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Account Activation</label>
				<div class="col-xs-9">
					<select class="form-control" name="service" autofocus>
						{services}
						<option value="{short_code}">{description} @ ${price} p/m + ${setup} Setup</option>
						{/services}
					</select>
				</div>
			</div>
			<label class="col-xs-12">Will you be sharing this Website with any other financial advisors?</label>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website"></label>
				<div class="col-xs-9">
					<input class="radio-inline" type="radio" name="shared"  value="yes" > yes
					<input class="radio-inline" type="radio" name="shared"  value="no" checked> no
				</div>
			</div>
		</fieldset>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Your details</h3>
	</div>
	<div class="panel-body">
		<fieldset>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">First Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Last Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Last Name" name="last_name" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Industry Licensing</label>
				<div class="col-xs-9">
					<select id="licensing" name="licensing">
						<option value="">-- Please select one --</option>
						<option value="Mutual Funds Licensed">Mutual Funds Licensed</option>
						<option value="Insurance Licensed">Insurance Licensed</option>
						<option value="Dual Licensed">Dual Licensed</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Dealership</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Dealership" name="dealership" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Company Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Company Name" name="company_name" type="text" autofocus disabled>
				</div>
			</div>
		</fieldset>
	</div>
</div>

{form_close}
