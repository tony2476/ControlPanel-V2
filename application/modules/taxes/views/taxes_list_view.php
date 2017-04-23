<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Tax Rate Management.</strong>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Options.
					<span class="caret"></span>
				</button>
				<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
					<li><a id="addTaxButton" href="/taxes/create" id="">Add a Tax Rate</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="taxes-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Province</th>
					<th>Description</th>
					<th>Rate</th>
					<th>Options</th>	
				</tr>
			</thead>

			<tbody>
				{taxes}
				<tr class="odd gradeX" data-id="{id}">
					<td>{ID}</td>
					<td>{province}</td>
					<td>{description}</td>
					<td>{rate}</td>
					<td class="text-center"> <div class="btn-group">
						<a href="/taxes/edit/{ID}" class="btn btn-info btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="/taxes/delete/{ID}" class="btn btn-danger btn-xs" data-confirm="Are you sure you want to delete tax rate for  {province}?"><span class="glyphicon glyphicon-trash"></span></a>
					</div></td>
				</tr>
				{/taxes}
			</tbody>
		</table>
	</div>
</div>


<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="addTaxModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					Header
				</div>
				<div class="modal-body">
					{form_open}

					<fieldset>

						<div class="form-group">
							<label class="control-label col-xs-3" for="province"> Province</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" id="province" name="province" placeholder="province" required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="description"> Description</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" name="description" id="description" placeholder="Description GST etc." required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" for="rate"> Rate</label>
							<div class="col-xs-9">
								<input type="number" min="0" max="100" step="0.01" class="form-control" name="rate" id="rate" placeholder="10.99" required>
							</div>
						</div>

					</fieldset>

					<button type="submit" id="saveVhostButton"  class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Add</button>

					{form_close}
				</div>
			</div>
		</div>
	</div> 
</div>

<script type="text/javascript">
	// When page has loaded.
	$(document).ready(function() 
	{
		$('#taxes-list').DataTable
		({
			responsive: true,
			ordering: true
		});
	});

	$(document).ready(function()
	{
		$("#addTaxButton").click(function(e)
		{
			e.preventDefault();
			$("#addTaxModal").modal();
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