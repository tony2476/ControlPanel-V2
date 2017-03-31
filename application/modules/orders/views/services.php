<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Please choose the service.</h3>
	</div>
	<div class="panel-body">
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Account Activation</label>
				<div class="col-xs-9">
					<select class="form-control" name="service" autofocus>
						{services}
						<option value="{short_code}">{description} @ ${price} p/m + ${setup} Setup</option>
						{/services}
					</select>
				</div>
			</div>
			<label class="col-xs-12">Will you be sharing this Website with any other financial advisors?</label>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website"></label>
				<div class="col-xs-9">
					<input class="radio-inline" type="radio" name="shared"  value="yes" > yes
					<input class="radio-inline" type="radio" name="shared"  value="no" checked> no
				</div>
			</div>
		</fieldset>
	</div>
</div>