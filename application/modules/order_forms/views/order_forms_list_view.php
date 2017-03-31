<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Order Forms Management.</strong>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Options.
					<span class="caret"></span>
				</button>
				<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
					<li><a href="/order_forms/order_form_create" id="">Add an order form.</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="order-forms-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Status</th>
					<th>url</th>
					<th>Header Title</th>
					<th>Header text</th>
					<th>Service group</th>
					<th>Header enable</th>
					<th>Promo code enable</th>
					<th>Domain enable</th>
					<th>Contact enable</th>
					<th>Options</th>
				</tr>
			</thead>

			<tbody>
				{forms}
				<tr class="odd gradeX" data-id="{id}">
					<td>{ID}</td>
					<td>{status}</td>
					<td>{url}</td>
					<td>{header_title}</td>
					<td>{header_text}</td>
					<td>{service_group}</td>
					<td>{header_enable}</td>
					<td>{promo_code_enable}</td>
					<td>{domain_enable}</td>
					<td>{contact_enable}</td>

					<td class="text-center"> <div class="btn-group">
						<a href="/order_forms/edit_form/{ID}" class="btn btn-info btn-xs" title="Edit This Form?"><span class="fa fa-pencil fa-fw"></span></a>
						<a href="/order_forms/toggle_status/{ID}" class="btn {colour} btn-xs" title="Suspend/Unsuspend"><span class="fa fa-{icon} fa-fw"></span></a>
						<a href="/order_forms/delete_form/{ID}" class="btn btn-danger btn-xs" data-confirm="Are you sure you want to delete the order form {url}?"><span class="fa fa-trash fa-fw"></span></a>
					</div></td>
				</tr>
				{/forms}
			</tbody>
		</table>
	</div>
</div>


<script>
	$(document).ready(function() 
	{
		$('#order-forms-list').DataTable
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