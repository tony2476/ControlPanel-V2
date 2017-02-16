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
					{list}
					<tbody>
						<tr class="odd gradeX" data-id="{id}">
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
								<a href=""  data-target="#deleteModal" data-toggle="modal" class="btn btn-danger btn-xs" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
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

<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="deleteModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					Delete User.
				</div>
				<div class="modal-body">
					<form role="form">
						<div> Are you sure you want to delete this user</div>
						<button id="editBtn" class="btn btn-default btn-success btn-block"><span class="fa fa-trash fa-fw"></span> Delete</button>
					</form>
				</div>
			</div>
		</div>
	</div> 
</div>


<script>
	$(document).ready(function() 
	{
		$('#users-list').DataTable
		({
			responsive: true
		});
	});

	$(function()
	{
		$('#deleteModal').modal
		({
			keyboard: true,
			backdrop: "static",
			show:false,

		}).on('show', function()
		{
			var getIdFromRow = $(event.target).closest('tr').data('id'); 
			
			#$(this).find('#orderDetails').html($('<b> Order Id selected: ' + getIdFromRow  + '</b>'))
		});
	});
</script>

