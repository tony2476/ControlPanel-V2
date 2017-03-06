<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Edit My Profile.</h3>
				</div>
				<div class="panel-body">

					{form_open}
					<fieldset>
						<div class="form-group">
							<input class="form-control" value="{FirstName}" placeholder="First Name" name="FirstName" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{LastName}" placeholder="Last Name" name="LastName" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{MailingStreet}" placeholder="Street" name="MailingStreet" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{MailingCity}" placeholder="City" name="MailingCity" type="username" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{MailingState}" placeholder="State" name="MailingState" type="username" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{MailingPostalCode}" placeholder="Postal Code" name="MailingPostalCode" type="username" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{MailingCountry}" placeholder="Country" name="MailingCountry" type="username" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{MobilePhone}" placeholder="Mobile Phone" name="MobilePhone" type="username" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{Email}" placeholder="Email" name="Email" type="email" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" value="{Phone}" placeholder="Phone" name="Phone" type="phone" autofocus>
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