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
							<li><a href="/services/add_service" id="">Add a Service</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="services-list">
					<thead>
						<tr>
							<th>ID</th>
							<th>Status</th>
							<th>Short Code</th>
							<th>Description</th>
							<th>Service Group</th>
							<th>Price</th>
							<th>Setup</th>
							<th>Period</th>
							<th>Cycle</th>
							<th>Pre Paid</th>
							<th>Discount</th>
							<th>Discount Period</th>
							<th>Options</th>
						</tr>
					</thead>
					
					<tbody>
					{services}
						<tr class="odd gradeX" data-id="{id}">
							<td>{ID}</td>
							<td>{status}</td>
							<td>{short_code}</td>
							<td>{description}</td>
							<td>{service_group}</td>
							<td>${price}</td>
							<td>${setup}</td>
							<td>{period}</td>
							<td>{cycle}</td>
							<td>{pre_paid}</td>
							<td>{discount}</td>
							<td>{discount_period}</td>
							<td class="text-center"> <div class="btn-group">
								<a href="/services/toggle_status/{id}" class="btn btn-success btn-xs"><span class="fa fa-pause fa-fw"></span></a>
								<a href="/services/clone/{ID}" class="btn btn-info btn-xs"><span class="fa fa-clone fa-fw"></span></a>
								
							</div></td>
						</tr>
						{/services}
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
		$('#services-list').DataTable
		({
			responsive: true,
			ordering: true
		});
	});
</script>

