<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Ticket Details.</strong>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Options.
					<span class="caret"></span>
				</button>
				<ul id="menu_select" class="dropdown-menu pull-right" role="menu">
					<li><a href="/tickets/add_response/{Id}" id="">Add a Response</a>
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
					<th>Case Number</th>
					<th>Created Date</th>
					<th>Subject</th>
					<th>Status</th>

				</tr>
			</thead>

			<tbody>

				<tr class="odd gradeX" data-id="{Id}">
					<td>{CaseNumber}</td>
					<td>{CreatedDate}</td>
					<td>{Subject}</td>
					<td>{Status}</td>
				</tr>

			</tbody>
		</table>
	</div>

	<!-- /.table-responsive -->
</div>
<!-- /.panel -->

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Description.</strong>

	</div>
	<div class="panel-body">
		<pre>{Description}</pre>

	</div>
</div>

{ticket_comments}
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Response By: {CreatedById}</strong>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">

		{CommentBody}

	</div>
	<!-- /.table-responsive -->
</div>
{/ticket_comments}
