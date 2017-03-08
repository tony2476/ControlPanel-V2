<div class="row"  style="margin: 10px;" id="flash_message">
	<div class="alert alert-success" role="alert-success">
		<!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->
		<a class="close" onclick="$('#flash_message').slideUp()">×</a>  
		<div id="message">Saved</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>Currently Editing  : </strong> <span id="current_menu">{path}</span>
			</div>
			<div class="panel-body">
				<textarea id="content">{content}</textarea>
			</div>
			<div class="panel-footer clearfix">
				<div class="btn-group pull-right">
					<a class="btn btn-warning btn-sm" href="/help_editor/help_list">Return to list.</a>
					<button id="btn-save" class="btn btn-success btn-sm" type="submit">Save</button>
					
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
				$('#flash_message').slideDown();
				console.log(obj);
			}
		});
	});
</script>

