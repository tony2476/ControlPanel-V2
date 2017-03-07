<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Edit My Profile.</h3>
				</div>
				<div class="panel-body">

					{form_open}
					<fieldset>
						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">First Name</label>
							<div class="col-xs-9">
								<input class="form-control" value="{FirstName}" placeholder="First Name" name="FirstName" type="text" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Last Name</label>
							<div class="col-xs-9">
								<input class="form-control" value="{LastName}" placeholder="Last Name" name="LastName" type="text" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Street</label>
							<div class="col-xs-9">
								<input class="form-control" value="{MailingStreet}" placeholder="Street" name="MailingStreet" type="text" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">City</label>
							<div class="col-xs-9">
								<input class="form-control" value="{MailingCity}" placeholder="City" name="MailingCity" type="username" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">State</label>
							<div class="col-xs-9">
								<input class="form-control" value="{MailingState}" placeholder="State" name="MailingState" type="username" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Postal Code</label>
							<div class="col-xs-9">
								<input class="form-control" value="{MailingPostalCode}" placeholder="Postal Code" name="MailingPostalCode" type="username" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Country</label>
							<div class="col-xs-9">
								<input class="form-control" value="{MailingCountry}" placeholder="Country" name="MailingCountry" type="username" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Mobile</label>
							<div class="col-xs-9">
								<input class="form-control" value="{MobilePhone}" placeholder="Mobile Phone" name="MobilePhone" type="username" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Email</label>
							<div class="col-xs-9">
								<input class="form-control" value="{Email}" placeholder="Email" name="Email" type="email" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="FirstName">Phone</label>
							<div class="col-xs-9">
								<input class="form-control" value="{Phone}" placeholder="Phone" name="Phone" type="phone" autofocus>
							</div>
						</div>

						<!-- Change this to a button or input when using this as a form -->
						<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
					</fieldset>
					{form_close}

				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Help
				</div>
				<div class="panel-body">
					<p>Edit your Companies Contact Data here.</p>
					<p>You can't edit the Account Status or Your Web Package.  This is here for information only.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>