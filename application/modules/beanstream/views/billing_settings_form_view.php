<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Billing Details.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Details 1</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Details 1}" placeholder="Details 1" name="details_1" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="FirstName">Details 2</label>
				<div class="col-xs-9">
					<input class="form-control" value="{Details 2}" placeholder="Details 2" name="details_2" type="text" autofocus>
				</div>
			</div>


			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>

