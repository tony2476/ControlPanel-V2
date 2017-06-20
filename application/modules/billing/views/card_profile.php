<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Your details</h3>
	</div>
	<div class="panel-body">
		<fieldset>
			{form_open}
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Name as it appears on Card</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="First Name" value="{cardname}" name="cardname" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Address">Address</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Your Address" value="{address}" name="address" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="City">City</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="City" value="{city}" name="city" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Province">Province</label>
				<div class="col-xs-9">
					{province_dropdown}
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-xs-3" for="Postal Code">Postal Code</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Postal Code" value="{postal_code}" name="postal_code" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Email">Email</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="your@email.com" value="{email}" name="email" type="email" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Phone">Phone</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Phone" value="{phone}" name="phone" type="text" autofocus required>
				</div>
			</div>
		</fieldset>
		<div class="control-group">
		<button class="btn btn-lg btn-success btn-block" type="submit">Save Payment Profile</button>
		</div>
		{form_close}
	</div>
</div>
