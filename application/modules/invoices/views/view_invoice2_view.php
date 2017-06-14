<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe"></i> Web Services Invoice
				<small class="pull-right">Date: {date}</small>
			</h2>
		</div>
		<!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			From
			<address>
				<strong>Advisornet.</strong><br />
				300 - 34334 Forrest Terrace<br />
				Abbotsford <br />
				BC<br />
				V2S 1G7<br />
				Phone: 1.866.853.2980<br>
				Email: info@advisornet.ca
			</address>
		</div>
		<!-- /.col -->
		<div class="col-sm-4 invoice-col">
			To
			<address>
				<strong>{company_name}</strong><br>
				{address-1}<br>
				{address-1}<br>
				Phone: {phone}<br>
				Email: {email}
			</address>
		</div>
		<!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<b>Invoice #{ID}</b><br />
			<br />
			<b>Order ID:</b> {order_id}<br />
			<b>Payment Due:</b> {due}<br />
			<b>Account:</b> {account_name}<br />
			<b>Status:</b> {status}<br />
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<hr />
	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Service</th>
						<th>Description</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					{invoice_items}
					<tr class="odd gradeX">
						<td>{service}</td>
						<td>{description}</td>
						<td>{price}</td>

					</tr>
					{/invoice_items}
				</tbody>
			</table>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<hr />
	<div class="row">
		<!-- accepted payments column -->
		<div class="col-xs-6">
			<p class="lead">Payment Methods:</p>
			<img src="../../dist/img/credit/visa.png" alt="Visa">
			<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
			<img src="../../dist/img/credit/american-express.png" alt="American Express">
			<img src="../../dist/img/credit/paypal2.png" alt="Paypal">

			<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
				{invoice_notes}
			</p>
		</div>
		<!-- /.col -->
		<div class="col-xs-6">
			<p class="lead">Amount Due {due}</p>

			<div class="table-responsive">
				<table class="table">
					<tr>
						<th style="width:50%">Subtotal:</th>
						<td>${subtotal}</td>
					</tr>
					<tr>
						<th>Tax {tax_name} ({tax_rate}%)</th>
						<td>${tax}</td>
					</tr>
					<tr>
						<th>Shipping:</th>
						<td>${shipping}</td>
					</tr>
					<tr>
						<th>Total:</th>
						<td>${total}</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
			<button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
			</button>
			<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-download"></i> Generate PDF
			</button>
		</div>
	</div>
</section>