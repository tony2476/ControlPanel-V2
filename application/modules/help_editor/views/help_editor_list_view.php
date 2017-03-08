<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>Help Editor</strong>
				<div class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							Options.
							<span class="caret"></span>
						</button>
						<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="#" data-toggle="modal" data-target="#addItemModal">Add a Help Item</a>
								<!--<a href="/help_editor/add_item" id="">Add a Help Item</a>-->
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="users-list">
					<thead>
						<tr>
							<th>ID</th>
							<th>Path</th>
							<th>Title</th>
							<th>Content</th>
							<th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						{list}
						<tr class="odd gradeX" data-id="{id}">
							<td>{ID}</td>
							<td>{path}</td>
							<td>{title}</td>
							<td>{content}</td>
							<td class="text-center">
								<div class="btn-group">
									<a href="/help_editor/help_edit/{ID}" class="btn btn-info btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="/help_editor/help_delete/{ID}" class="btn btn-danger btn-xs" data-confirm="Are you sure you want to delete help file {title}?"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</td>
						</tr>
						{/list}
					</tbody>
				</table>
			</div>
			<!-- /.table-responsive -->
		</div>
		<!-- /.panel-body -->
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				{help_title}
			</div>
			<div class="panel-body">
				{help_content}
			</div>
		</div>
	</div>
	
</div>


<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="addItemModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					Header
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<label for="path"><span class="fa fa-link fa-fw"></span> Path</label>
							<input type="text" class="form-control" id="path" placeholder="Edit Icon">
						</div>
						<div class="form-group">
							<label for="title"><span class="fa fa-tag fa-fw"></span> Title</label>
							<input type="text" class="form-control" id="title" placeholder="Enter Title">
						</div>
						<button id="addBtn" class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Add</button>
					</form>
				</div>
			</div>
		</div>
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

		$.ajaxSetup({ cache: false });

		// Setup Modal Button
		$("#additemmodalbutton").click(function()
		{
			document.getElementById('path').value = '';
			document.getElementById('title').value = '';
			
			$("#addItemModal").modal();
		});

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

		$("#addBtn").click(function(e)
		{
			e.preventDefault();
			var path = $('#path').val();
			var title = $('#title').val();

			// Close the Modal
			$('#addItemModal').modal('hide');

			$.ajax
			({
				url:"/help_editor/ajax_add",
				type:"post",
				dataType:"html",
				data: 'path=' + path + '&title=' + title, 
				success:function(ID)
				{
					$(location).attr('href', '/help_editor/help_edit/' + ID);
					//document.getElementById("results" ).innerHTML =  obj;
					console.log(ID);
				}
			});
			

			
			
		});

	});
</script>