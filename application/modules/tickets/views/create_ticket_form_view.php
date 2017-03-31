<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create New Ticket.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Subject</label>
				<div class="col-xs-9">
					<input class="form-control" value="" placeholder="A Brief Description." name="subject" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Details</label>
				<div class="col-xs-9">
					<textarea class="form-control" placeholder="A Detailed Description" name="comment" type="text" autofocus></textarea>
				</div>
			</div>

			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>
