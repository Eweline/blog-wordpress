<?php

/* COLORFUL Theme's404 Error Page
	Copyright: 2012, D5 Creation, www.d5creation.com
	
	Since COLORFUL 1.0
*/

get_header(); ?>
<div id="content">
<h1 class="page-title">Not Found</h1>
<h3 class="arc-src"><span>Apologies, but the page you requested could not be found. Perhaps searching will help.</span></h3>

<?php get_search_form(); ?>
<p><a href="<?php echo home_url(); ?>" title="Browse the Home Page">&laquo; Or Return to the Home Page</a></p><br /><br />
</div>
<?php get_footer(); ?>