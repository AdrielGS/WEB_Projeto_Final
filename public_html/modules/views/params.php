<?php
	include PAGES.'header.php';
	include PAGES.'home/sidebar.php';
?>
	<article>
	<a href="home/params/exemplo">Link</a><br>
	<?php 
		if(!empty($var))
			echo $var;
	?>
	</article>
<?php
	include PAGES.'footer.php';
?>