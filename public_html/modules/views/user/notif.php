<?php
	include PAGES.'header.php';
	include PAGES.'user/sidebar.php';
?>
	<style>
		article > div {
			padding:25px;
		}
		article > div > div {

		}
	</style>
	<article>
		<div>
			<?php 
				foreach ($messages as $i) 
					echo '<div>'.$i.'</div>';
			?>
		</div>
	</article>
<?php
	include PAGES.'footer.php';
?>