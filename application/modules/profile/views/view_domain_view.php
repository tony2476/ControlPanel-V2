<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Domain Details.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="name">Domain Name</label>
				<div class="col-xs-9">

					<p class="form-control-static">{Domain_Name__c}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="expires">Expires</label>
				<div class="col-xs-9">

					<p class="form-control-static">{Domain_Expiry__c}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Domain Registrar</label>
				<div class="col-xs-9">
					<p class="form-control-static">{Domain_Registrar__c}</p>

				</div>
			</div>
		</fieldset>
		{form_close}

	</div>
</div>
