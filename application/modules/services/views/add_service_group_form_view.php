<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create a New Order Group.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Group Name">Group Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="group_name" name="group_name" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Group Description">Group Description</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="group_description" name="group_description" type="text" autofocus>
				</div>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Create</button>
		</fieldset>
		{form_close}

	</div>
</div>