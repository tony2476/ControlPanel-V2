<!-- CREDIT CARD FORM STARTS HERE -->
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">

		<div class="panel-heading" >
			<h3 class="panel-title" >Payment Details</h3>
		</div>

		<div class="panel-body">
			{form_open}

			<div class="form-group">
				<label class="control-label col-xs-3" for="cardname">Name as it appears on card.</label>
				<div class="col-xs-9">
					<input class="form-control" value="{cardname}" name="cardname" type="text" required autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="address_1">Address 1</label>
				<div class="col-xs-9">
					<input class="form-control" value="{address_1}" name="address_1" type="text" required autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="address_2">Address 2</label>
				<div class="col-xs-9">
					<input class="form-control" value="{address_2}" name="address_2" type="text" autofocus>
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-xs-3" for="city">City</label>
				<div class="col-xs-9">
					<input class="form-control" value="{city}" name="city" type="text" required autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Province">Province</label>
				<div class="col-xs-9">
					<select class="form-control" name="province" autofocus required>
						<option value="">-- Please select your province --</option>
						<option value="AB">Alberta</option>
						<option value="BC">British Columbia</option>
						<option value="MB">Manitoba</option>
						<option value="NB">New Brunswick</option>
						<option value="NL">Newfoundland and Labrador</option>
						<option value="NT">Northwest Territories</option>
						<option value="NS">Nova Scotia</option>
						<option value="NU">Nunavut</option>
						<option value="ON">Ontario</option>
						<option value="PE">Prince Edward Island</option>
						<option value="QC">Quebec</option>
						<option value="SK">Saskatchewan</option>
						<option value="YT">Yukon Territory</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="country">Country</label>
				<div class="col-xs-9">
					<input class="form-control" value="CA" name="country" type="text" disabled>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="postal_code">Postal Code</label>
				<div class="col-xs-9">
					<input class="form-control" value="{postal_code}" name="postal_code" type="text" required autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="phone">Phone</label>
				<div class="col-xs-9">
					<input class="form-control" value="{phone}" name="phone" type="text" required autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="email">Email</label>
				<div class="col-xs-9">
					<input class="form-control" value="{email}" name="email" type="text" required autofocus>
				</div>
			</div>

			<div class="row">
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
			<div class="row">
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
			<div class="row">
				<div class="col-xs-7 col-md-7">
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

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="amount">Amount</label>
						<div class="input-group">
							<input type="currency" class="form-control" name="amount" placeholder="{total}" disabled />

						</div>
					</div>                            
				</div>
			</div>



			<div class="row" style="display:none;">
				<div class="col-xs-12">
					<p class="payment-errors"></p>
				</div>
			</div>
			<button class="btn btn-lg btn-success btn-block" type="submit">Confirm</button>
			{form_close}
		</div>
	</div>  
</div>          
			<!-- CREDIT CARD FORM ENDS HERE -->