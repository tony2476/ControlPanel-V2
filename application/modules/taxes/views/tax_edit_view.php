<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Edit Tax Rate.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				
				<div class="col-xs-9">
					<input class="form-control" value="{ID}" name="ID" type="hidden" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Province">Province</label>
				<div class="col-xs-9">
					<input class="form-control" value="{province}" name="province" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Description">Description</label>
				<div class="col-xs-9">
					<input class="form-control" value="{description}"  name="description" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Rate">Rate</label>
				<div class="col-xs-9">
					<input class="form-control" type="number" min="0" max="100" step="0.01" value="{rate}"  name="rate" autofocus>
				</div>
			</div>


			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>