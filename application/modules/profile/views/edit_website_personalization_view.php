<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Personalization.</h3>
				</div>
				<div class="panel-body">

					{form_open}
					<fieldset>
						<div class="form-group">
							<label for="Website">Advisor Photo Provided</label>
							<input class="form-control" value="{Photo_Provided__c}" placeholder="Account Name" name="first_name" type="text" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Advisor Profile Provided</label>
							<input class="form-control" value="{Profile_Provided__c}" placeholder="Domain Name" name="last_name" type="text" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Dealership</label>
							<input class="form-control" value="{Web_Package__c}" placeholder="Website" name="company" type="text" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Branding</label>
							<input class="form-control" value="{Branding__c}" placeholder="Company Name" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Website Live Date</label>
							<input class="form-control" value="{Website_Live_Date__c}" placeholder="Billing Street" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Secure_Forms Email</label>
							<input class="form-control" value="{Secure_Forms_Email__c}" placeholder="Billing City" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">E-Newsletter From Address</label>
							<input class="form-control" value="{E_News_From_Address__c}" placeholder="Billing State" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Business Logo</label>
							<input class="form-control" value="{Business_Logo__c}" placeholder="Billing Postal Code" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Footer Disclaimer</label>
							<input class="form-control" value="{Footer_Disclaimer__c}" placeholder="Phone" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Website Disclaimer</label>
							<input class="form-control" value="{Web_Disclaimer__c}" placeholder="Account Status" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">Privacy Policy</label>
							<input class="form-control" value="{Web_Privacy__c}" placeholder="Web Package" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<label for="Website">CASL Consent</label>
							<input class="form-control" value="{CASL_Consent__c}" placeholder="Domain Name" name="last_name" type="text" autofocus>
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