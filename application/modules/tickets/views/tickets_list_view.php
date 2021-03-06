<div class="panel panel-default">
	<div class="panel-heading">
		<strong>User list and Management.</strong>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Options.
					<span class="caret"></span>
				</button>
				<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
					<li><a href="/user/create" id="">Add a User</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="tickets-list">
			<thead>
				<tr>
					<th>Case Number</th>
					<th>Created Date</th>
					<th>Closed Date</th>
					<th>Subject</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				{tickets}
				<tr class="odd gradeX" data-id="{Id}">
					<td>{CaseNumber}</td>
					<td>{CreatedDate}</td>
					<th>{ClosedDate}</th>
					<td>{Subject}</td>
					<td>{Status}</td>
					<td class="text-center"> <div class="btn-group"><a href="/tickets/ticket_view/{Id}/" class="btn btn-info btn-xs" title="Edit"><span class="fa fa-edit fa-fw"></span></a></div></td>
				</tr>
				{/tickets}
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function() 
	{
		$('#tickets-list').DataTable
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

