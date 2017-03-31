<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create Order Form.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Status</label>
				<div class="col-xs-9">
					<select class="form-control" name="status" autofocus>
						<option value="1">Enabled</option>
						<option value="0">Disabled</option>

					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Url</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="This is the URL of the form." name="url" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Header Title</label>
				<div class="col-xs-9">
					<input class="form-control"  placeholder="This is the title that will appear in the header box area." name="header_title" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Header Text</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="This is the full text/html that will appear in the header box area" name="header_text" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Service Group</label>
				<div class="col-xs-9">
					<select class="form-control" name="service_group" autofocus>
						{service_groups}
						<option value="{ID}">{name}</option>
						{/service_groups}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Header Enable</label>
				<div class="col-xs-9">
					<input class="radio-inline" type="radio" name="header_enable"  value="1" checked> yes
					<input class="radio-inline" type="radio" name="header_enable"  value="0"> no
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Promo Code Enable</label>
				<div class="col-xs-9">
					<input class="radio-inline" type="radio" name="promo_code_enable"  value="1" checked> yes
					<input class="radio-inline" type="radio" name="promo_code_enable"  value="0"> no
				</div>
			</div>						
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Domain Enable</label>
				<div class="col-xs-9">
					<input class="radio-inline" type="radio" name="domain_enable"  value="1" checked> yes
					<input class="radio-inline" type="radio" name="domain_enable"  value="0"> no
				</div>
			</div>						
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Contact Enable</label>
				<div class="col-xs-9">
					<input class="radio-inline" type="radio" name="contact_enable"  value="1" checked> yes
					<input class="radio-inline" type="radio" name="contact_enable"  value="0"> no
				</div>
			</div>
			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>
