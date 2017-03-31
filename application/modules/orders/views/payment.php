<!-- CREDIT CARD FORM STARTS HERE -->
<div class="panel panel-default credit-card-box">

	<div class="panel-heading" >
		<h3 class="panel-title display-td" >Payment Details</h3>
		
	</div>

	<div class="panel-body">
		
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="cardType">Card Type</label>
					<select id="cardtype" name="cardType" class="form-control">
						<option value="">-- Please select one --</option>
						<option value="amex">Amex</option>
						<option value="visa">Visa</option>
						<option value="mastercard">MasterCard</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="cardNumber">Card Number</label>
					<div class="input-group">
						<input 
						type="tel"
						class="form-control"
						name="cardNumber"
						placeholder="Valid Card Number"
						autocomplete="cc-number"
						required autofocus 
						/>
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
					</div>
				</div>                            
			</div>
		</div>
		<div class="row">
			<div class="col-xs-7 col-md-7">
				<div class="form-group">
					<label for="cardExpiry"><span class="hidden-xs">Expiration</span><span class="visible-xs-inline">Exp</span> Date</label>
					<input 
					type="tel" 
					class="form-control" 
					name="cardExpiry"
					placeholder="MM / YY"
					autocomplete="cc-exp"
					required 
					/>
				</div>
			</div>
			<div class="col-xs-5 col-md-5 pull-right">
				<div class="form-group">
					<label for="cardCVC">CVV Code</label>
					<input 
					type="tel" 
					class="form-control"
					name="cardCVC"
					placeholder="CVC"
					autocomplete="cc-csc"
					required
					/>
				</div>
			</div>
		</div>

		<div class="row" style="display:none;">
			<div class="col-xs-12">
				<p class="payment-errors"></p>
			</div>
		</div>
		
	</div>
</div>            
			<!-- CREDIT CARD FORM ENDS HERE -->