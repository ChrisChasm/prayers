<div class="wrap">
	<h2>Prayer Feeds</h2>

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
			    			<td>By Location</td>
			    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed?prayer_location=north-america"><?php echo get_site_url(); ?>/prayers/feed?prayer_location=north-america</a></td>
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
					    	<td>By Most Recent </td><td><a target="_blank" href="<?php echo get_site_url(); ?>/wp-json/wp/v2/prayers"><?php echo get_site_url(); ?>/wp-json/wp/v2/prayers</a></td>
						</tr>
						<tr>
					    	<td>By Locations </td><td><a target="_blank" href="#"><?php echo get_site_url(); ?>/prayers/json?location=north_america</a></td>
						</tr>
						<tr>
					    	<td>By Categories </td><td><a target="_blank" href="#"><?php echo get_site_url(); ?>/prayers/json?category=missions</a></td>
						</tr>
						<tr>
					    	<td>By Tags </td><td><a target="_blank" href="#"><?php echo get_site_url(); ?>/prayers/json?tags=health,supplies</a></td>
					    </tr>
					</tbody>
		    	</table>

			</div>
		</div>

		<div id="col-left">
    		<div class="col-wrap">

    			<p>Echo provides both RSS and JSON feeds for your prayer requests. This gives you the ability to allow subscribers to subsribe to RSS or integrate the prayers on your website into other third-party services.</p>

    			<p>These feeds only display published prayers.</p>

    		</div>
		</div>

	</div>

</div>