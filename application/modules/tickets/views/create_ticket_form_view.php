<div class="container">
	<div class="row">
		<div class="col-md-8">
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



						<!-- Change this to a button or input when using this as a form -->
						<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
					</fieldset>
					{form_close}
					
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					{help_title}
				</div>
				<div class="panel-body">
					{help_content}
				</div>
			</div>
		</div>
	</div>