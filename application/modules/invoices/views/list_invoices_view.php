<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Invoices.</strong>
	</div>
	
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="invoices-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Company</th>
					<th>Date</th>
					<th>Due</th>
					<th>status</th>
					<th>total</th>
					<th>Options</th>
				</tr>
			</thead>

			<tbody>
				{invoices}
				<tr class="odd gradeX" data-id="{id}">
					<td>{ID}</td>
					<td>{company_name}</td>
					<td>{date}</td>
					<td>{due}</td>
					<td>{status}</td>
					<td>{total}</td>
					<td class="text-center"> 
						<div class="btn-group">
							<a href="/invoices/view/{ID}" class="btn btn-info btn-xs" title="View"><span class="fa fa-eye fa-fw"></span></a>
						</div>
					</td>
				</tr>
				{/invoices}

			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function() 
	{
		$('#invoices-list').DataTable
		({
			responsive: true,
			ordering: true
		});
	});
</script>