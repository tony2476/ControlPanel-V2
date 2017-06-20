<div class="panel panel-default">
<div class="panel-heading" >
		<h3 class="panel-title" >Payment Details</h3>
	</div>

	<div class="panel-body">
		{form_open}

		<div class="row-fluid">
			<div class="col-xs-12">
				<p>By clicking the confirm button you authorize us to charge your card for this service.</p>
			</div>
		</div>
		<hr />

		<div class="row-fluid">
			<div class="col-xs-4">
				<div class="form-group">
					<label for="subtotal">Subtotal</label>
					<div class="input-group">
						<input type="currency" class="form-control" name="subtotal" placeholder="{subtotal}" disabled />

					</div>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<label for="taxes">Taxes</label>
					<div class="input-group">
						<input type="currency" class="form-control" name="taxes" placeholder="{taxes}" disabled />
					</div>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<label for="total">Total</label>
					<div class="input-group">
						<input type="currency" class="form-control" name="total" placeholder="{total}" disabled />
					</div>
				</div>
			</div>
		</div>



		<div class="row-fluid" style="display:none;">
			<div class="col-xs-12">
				<p class="payment-errors"></p>
			</div>
		</div>
		<button class="btn btn-lg btn-success btn-block" type="submit">Confirm Order</button>
		{form_close}
	</div>
</div>  

			<!-- CREDIT CARD FORM ENDS HERE -->