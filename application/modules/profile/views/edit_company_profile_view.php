<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Edit Company Profile.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Account Name</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Name}" placeholder="Account Name" name="first_name" type="text" autofocus disabled>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Website</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Website}" placeholder="Website" name="company" type="text" autofocus disabled>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Company Name</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Company_Name__c}" placeholder="Company Name" name="username" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Street</label>
				<div class="col-xs-9">
					<input class="form-control" value="{BillingStreet}" placeholder="Billing Street" name="username" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">City</label>
				<div class="col-xs-9">
					<input class="form-control" value="{BillingCity}" placeholder="Billing City" name="username" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">State</label>
				<div class="col-xs-9">
					<input class="form-control" value="{BillingState}" placeholder="Billing State" name="username" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Postal Code</label>
				<div class="col-xs-9">
					<input class="form-control" value="{BillingPostalCode}" placeholder="Billing Postal Code" name="username" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Phone</label>
				<div class="col-xs-9">
					<input class="form-control" class="form-control" value="{Phone}" placeholder="Phone" name="username" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Account Status</label>
				<div class="col-xs-9">
					<input class="form-control" value="{AccountStatus__c}" placeholder="Account Status" name="username" type="username" autofocus disabled>
				</div>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>