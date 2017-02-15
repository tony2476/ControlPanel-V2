
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Client List.
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="users-list">
					<thead>
						<tr>
							<th>ID</th>
							<th>User Name</th>
							<th>email</th>
							<th>First Name</th>
							<th>Last Name </th>
							<th>Company</th>
							<th>Actions</th>
						</tr>
					</thead>
					{list}<tbody>
					<tr class="odd gradeX">
						<td>{id}</td>
						<td>{username}</td>
						<td>{email}</td>
						<td>{first_name}</td>
						<td>{last_name}</td>
						<td>{company}</td>
						<td class="text-center"> <div class="btn-group">
							<a href="/user/login_as_user/{id}" class="btn btn-info btn-xs" title="Login as this user"><span class="glyphicon glyphicon-user"></span></a>
							<a href="/user/toggle_status/{id}" class="btn btn-success btn-xs" title="Suspend/Unsuspend"><span class="glyphicon glyphicon-pause"></span></a>
							<a href="/user/user_edit/{id}" class="btn btn-info btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
							<a href="#modal-{id}" data-toggle="modal" class="btn btn-danger btn-xs" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
						</div></td>
					</tr>
					{/list}
				</tbody>
			</table>
		</div>
		<!-- /.table-responsive -->
	</div>
	<!-- /.panel-body -->
</div>
</div>

<script>
	$(document).ready(function() {
		$('#users-list').DataTable({
			responsive: true
		});
	});
</script>

