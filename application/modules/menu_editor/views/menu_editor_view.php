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
							<br /><br /><br /><br />
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
							<pre>fa fa-your-icon-here fa-fw</pre><br />You can view all the icons here;
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
										<label for="icon"><span class="fa fa-tag fa-fw"></span> Icon</label>
										<input type="text" class="form-control" id="icon" placeholder="Edit Icon">
									</div>
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
										<label><input id="addbar" type="checkbox" name="separator" value="" >Separator Bar</label>
									</div>
									<button id="addBtn" class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Add</button>
								</form>
							</div>
						</div>
					</div>
				</div> 
			</div>

			<div class="container">
				<!-- Modal -->
				<div class="modal fade" id="editItemModal" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								Header
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<label for="editicon"><span class="fa fa-tag fa-fw"></span> Icon</label>
										<input type="text" class="form-control" id="editicon" placeholder="Edit Icon">
									</div>
									<div class="form-group">
										<label for="title"><span class="fa fa-tag fa-fw"></span> Title</label>
										<input type="text" class="form-control" id="edittitle" placeholder="Enter Title">
									</div>
									<div class="form-group">
										<label for="link"><span class="fa fa-link fa-fw"></span> Link</label>
										<input type="text" class="form-control" id="editlink" placeholder="Enter Link">
									</div>
									<div class="form-group">
										<label for="required_role"><span class="fa fa-exclamation fa-fw"></span> Role</label>
										<input type="text" class="form-control" id="editrequired_role" placeholder="Enter Role">
									</div>
									<div class="form-group">
										<input type="hidden" class="form-control" id="editid" placeholder="Enter Role">
									</div>
									<div class="checkbox">
										<label><input id="editbar" type="checkbox" name="separator" value="" >Add A Separator Bar</label>
									</div>
									<button id="editBtn" class="btn btn-default btn-success btn-block"><span class="fa fa-plus fa-fw"></span> Edit</button>
								</form>
							</div>
						</div>
					</div>
				</div> 
			</div>


		</div>
	</div>


</div>

<script type="text/javascript">
	// When page has loaded.
	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false });

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
			//console.log("DELETING ITEM") ;
		});

		// Setup Sortable
		$("#editmenu ul").sortable
		({
			connectWith: "#editmenu ul",
			revert: true,
			helper: 'clone',
			appendTo: '#menuend',
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		});

		// Edit Item
		$("#editBtn").click(function(e)
		{
			e.preventDefault();
			var title = $('#edittitle').val();
			var link = $('#editlink').val();
			
			
			var icon = $('#editicon').val();
			var required_role = $('#editrequired_role').val();

			var context = $('#editmenu');

			// Get the id of the menu item we want to edit.
			menu_id = document.getElementById('editid').value;
			// Get the id of the menu item we want to edit.
			menu_item = document.getElementById(menu_id);
			
			// Clear the first <a> tag so we can replace it.
			menu_item.getElementsByTagName('a')[0].outerHTML ='';

			// Create a new <a> tag
			var newlink = document.createElement('a'); 
			// Create a new <i> tag for the icon
			var newicon = document.createElement('i');
			// Create a new text node for the tile and insert it.
			var newlinktitle = document.createTextNode(title);
			// Create a new attribute container called href
			var newhref = document.createAttribute('href');
			// Set the new href attribute value
			newhref.value = link;
			// Place the href attribute container in the <a> link
			newlink.setAttributeNode(newhref);
			
			// Set the Classes for the <i> tag
			newicon.className = icon;
			
			// insert the icon into the <a> tag
			newlink.appendChild(newicon);
			// insert the text node into the <a> Tag after the icon <i> tag
			newlink.appendChild(newlinktitle);

			// insert the new node into the menu at the current position.
			menu_item.insertBefore(newlink, menu_item.childNodes[0]);

			var role = document.createAttribute('data-role');
			role.value = required_role;
			menu_item.setAttributeNode(role);
			if (document.getElementById('editbar').checked) {
				var bar = document.createElement('li');
				bar.className = 'divider';
				var barline = document.createElement('i');
				bar.appendChild(barline);
				
				$( '<span onmouseover="" class="button-span pointer pull-right" onclick="Delete(this);"><i class="colorblue fa fa-trash fa-fw"></i></span>' ).insertAfter(barline);
				menu_item.parentNode.appendChild(bar);
			}
			// Reset sortable to add the edtied item
			$("#editmenu ul").sortable
			({
				connectWith: "#editmenu ul",
				revert: true,
				helper: 'clone',
				appendTo: '#menuend',
				placeholder: "ui-state-highlight",
				forcePlaceholderSize:true
			});

			// Close the Modal
			$('#editItemModal').modal('hide');
		});
		$('.my').iconpicker();
		// Add New Item
		$("#addBtn").click(function(e)
		{
			e.preventDefault();
			var icon = $('#icon').val();
			var title = $('#title').val();
			var link = $('#link').val();
			var required_role = $('#required_role').val();

			var context = $('#editmenu');
			children = context.find('li');
			count = children.length;
			count++;

			$( '<li id="Item_' + new Date().getTime().toString() + '" data-role="' + required_role + '"><a href="' + link + '"><i class="' + icon + '"></i>' + title + '</a> <span onmouseover=""  class="button-span pointer pull-right" onclick="Delete(this);"><i class="colorblue fa fa-trash fa-fw"></i></span><span onmouseover=""  class="button-span pointer pull-right" onclick="Edit(this);"><i class="colorblue fa fa-edit fa-fw"></i></span> <ul></ul></li>' ).insertBefore( $( "#menuend" ) );
			
			if (document.getElementById('addbar').checked)  
			{
				$( '<li class="divider-editor"><span onmouseover="" class="button-span pointer pull-right" onclick="Delete(this);"><i class="colorblue fa fa-trash fa-fw"></i></span></li>' ).insertBefore( $( "#menuend" ) );
			}
			// Unset it so it can be used again.
			document.getElementById('addbar').checked = false;

			// Reset sortable to add the new item
			$("#editmenu ul").sortable
			({
				connectWith: "#editmenu ul",
				revert: true,
				helper: 'clone',
				appendTo: '#menuend',
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
			//document.getElementById("results" ).innerHTML = "Loading Menu " + ( e.currentTarget.id );
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
					// Reset sortable to add the new item
					$("#editmenu ul").sortable
					({
						connectWith: "#editmenu ul",
						revert: true,
						cache: false,
						helper: 'clone',
						appendTo: '#menuend',
						placeholder: "ui-state-highlight",
						forcePlaceholderSize:true,
						stop: function(ev, ui) {
							if ($(ui.item).find("li").length > 0)
							{						
								$(this).sortable("cancel");
							}
						}
					});
					//console.log(response);
				}
			});
		});

		// Save
		$('#btn-save').click(function(e) 
		{ 
			e.preventDefault(e);
			var HTML = document.getElementById("editmenu");
			var $data = 'menu=' + escape(HTML.innerHTML);
			//console.log(HTML);
			$.ajax
			({
				url:"/menu_editor/ajax_save",
				type:"post",
				dataType:"html",
				data:$data,
				success:function(obj)
				{
					//document.getElementById("results" ).innerHTML =  obj;
					//console.log(obj);
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
	link = ($('a', currentEl.parentNode).attr('href'));
	icon = ($('i', currentEl.parentNode).attr('class'));
	title = ($(currentEl.parentNode).find('a').first().text());
	
	if (currentEl.parentNode.getElementsByTagName('i').length >=3 )
	{
		icon = ($('i', currentEl.parentNode).attr('class'));
	}
	else
	{
		icon = '';
	}
	
	if (currentEl.parentNode.hasAttribute('data-role')) 
	{
		required_role = currentEl.parentNode.getAttributeNode('data-role').value;
		//console.log (required_role);
	}
	else
	{
		required_role = 'none';
	}
	//console.log (required_role);
	document.getElementById('edittitle').value = title;
	document.getElementById('editlink').value = link;
	document.getElementById('editicon').value = icon;
	document.getElementById('editrequired_role').value = required_role;
	document.getElementById('editid').value = currentEl.parentNode.id;
	document.getElementById('editbar').checked = false;
	$('#editItemModal').modal('show');
	

}
</script>