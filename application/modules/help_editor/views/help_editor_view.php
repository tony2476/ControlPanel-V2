

<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>Currently Editing  : </strong> <span id="current_menu">{path}</span>
			</div>
			<div class="panel-body">
				<textarea id="content">{content}</textarea>
				<div class="pull-right">
					<button id="btn-save" class="btn btn-warning" type="submit">Save</button>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Instructions
			</div>
			<div class="panel-body">
				<p>Select a help file from the drop down men</p>
			</div>
		</div>
	</div>
</div>



<script src="<?=base_url()?>assets/admin/js/tinymce/tinymce.min.js"></script>
<script>
	tinymce.init
	({ 
		selector:'textarea',
		removed_menuitems: 'newdocument',
	});

	// Save
	$('#btn-save').click(function(e) 
	{ 
		e.preventDefault(e);
		var data = tinyMCE.get('content').getContent();

		var url = $(location).attr('href');
		var segments = url.split( '/' );
		var id = segments[5];

		console.log(data);
		$.ajax
		({
			url:"/help_editor/ajax_save",
			type:"post",
			dataType:"html",
			data: 'content=' + data + '&id=' + id,
			success:function(obj)
			{
					//document.getElementById("results" ).innerHTML =  obj;
					console.log(obj);
				}
			});
	});
</script>

