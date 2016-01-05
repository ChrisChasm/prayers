	<div class="wrap">
	<h2>Prayer Prayer Feeds</h2>

	<div id="col-container">

		<div id="col-right">
			<div class="col-wrap">

    			<h3>RSS Feeds</h3>

    			<table>
	    			<thead>
		    			<tr>
		    				<td><strong>Type</strong></td>
		    				<td><strong>Feed</strong></td>
		    			</tr>
	    			</thead>
	    			<tbody>
		    			<tr>
			    			<td>By Most Recent</td>
			    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed"><?php echo get_site_url(); ?>/prayers/feed</a></td>
		    			</tr>
		    			<tr>
			    			<td>By Category</td>
			    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed?prayer_category=north-america"><?php echo get_site_url(); ?>/prayers/feed?prayer_category=missions</a></td>
		    			</tr>
		    			<tr>
			    			<td>By Tags</td>
			    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed?prayer_tag=health,supplies"><?php echo get_site_url(); ?>/prayers/feed?prayer_tag=health,supplies</a></td>
		    			</tr>
	    			</tbody>
    			</table>

    			<h3>JSON Feeds</h3>

    			<table>
    				<thead>
	    				<tr>
	    					<td><strong>Type</strong></td>
	    					<td><strong>Feed</strong></td>
	    				</tr>
    				</thead>
    				<tbody>
    					<tr>
    						<td>By Most Recent</td>
    						<td>
    							<a href="<?php echo get_site_url(); ?>/wp-json/prayer/v1" target="_blank"><?php echo get_site_url(); ?>/wp-json/prayer/v1</a>
    						</td>
    					</tr>
		    			<tr>
					    	<td>By Most Recent </td><td><a target="_blank" href="<?php echo get_site_url(); ?>/wp-json/wp/v2/prayers"><?php echo get_site_url(); ?>/wp-json/wp/v2/prayers</a></td>
						</tr>
						<tr>
					    	<td>By Most Recent </td><td><a target="_blank" href="<?php echo get_site_url(); ?>/wp-json/wp/v2/prayers?filter=[prayer_category]=missions"><?php echo get_site_url(); ?>/wp-json/wp/v2/prayers?filter=[prayer_category]=missions</a></td>
						</tr>
						<tr>
					    	<td>By Tags </td><td><a target="_blank" href="<?php echo get_site_url(); ?>/wp-json/wp/v2/prayers?filter=[prayer_tag]=africa"><?php echo get_site_url(); ?>/wp-json/wp/v2/prayers?filter=[prayer_tag]=africa</a></td>
					    </tr>
					</tbody>
		    	</table>

			</div>
		</div>

		<div id="col-left">
    		<div class="col-wrap">

    			<p>Prayer provides both RSS and JSON feeds for your prayer requests. This gives you the ability to allow subscribers to subsribe to RSS or integrate the prayers on your website into other third-party services.</p>

    			<p>These feeds only display published prayers.</p>

    		</div>
		</div>

	</div>

</div>