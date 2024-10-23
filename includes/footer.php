<?php
$host = $_SERVER['HTTP_HOST'];
$is_localhost = ($host == 'localhost' || $host == '127.0.0.1');

// If the server is localhost, include 'photo_abcd_A' in the base URL
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host . ($is_localhost ? '/photo_abcd_A/' : '/');
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
