<div class="login-panel panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Edit User.</h3>
	</div>
	<div class="panel-body">

		{form_open}
		<fieldset>
			<div class="form-group">
				<input class="form-control" value="{first_name}" placeholder="First Name" name="first_name" type="text" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" value="{last_name}" placeholder="Last Name" name="last_name" type="text" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" value="{company}" placeholder="Company" name="company" type="text" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" value="{username}" placeholder="Username" name="username" type="username" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" value="{email}" placeholder="E-mail" name="email" type="email" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Password (Leave blank if no change.)" name="password" type="password" value="">
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Password Repeat" name="password_repeat" type="password" value="">
			</div>
			<div class="form-group">
				<input type="checkbox" name="is_admin" value="is_admin" {is_admin}> Administrator?<br>
			</div>

			<!-- Change this to a button or input when using this as a form -->
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{form_close}

	</div>
</div>
