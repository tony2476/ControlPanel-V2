<div id="page-wrapper">
	<div class="container-fluid">
		<h1 class="page-header">Menu Editor</h1>
		<div class="row">
			<div class="col-lg-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Currently Editing  : </strong> <span id="current_menu">No Menu Selected.</span>
						<div class="pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
									Choose a Menu.
									<span class="caret"></span>
								</button>
								<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
									{menu_list}
									<li><a href="#" id="{menu_name}">{menu_name}</a>
									</li>
									{/menu_list}
									
								</ul>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="pull-right">
							<button id="btn-save" class="btn btn-warning" type="submit">Save</button>
							<button class="btn btn-success" type="button" tabindex="-1" id="additemmodalbutton" value="All" data-toggle="modal" data-target="#additemmodal">Add</button>
						</div>
						<div id="editmenu">
							
							<p>Please choose a menu to edit from the drop down box at the top right of this area.</p>
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
						<p>The add button loads the modal (click anywhere else to dismiss).</p>

						<p>If you want to add an icon before a title please use this format;</p>
						<p>
							<pre>&lti class="fa fa-your-icon-here fa-fw">&lt/i> Logout</pre><br />You can view all the icons here;
							<a href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a>
						</p>

						<p>Menus can only be nested 1 deep.  That is a top level then 1 sub menu.  If you drag a menu item with a submenu onto another menu item the excess items won't be visible.  To recover them move the menu item back to the root level.
						</p>

						<p>Do <strong>not</strong> save! until you are sure the menu is how you want it.  Saving overwrites the original version</p>

						<p>If you make a mistake and want to undo all the changes,  simply refresh your browser</p>

						<p>Please note if you delete a root menu that contains submenus it will delete the submenus as well</p>

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
										<label for="title"><span class="fa fa-tag fa-fw"></span> Title</label>
										<input type="text" class="form-control" id="title" placeholder="Enter Title">
									</div>
									<div class="form-group">
										<label for="link"><span class="fa fa-link fa-fw"></span> Link</label>
										<input type="text" class="form-control" id="link" placeholder="Enter Link">
									</div>
									<div class="form-group">
										<label for="required_role"><span class="fa fa-exclamation fa-fw"></span> Role</label>
										<input type="text" class="form-control" id="required_role" placeholder="Enter Role">
									</div>
									<div class="checkbox">
										<label><input type="checkbox" value="" checked>Footer Bar</label>
									</div>
									<button id="addBtn" class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Add</button>
								</form>
							</div>

						</div>

					</div>
				</div> 
			</div>
		</div>
	</div>

	<!-- Remove this before going live -->
	<div class="">
		<h4>Results from AJAX Post will be shown here.</h4>
		<p>When you click save.</p>
		<div id="results">
		</div>
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
			document.getElementById('required_role').value = '';
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
			var required_role = $('#required_role').val();

			var context = $('#editmenu');
			children = context.find('li');
			count = children.length;
			count++;

			$( '<li id="Item_' + new Date().getTime().toString() + '" data-role="' + required_role + '"><a href="' + link + '">' + title + '</a> <span onmouseover=""  class="button-span pointer pull-right" onclick="Delete(this);"><i class="colorblue fa fa-trash fa-fw"></i></span><span onmouseover=""  class="button-span pointer pull-right" onclick="Edit(this);"><i class="colorblue fa fa-edit fa-fw"></i></span> <ul></ul></li>' ).insertBefore( $( "#menuend" ) );


			// Reset sortable to add the new item
			$("#editmenu ul").sortable
			({
				connectWith: "#editmenu ul",
				placeholder: "ui-state-highlight",
				forcePlaceholderSize:true
			});

			// Close the Modal
			$('#addItemModal').modal('hide');
		});

		// Load
		$('#menu_select a').click(function(e)
		{
			e.preventDefault(e);
			document.getElementById("results" ).innerHTML = "Loading Menu " + ( e.currentTarget.id );
			var $menu = 'menu=' + e.currentTarget.id;
			$.ajax
			({
				url:"/menu_editor/ajax_load",
				type:"post",
				dataType:"html",
				data: $menu,
				success:function(response)
				{
					document.getElementById("editmenu" ).innerHTML =  response;
					document.getElementById("current_menu" ).innerHTML =  e.currentTarget.id;
					console.log(response);
				}
			});
		});

		// Save
		$('#btn-save').click(function(e) 
		{ 
			e.preventDefault(e);
			var HTML = document.getElementById("editmenu");
			var $data = 'menu=' + escape(HTML.innerHTML);
			console.log(HTML);
			$.ajax
			({
				url:"/menu_editor/ajax_save",
				type:"post",
				dataType:"html",
				data:$data,
				success:function(obj)
				{
					document.getElementById("results" ).innerHTML =  obj;
					console.log(obj);
				}
			});
		});
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
			required_role = ($('li', currentEl.parentNode).attr('required_role'));

			console.log (link + " " + title)
			document.getElementById('title').value = title;
			document.getElementById('link').value = link;
			document.getElementById('required_role').value = required_role;
			$('#addItemModal').modal('show');
			currentEl.parentNode.parentNode.removeChild(currentEl.parentNode);
		}
	</script>