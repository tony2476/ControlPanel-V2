<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Instructions</h3>
	</div>
	<div class="panel-body">
		<p>To add a new development vhost you need to select a username.  The username will be prefixed to the domain name dpsys.ca to give the full hostname.</p>

		<p>For example,  if you use test2 as the username.  The hostname will be test2.dpsys.ca.  The database name and database username will be test2</p>

		<p> The password will be used to create both the database user, and the system user used for SFTP. </p>

		<p>The suspend option will simply remove the vhost configuration from apache but leave all the data intact so you can re-enable it at a later date</p>

		<p>The Delete option removes the system user, the apache vhost and all the files for that vhost.  Be sure you are ok to lose everything before clicking this.</p>

		<p>Please NOTE:  The database is not removed by the delete vhost option.</p>

		<p>For the password please only use upper and lower case letters and numbers.  Some symbols cause problem in the ssh Tunnel.  I will have a think about this and come back to it</p>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Development VHost Management.</strong>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Options.
					<span class="caret"></span>
				</button>
				<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
					<li><a id="addVhostButton" href="/dev/vhost_create" id="">Add a Development VHost</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="vhost-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>User Name</th>
					<th>Password</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				{list}
				<tr class="odd gradeX" data-id="{id}">
					<td>{ID}</td>
					<td>{username}</td>
					<td>{password}</td>
					<td class="text-center"> <div class="btn-group">
						<a href="/dev/status/{ID}" class="btn {colour} btn-xs" title="Suspend/Unsuspend"><span class="glyphicon {icon}"></span></a>
						<a href="/dev/vhost_delete/{ID}" class="btn btn-danger btn-xs" data-confirm="Are you sure you want to delete vhost {username}?"><span class="glyphicon glyphicon-trash"></span></a>
					</div></td>
				</tr>
				{/list}
			</tbody>
		</table>
	</div>
</div>


<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="addVhostModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					Header
				</div>
				<div class="modal-body">
					{form_open}

					<fieldset>

						<div class="form-group">
							<label class="control-label col-xs-3" for="username"> Username</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" id="username" name="username" placeholder="username / vhost name" required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="title"> Password</label>
							<div class="col-xs-9">
								<input type="password" class="form-control" name="password" id="password" placeholder="Enter Title" required>
							</div>
						</div>

					</fieldset>

					<button type="submit" id="saveVhostButton"  class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Add</button>

					{form_close}
				</div>
			</div>
		</div>
	</div> 
</div>

<script type="text/javascript">
	// When page has loaded.
	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false });

		$("#addVhostButton").click(function(e)
		{
			e.preventDefault();
			$("#addVhostModal").modal();
		});
	});

	$(document).ready(function() 
	{
		$('#vhost-list').DataTable
		({
			responsive: true,
			ordering: true
		});
	});

	$(document).ready(function() {
		$('a[data-confirm]').click(function(ev) {
			var href = $(this).attr('href');
			if (!$('#dataConfirmModal').length) {
				$('body').append('<div class="container"><div id="dataConfirmModal" class="modal fade" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><a class="btn btn-default btn-success btn-block" id="dataConfirmOK"><span class="fa fa-trash fa-fw"></span> Delete</a></div></div></div></div></div>');
			} 
			$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
			$('#dataConfirmOK').attr('href', href);
			$('#dataConfirmModal').modal({show:true});
			return false;
		});
	});
</script>