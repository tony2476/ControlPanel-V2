<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create a New RBACL Entry.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<input class="form-control" placeholder="Role Name" name="role_name" type="text" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Path" name="path" type="text" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Group Name" name="group_name" type="text" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Description" name="description" type="text" autofocus>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Create</button>
		</fieldset>
		{form_close}

	</div>
</div>
