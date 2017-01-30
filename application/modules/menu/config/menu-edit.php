	   <div id='bootstrap'>
	   	<h2>Sorting a bootstrap menu</h2>
	   	<div class='row'>
	   		<div class='span4'>
	   			<ul>
	   				<li>
	   					Sort
	   					<strong>vertically</strong>
	   				</li>
	   				<li>Define the nested containers differently</li>
	   				<li>
	   					<strong>Exclude</strong>
	   					some items from being sortable
	   				</li>
	   			</ul>
	   			<p>
	   				<span class='label label-info'>Heads Up!</span>
	   				The
	   				<code>itemSelector</code>
	   				should always match every sibling of any item.
	   				If you want to exclude some items, use the
	   				<code>exclude</code>
	   				option.
	   				<small>
	   					See the first example
	   					<a href='http://jqueryui.com/demos/sortable/#items'>here</a>
	   					why this is a good idea.
	   				</small>
	   			</p>
	   		</div>
	   		<div class="span8">
	   			<div class="CodeRay">
	   				<div class="code"><pre><span class="predefined">$</span>(<span class="string"><span class="delimiter">&quot;</span><span class="content">ol.nav</span><span class="delimiter">&quot;</span></span>).sortable({
	   					<span class="key">group</span>: <span class="string"><span class="delimiter">'</span><span class="content">nav</span><span class="delimiter">'</span></span>,
	   					<span class="key">nested</span>: <span class="predefined-constant">false</span>,
	   					<span class="key">vertical</span>: <span class="predefined-constant">false</span>,
	   					<span class="key">exclude</span>: <span class="string"><span class="delimiter">'</span><span class="content">.divider-vertical</span><span class="delimiter">'</span></span>,
	   					<span class="function">onDragStart</span>: <span class="keyword">function</span>(<span class="predefined">$item</span>, container, _super) {
	   					<span class="predefined">$item</span>.find(<span class="string"><span class="delimiter">'</span><span class="content">ol.dropdown-menu</span><span class="delimiter">'</span></span>).sortable(<span class="string"><span class="delimiter">'</span><span class="content">disable</span><span class="delimiter">'</span></span>);
	   					_super(<span class="predefined">$item</span>, container);
	   				},
	   				<span class="function">onDrop</span>: <span class="keyword">function</span>(<span class="predefined">$item</span>, container, _super) {
	   				<span class="predefined">$item</span>.find(<span class="string"><span class="delimiter">'</span><span class="content">ol.dropdown-menu</span><span class="delimiter">'</span></span>).sortable(<span class="string"><span class="delimiter">'</span><span class="content">enable</span><span class="delimiter">'</span></span>);
	   				_super(<span class="predefined">$item</span>, container);
	   			}
	   		});

	   		<span class="predefined">$</span>(<span class="string"><span class="delimiter">&quot;</span><span class="content">ol.dropdown-menu</span><span class="delimiter">&quot;</span></span>).sortable({
	   		<span class="key">group</span>: <span class="string"><span class="delimiter">'</span><span class="content">nav</span><span class="delimiter">'</span></span>
	   	});</pre></div>
	   </div>

	</div>
</div>
<div class='row'>
	<div class='navbar-sort-container'>
		<div class='navbar'>
			<div class='navbar-inner'>
				<div class='container'>
					<ol class='nav pull-left'>
						<li>
							<a href='#'>Item 1</a>
						</li>
						<li>
							<a href='#'>Item 2</a>
						</li>
						<li>
							<a href='#'>Item 3</a>
						</li>
						<li class='divider-vertical'></li>
						<li class='dropdown open'>
							<a href='#'>Item 4</a>
							<ol class='dropdown-menu'>
								<li>
									<a href='#'>Item 3.1</a>
								</li>
								<li>
									<a href='#'>Item 3.2</a>
								</li>
								<li>
									<a href='#'>Item 3.3</a>
								</li>
								<li>
									<a href='#'>Item 3.4</a>
								</li>
							</ol>
						</li>
						<li>
							<a href='#'>Item 5</a>
						</li>
						<li>
							<a href='#'>Item 6</a>
						</li>
					</ol>
					<ol class='nav pull-right'>
						<li>
							<a href='#'>Item 1</a>
						</li>
						<li>
							<a href='#'>Item 2</a>
						</li>
						<li>
							<a href='#'>Item 3</a>
						</li>
						<li class='divider-vertical'></li>
						<li>
							<a href='#'>Item 4</a>
						</li>
						<li>
							<a href='#'>Item 5</a>
						</li>
						<li>
							<a href='#'>Item 6</a>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>
</div>