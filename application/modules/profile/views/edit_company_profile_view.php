<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Company Profile.</h3>
				</div>
				<div class="panel-body">

					{form_open}
					<fieldset>
						<div class="form-group">
						<label for="Website">Account Name</label>
							<input class="form-control" value="{Name}" placeholder="Account Name" name="first_name" type="text" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Domain Name</label>
							<input class="form-control" value="{Domain_Name__c}" placeholder="Domain Name" name="last_name" type="text" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Website</label>
							<input class="form-control" value="{Website}" placeholder="Website" name="company" type="text" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Company Name</label>
							<input class="form-control" value="{Company_Name__c}" placeholder="Company Name" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Billing Street</label>
							<input class="form-control" value="{BillingStreet}" placeholder="Billing Street" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Billing City</label>
							<input class="form-control" value="{BillingCity}" placeholder="Billing City" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Billing State</label>
							<input class="form-control" value="{BillingState}" placeholder="Billing State" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Billing Postal Code</label>
							<input class="form-control" value="{BillingPostalCode}" placeholder="Billing Postal Code" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Phone</label>
							<input class="form-control" value="{Phone}" placeholder="Phone" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Account Status</label>
							<input class="form-control" value="{AccountStatus__c}" placeholder="Account Status" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
						<label for="Website">Web Package</label>
							<input class="form-control" value="{Web_Package__c}" placeholder="Web Package" name="username" type="username" autofocus>
						</div>
						<!-- Change this to a button or input when using this as a form -->
						<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
					</fieldset>
					{form_close}
					
				</div>
			</div>
		</div>
	</div>
</div>