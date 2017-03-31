<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Assistant Management.</strong>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Options.
					<span class="caret"></span>
				</button>
				<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
					<li><a href="/user/assistant_create" id="">Add an Assistant</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="users-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>User Name</th>
					<th>email</th>
					<th>First Name</th>
					<th>Last Name </th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				{list}
				<tr class="odd gradeX" data-id="{id}">
					<td>{id}</td>
					<td>{username}</td>
					<td>{email}</td>
					<td>{first_name}</td>
					<td>{last_name}</td>
					<td class="text-center"> <div class="btn-group">
						<a href="/user/assistant_status/{id}" class="btn {colour} btn-xs" title="Suspend/Unsuspend"><span class="glyphicon {icon}"></span></a>
						<a href="/user/assistant_edit/{id}" class="btn btn-info btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="/user/assistant_delete/{id}" class="btn btn-danger btn-xs" data-confirm="Are you sure you want to delete username {username}?"><span class="glyphicon glyphicon-trash"></span></a>
					</div></td>
				</tr>
				{/list}
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function() 
	{
		$('#users-list').DataTable
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

