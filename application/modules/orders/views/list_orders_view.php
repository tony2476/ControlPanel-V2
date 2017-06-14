<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Invoices.</strong>
	</div>
	
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="orders-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Full Name</th>
					<th>Date</th>
					<th>status</th>
					</tr>
			</thead>

			<tbody>
				{orders}
				<tr class="odd gradeX" data-id="{id}">
					<td>{ID}</td>
					<td>{fullname}</td>
					<td>{date}</td>
					<td>{status}</td>
					<td class="text-center"> 
						<div class="btn-group">
							<a href="/orders/view/{ID}" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye fa-fw"></span></a>
						</div>
					</td>
				</tr>
				{/orders}

			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function() 
	{
		$('#orders-list').DataTable
		({
			responsive: true,
			ordering: true
		});
	});
</script>