<?php
/* COLORFUL Theme'sSearch Form
	Copyright: 2012, D5 Creation, www.d5creation.com
	
	Since COLORFUL 1.0
*/
?>


<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php ''; ?></label>
		<input type="text" class="field" name="s" id="s" placeholder="Search Text Here" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="Search" />
</form>