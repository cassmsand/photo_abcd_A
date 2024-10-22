<?php
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/photo_abcd_A/';
?>

<div class="footer" id='main-footer' 
     style="background-image: url('<?php echo $base_url; ?>images/banner.png'); 
            background-size: cover; 
            background-position: center; 
            height: 200px;
			display: flex; 
			justify-content: center; 
			align-items: center;">
	<span>  
		Alligator Group @ <?php echo date('Y'); ?>
	</span>
</div>