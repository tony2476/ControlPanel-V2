<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Your details</h3>
	</div>
	<div class="panel-body">
		<fieldset>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">First Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="First Name" name="first_name" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Last Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Last Name" name="last_name" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Industry Licensing.</label>
				<div class="col-xs-9">
					<select id="licensing" name="licensing" class="form-control" required>
						<option value="">-- Please select one --</option>
						<option value="Mutual Funds Licensed">Mutual Funds Licensed</option>
						<option value="Insurance Licensed">Insurance Licensed</option>
						<option value="Dual Licensed">Dual Licensed</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Dealership</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Dealership" name="dealership" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Website">Company Name</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Company Name" name="company_name" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Address">Address</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Your Address" name="address" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="City">City</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="City" name="city" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Province">Province</label>
				<div class="col-xs-9">
					<select class="form-control" name="province" autofocus required>
						<option value="">-- Please select your province --</option>
						<option value="AB">Alberta</option>
						<option value="BC">British Columbia</option>
						<option value="MT">Manitoba</option>
						<option value="NB">New Brunswick</option>
						<option value="NL">Newfoundland and Labrador</option>
						<option value="NT">Northwest Territories</option>
						<option value="NS">Nova Scotia</option>
						<option value="NV">Nunavut</option>
						<option value="ON">Ontario</option>
						<option value="PE">Prince Edward Island</option>
						<option value="QB">Quebec</option>
						<option value="SK">Saskatchewan</option>
						<option value="YT">Yukon Territory</option>
					</select>
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-xs-3" for="Postal Code">Postal Code</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Postal Code" name="postal_code" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Email">Email</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="your@email.com" name="email" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Phone 1">Phone 1</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Phone 1" name="phone_1" type="text" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Phone 2">Phone 2</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Phone 2" name="phone_2" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Office Fax">Office Fax</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Fax Number" name="fax" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3" for="Designations">Designations</label>
				<div class="col-xs-9">
					<label class="checkbox-inline">
						<input type="checkbox" name="designations[]" value="CFP" />CFP
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="designations[]" value="RFP" />RFP
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="designations[]" value="CLU" />CLU
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3" for="Other">Other</label>
				<div class="col-xs-9">
					<input class="form-control" placeholder="Other" name="other" type="text" autofocus>
				</div>
			</div>



			<div class="form-group">
				<label class="control-label col-xs-3" for="password">Please choose a password.</label>
				<div class="col-xs-9">
					<input id="password" class="form-control" name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])..{12,32}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 12 or more characters" autofocus required>
				</div>
			</div>

			<div class="form-group">
				<label id="confirm_text" class="control-label col-xs-3" for="Password_Again">Confirm Password Please.</label>
				<div class="col-xs-9">
					<input id="confirm_password" class="form-control" name="confirm_password" type="password" autofocus required>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<script type="text/javascript">

	window.onload = function () {
		document.getElementById("password").onchange = validatePassword;
		document.getElementById("confirm_password").onkeyup = validatePassword;
	}

	function validatePassword(){
		var pass2=document.getElementById("confirm_password").value;
		var pass1=document.getElementById("password").value;
		if(pass1!=pass2)
		{
			document.getElementById("confirm_password").style.borderColor = "red"; 
			document.getElementById("confirm_text").style.color = "red";
		}
	//document.getElementById("password2").setCustomValidity("Passwords Don't Match");
	else
	{
		document.getElementById("confirm_password").style.borderColor = "green";
		document.getElementById("confirm_text").style.color = "green";
	}

}
</script>