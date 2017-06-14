<div class="col-xs-1"></div>
<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>Invoice.</strong>

		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<table width="100%" class="table table-striped table-bordered table-hover" id="invoice-header">
				<thead>
					<tr>
						<th>Date</th>
					</tr>
				</thead>

				<tbody>
					
					<tr class="odd gradeX">
						<td>{date}</td>
					</tr>
					
				</tbody>
			</table>
		</div>
	</div>

	<table width="100%" class="table table-striped table-bordered table-hover" id="invoice-items-list">
		<thead>
			<tr>
				<th>Description</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>
			{invoice_items}
			<tr class="odd gradeX">
				<td>{description}</td>
				<td>{price}</td>

			</tr>
			{/invoice_items}
		</tbody>
	</table>

</div>
<div class="col-xs-1"></div>