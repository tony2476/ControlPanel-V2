<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
	<li class="active"><a href="#forwarding" data-toggle="tab">Forwarding</a></li>
	<li><a href="#aliases" data-toggle="tab">Aliases</a></li>
	<li><a href="#autoresponder" data-toggle="tab">Autoresponder</a></li>

</ul>
<div id="my-tab-content" class="tab-content" style="padding-top: 10px;">
	<div id="forwarding" class="tab-pane active">
		{forwarding_form_open}
		{forwarding}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-2" for="forwarding_enabled">Enabled?</label>
				<div class="col-xs-10">
					<input type="checkbox" name="forwarding_enabled" {enabled} value=""><br>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-2" for="address">Forward To?</label>
				<div class="col-xs-10">
					<input class="form-control" value="{address}" placeholder="Forward To?" name="LastName" type="text" autofocus>
				</div>
			</div>
			<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
		</fieldset>
		{/forwarding}
		{forwarding_form_close}
	</div>
	<div id="aliases" class="tab-pane">
		{alias_form_open}
		{aliases}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-2" for="alias"></label>
				<div class="col-xs-10">
					<input class="form-control" value="{alias}" placeholder="alias" name="alias-{alias}" type="text" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2" for="new-alias"></label>
				<div class="col-xs-10">
					<input class="form-control" value="" placeholder="alias" name="alias-new" type="text" autofocus>
				</div>
			</div>
		</fieldset>
		{/aliases}
		{alias_form_close}
	</div>
	<div id="autoresponder" class="tab-pane">
		{autoresponder_form_open}
		{autoresponder}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-2" for="Enabled">Enabled?</label>
				<div class="col-xs-10">
					<input type="checkbox" name="autoresponder_enabled" {enabled}" value=""><br>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-2" for="FirstName">Subject:</label>
				<div class="col-xs-10">
					<input class="form-control" value="{subject}" placeholder="subject" name="subject" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-2" for="content_type">Content Type:</label>
				<div class="col-xs-10">
					<input class="form-control" value="{content_type}" placeholder="content type" name="content_type" type="text" autofocus>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-2" for="text">Content:</label>
				<div class="col-xs-10">
					<textarea class="form-control"  placeholder="My Text" name="text" type="text" autofocus>{text}</textarea>
				</div>
			</div>
		</fieldset>
		{/autoresponder}
		{autoresponder_form_close}

	</div>
</div>

<script>
	$( function() {
		$( "#tabs" ).tabs();
	} );
</script>