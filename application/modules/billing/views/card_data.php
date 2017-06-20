<div class="panel panel-default">

	<div class="panel-heading" >
		<h3 class="panel-title" >Payment Details</h3>
	</div>

	<div class="panel-body">
		{form_open}

		<div class="row-fluid clearfix visible-*">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="cardType">Card Type</label>
					<select id="cardtype" name="cardType" class="form-control" required>
						<option value="">-- Please select one --</option>
						<option value="amex">Amex</option>
						<option value="visa">Visa</option>
						<option value="mastercard">MasterCard</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="cardNumber">Card Number</label>
					<div class="input-group">
						<input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus />
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
					</div>
				</div>                            
			</div>
		</div>
		<div class=""></div>

		<div class="row-fluid">
			<div class="col-xs-6 col-md-6">
				<div class="form-group">
					<label for="cardExpiry"><span class="hidden-xs">Expiration</span><span class="visible-xs-inline">Exp</span> Date</label>
					<input type="tel" class="form-control" name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required />
				</div>
			</div>
			<div class="col-xs-5 col-md-5 pull-right">
				<div class="form-group">
					<label for="cardCVC">CVV Code</label>
					<input type="tel" class="form-control" name="cardCVC" placeholder="CVC" autocomplete="cc-csc" required />
				</div>
			</div>
		</div>

		<button class="btn btn-lg btn-success btn-block" type="submit">Pay Now</button>
		{form_close}
	</div>
</div>  
         
			<!-- CREDIT CARD FORM ENDS HERE -->