<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>Services.</strong>
				<div class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							Options.
							<span class="caret"></span>
						</button>
						<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
							<li><a href="/services/add_service" id="">Add a Service Group</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="service-groups-list">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Description</th>
							<th>Options</th>
						</tr>
					</thead>
					
					<tbody>
					{service_groups}
						<tr class="odd gradeX" data-id="{id}">
							<td>{ID}</td>
							<td>{name}</td>
							<td>{description}</td>
							<td class="text-center"> <div class="btn-group">
								<a href="/services/toggle_status/{ID}" class="btn btn-success btn-xs"><span class="fa fa-pause fa-fw"></span></a>
								<a href="/services/clone/{ID}" class="btn btn-info btn-xs"><span class="fa fa-clone fa-fw"></span></a>
								<a href="/services/disable/{ID}" class="btn btn-danger btn-xs"><span class="fa fa-clone fa-fw"></span></a>
							</div></td>
						</tr>
						{/service_groups}
					</tbody>
				</table>
			</div>
			<!-- /.table-responsive -->
		</div>
		<!-- /.panel-body -->
	</div>
</div>

<script>
	$(document).ready(function() 
	{
		$('#service_groups-list').DataTable
		({
			responsive: true,
			ordering: true
		});
	});
</script>