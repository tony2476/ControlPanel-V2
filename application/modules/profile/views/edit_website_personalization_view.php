<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Personalization.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Advisor Photo Provided</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Photo_Provided__c}" placeholder="Account Name" name="first_name" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Advisor Profile Provided</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Profile_Provided__c}" placeholder="Domain Name" name="last_name" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Dealership</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Web_Package__c}" placeholder="Website" name="company" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Branding</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Branding__c}" placeholder="Company Name" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Website Live Date</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Website_Live_Date__c}" placeholder="Billing Street" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Secure_Forms Email</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Secure_Forms_Email__c}" placeholder="Billing City" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">E-Newsletter From Address</label>
				<div class="col-xs-9">
					<input class="form-control" value="{E_News_From_Address__c}" placeholder="Billing State" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Business Logo</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Business_Logo__c}" placeholder="Billing Postal Code" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Footer Disclaimer</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Footer_Disclaimer__c}" placeholder="Phone" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Website Disclaimer</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Web_Disclaimer__c}" placeholder="Account Status" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Privacy Policy</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Web_Privacy__c}" placeholder="Web Package" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">CASL Consent</label>
				<div class="col-xs-9">
					<input class="form-control" value="{CASL_Consent__c}" placeholder="Domain Name" name="last_name" type="text" autofocus>
				</div>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>
