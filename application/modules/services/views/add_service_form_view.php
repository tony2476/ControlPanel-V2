<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create a New Service.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Short Code">Short Code</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="short_code" name="short_code" value="{short_code}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Description">Description</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="description" name="description" value="{description}" type="text" autofocus>
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
				<label class="control-label col-xs-3" for="Price">Price</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="0.00" name="price" value="{price}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Setup">Setup</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="0.00" name="setup" value="{setup}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Period">Period</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="1" name="period" value="{period}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Cycle">Cycle</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="3" name="cycle" value="{cycle}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Pre Paid">Pre Paid</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="0" name="pre_paid" value="{pre_paid}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Discount">Discount</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="0" name="discount" value="{discount}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Discount Period">Discount Period</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="0" name="discount_period" value="{discount}" type="text" autofocus>
				</div>
			</div>


			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Create</button>
		</fieldset>
		{form_close}

	</div>
</div>