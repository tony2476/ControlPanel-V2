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
							<th>Price</th>
							<th>Period</th>
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
							<td>${price}</td>
							<td>{period}</td>
							<td class="text-center"> <div class="btn-group">
								<a href="/services/toggle_status/{id}" class="btn btn-success btn-xs"><span class="fa fa-pause fa-fw"></span></a>
								<a href="/services/clone/{id}" class="btn btn-info btn-xs"><span class="fa fa-clone fa-fw"></span></a>
								<a href="/services/disable/{id}" class="btn btn-danger btn-xs"><span class="fa fa-clone fa-fw"></span></a>
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

