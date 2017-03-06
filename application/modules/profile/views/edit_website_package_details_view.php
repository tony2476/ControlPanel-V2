<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Package Details</h3>
				</div>
				<div class="panel-body">

					{form_open}
					<fieldset>
						<div class="form-group">
							<label for="Website">Account Activation</label>
							<input class="form-control" value="{AccountStatus__c}" placeholder="Account Name" name="first_name" type="text" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Account Name</label>
							<input class="form-control" value="{Name}" placeholder="Domain Name" name="last_name" type="text" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Website Package</label>
							<input class="form-control" value="{Web_Package__c}" placeholder="Website" name="company" type="text" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Drupal Site Status</label>
							<input class="form-control" value="{Drupal_Site_Status__c}" placeholder="Company Name" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Website Live Date</label>
							<input class="form-control" value="{Website_Live_Date__c}" placeholder="Billing Street" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Development Site</label>
							<input class="form-control" value="{Development_Site__c}" placeholder="Billing City" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Theme Name</label>
							<input class="form-control" value="{Theme_Name__c}" placeholder="Billing State" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Theme Color</label>
							<input class="form-control" value="{Theme_Color__c}" placeholder="Billing Postal Code" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Client Website Access</label>
							<input class="form-control" value="{Client_Website_Access__c}" placeholder="Phone" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Domain Registrar</label>
							<input class="form-control" value="{Domain_Registrar__c}" placeholder="Account Status" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Domain Expiry</label>
							<input class="form-control" value="{Domain_Expiry__c}" placeholder="Web Package" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">AdvisorNet DNS?</label>
							<input class="form-control" value="{AdvisorNet_DNS__c}" placeholder="Domain Name" name="last_name" type="text" autofocus>
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