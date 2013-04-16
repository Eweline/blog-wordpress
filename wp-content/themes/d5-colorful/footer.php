<?php
/* COLORFUL Theme's Footer
	Copyright: 2012, D5 Creation, www.d5creation.com
	
	Since COLORFUL 1.0
*/
?>





<div id="footer">

<div id="footer-content">

<div id="footer-sidebar">
<?php
   	get_sidebar( 'footer' );
?>
</div>
<div id="creditline">&copy;&nbsp;<?php echo date("Y") ?>&nbsp;<?php bloginfo( 'name' ); echo '&nbsp| COLORFUL Theme by: <a href="http://d5creation.com" target="_blank"><img src="' . get_template_directory_uri() . '/images/d5logofooter.png" /> D5 Creation</a> | Powered by: <a href="http://wordpress.org" target="_blank">WordPress</a>' ?></div>

<?php wp_footer(); ?>
</div> <!-- footer-content -->
</div> <!-- footer -->
</div><!-- container -->
</body>
</html>