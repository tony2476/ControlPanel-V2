
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Client List.
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>User Name</th>
							<th>email</th>
							<th>First Name</th>
							<th>Last Name </th>
							<th>Company</th>
						</tr>
					</thead>
					{list}<tbody>
					<tr class="odd gradeX">
						<td>{username}</td>
						<td>{email}</td>
						<td>{first_name}</td>
						<td>{last_name}</td>
						<td>{company}</td>
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
		$('#dataTables-example').DataTable({
			responsive: true
		});
	});
</script>