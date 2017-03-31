<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Edit My Profile.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">E-Newsletter Theme</label>
				<div class="col-xs-9">
					<input class="form-control" value="{E_News_Template__c}" placeholder="First Name" name="FirstName" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Quarterly E-newsletter Only</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Quarterly_E_Newsletter__c}" placeholder="Last Name" name="LastName" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">E-newsletter Banner Image</label>
				<div class="col-xs-9">
					{banner_image}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">E-newsletter Disclaimer Text</label>
				<div class="col-xs-9">
					<textarea class="form-control" value="" placeholder="City" name="MailingCity" type="username" autofocus>{E_Newsletter_Disclaimer__c}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Birthday E-Card Service</label>
				<div class="col-xs-9">
					<input class="form-control" value="{e_Card_Data__c}" placeholder="State" name="MailingState" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Current Issue</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Drupal_E_news_Current__c}" placeholder="Postal Code" name="MailingPostalCode" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Upcoming Issue</label>
				<div class="col-xs-9">
					<input class="form-control" value="{E_News_Sample__c}" placeholder="Country" name="MailingCountry" type="username" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Important Dates</label>
				<div class="col-xs-9">
					<input class="form-control" value="https://advisornet.ca/manuals/E-Newsletter-Important-Dates.pdf" name="ImportantDates" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Custom Comments Title</label>
				<div class="col-xs-9">
					<input class="form-control" value="{E_News_Custom_Comments_Title__c}" placeholder="Custom Comments Title" name="CustomCommentsTitle" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Custom Comments</label>
				<div class="col-xs-9">
					<input class="form-control" value="{E_News_Custom_Comments__c}" placeholder="Custom Comments." name="CustomComments" type="text" autofocus>
				</div>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}
	</div>
</div>
