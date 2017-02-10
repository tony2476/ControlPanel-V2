<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
		<h2>Menu Editor</h2>
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<p>This is just a rough test of the features.  You can save and it posts to the server.</p>  

					<p>The add button loads the modal (click anywhere else to dismiss).</p>

					<p>If you want to add an icon before a title please use this format;</p>
					<p><pre>&lti class="fa fa-sign-out fa-fw">&lt/i> Logout</pre></p>
					<br />
					<div>
						<button id="btn-save" class="btn btn-default" type="submit">Save</button>
						<button class="btn btn-success" type="button" tabindex="-1" id="additemmodalbutton" value="All" data-toggle="modal" data-target="#additemmodal">Add</button>

					</div>
					<div id="editmenu">
						<ul id="rootul">
							<li id="Item_1"><a href="#"><i class="fa fa-home fa-fw" ></i>Home</a><ul></ul></li>
							<li ><a href="#"><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></a>
								<ul>
									<li id="Item_2"><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a><ul></ul></li>
									<li id="Item_3"><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a><ul></ul></li>
									<li id="Item_4"><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a><ul></ul></li>
								</ul>

							</li>
							<li id="Item_5">Item 3<ul></ul><span</li>
							<li id="Item_6">Item 4<ul></ul></li>
							<div id="menuend"></div>
						</ul>
					</div>
				</div>
				<div class="col-md-2"></div>
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
									<label for="icon"><span class="fa fa-photo fa-fw"></span> Icon</label>
									<input type="text" class="form-control" id="icon" placeholder="Enter Icon Name">
								</div>
								<div class="form-group">
									<label for="title"><span class="fa fa-tag fa-fw"></span> Title</label>
									<input type="text" class="form-control" id="title" placeholder="Enter Title">
								</div>
								<div class="form-group">
									<label for="link"><span class="fa fa-link fa-fw"></span> Link</label>
									<input type="text" class="form-control" id="link" placeholder="Enter Link">
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="" checked>Footer Bar</label>
								</div>
								<button id="addBtn" class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Add</button>
							</form>
						</div>
						<div class="modal-footer">
							Footer
						</div>
					</div>

				</div>
			</div> 
		</div>

		<div class="container">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<h2>Results from AJAX Post will be shown here.</h2>
				<h2>When you click save.</h2>
				<div id="results">
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>

<script type="text/javascript">
	// When page has loaded.
	$(document).ready(function()
	{
		// Setup Modal Button
		$("#additemmodalbutton").click(function()
		{
			document.getElementById('title').value = '';
			document.getElementById('link').value = '';
			$("#addItemModal").modal();
		});
		// Setup Delete 
		$(".deleteMe").on("click", function()
		{
			$(this).closest("li").remove();
			console.log("DELETING ITEM") ;
		});
		// Setup Sortable
		$("#editmenu ul").sortable
		({
			connectWith: "#editmenu ul",
			revert: true,
			helper: 'clone',
			appendTo: '#rootul',
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		});

		// Add New Item
		$("#addBtn").click(function(e)
		{
			e.preventDefault();
			var title = $('#title').val();
			var link = $('#link').val();

			var context = $('#editmenu');
			children = context.find('li');
			count = children.length;
			count++;

			$( '<li id="Item_' + count + '"><a href="' + link + '">' + title + '</a> <span onmouseover=""  class="button-span pointer pull-right" onclick="Delete(this);"><i class="colorblue fa fa-trash fa-fw"></i></span><span onmouseover=""  class="button-span pointer pull-right" onclick="Edit(this);"><i class="colorblue fa fa-edit fa-fw"></i></span> <ul><i class="fa fa-clone fa-fw"></i></ul></li>' ).insertBefore( $( "#menuend" ) );


			// Reset sortable to add the new item
			$("#editmenu ul").sortable({
				connectWith: "#editmenu ul",
				placeholder: "ui-state-highlight",
				forcePlaceholderSize:true
			});

			// Close the Modal
			$('#addItemModal').modal('hide');
		});

		function Delete(currentEl)
		{
			currentEl.parentNode.parentNode.removeChild(currentEl.parentNode);
		}

		function Edit(currentEl)
		{
			//currentEl.parentNode.parentNode.removeChild(currentEl.parentNode);
			link = ($('a', currentEl.parentNode).attr('href'));
			title = ($('a', currentEl.parentNode).text());

			console.log (link + " " + title)
			document.getElementById('title').value = title;
			document.getElementById('link').value = link;
			$('#addItemModal').modal('show');
			currentEl.parentNode.parentNode.removeChild(currentEl.parentNode);
		}


		// Save
		$('#btn-save').click(function(e) { 
			e.preventDefault();


			//var HTML = (document.all['editmenu'].outerHTML);
			var HTML = document.getElementById("editmenu");
			var $data = 'menu=' + escape(HTML.outerHTML);
			console.log(HTML);
			$.ajax({
				url:"/menu_editor/ajax",
				type:"post",
				dataType:"html",
				data:$data,
				success:function(obj){
					document.getElementById("results" ).innerHTML =  obj;
					console.log(obj)
				}
			});
		});
	});
</script>