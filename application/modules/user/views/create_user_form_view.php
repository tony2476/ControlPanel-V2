<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Create a New User.</h3>
				</div>
				<div class="panel-body">

					{form_open}
					<fieldset>
						<div class="form-group">
							<input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="Last Name" name="last_name" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="Company" name="company" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="Username" name="username" type="username" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
						</div>

						<div class="form-group">
							<input class="form-control" placeholder="Password" name="password" type="password" value="">
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="Password" name="password_repeat" type="password" value="">
						</div>

						<!-- Change this to a button or input when using this as a form -->
						<button class="btn btn-lg btn-success btn-block" type="submit">Create</button>
					</fieldset>
					{form_close}
					
				</div>
			</div>
		</div>
	</div>
</div>