<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Package Details</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Account Activation</label>
				<div class="col-xs-9">
					<input class="form-control" value="{AccountStatus__c}" placeholder="Account Name" name="first_name" type="text" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Account Name</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Name}" placeholder="Domain Name" name="last_name" type="text" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Website Package</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Web_Package__c}" placeholder="Website" name="company" type="text" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Drupal Site Status</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Drupal_Site_Status__c}" placeholder="Company Name" name="username" type="username" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Website Live Date</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Website_Live_Date__c}" placeholder="Billing Street" name="username" type="username" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Development Site</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Development_Site__c}" placeholder="Billing City" name="username" type="username" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Theme Name</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Theme_Name__c}" placeholder="Billing State" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Theme Color</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Theme_Color__c}" placeholder="Billing Postal Code" name="username" type="username" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Client Website Access</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Client_Website_Access__c}" placeholder="Phone" name="username" type="username" autofocus disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">AdvisorNet DNS?</label>
				<div class="col-xs-9">
					<input class="form-control" value="{AdvisorNet_DNS__c}" placeholder="Domain Name" name="last_name" type="text" autofocus disabled>
				</div>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>
