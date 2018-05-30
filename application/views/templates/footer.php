    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
	<?php if($page == 'teacher' || $page == 'userReg'):?>
    	<script src="<?php echo base_url(); ?>static/js/fx.js"></script>
	<?php endif; if($page == 'student'):?>
    	<script src="<?php echo base_url(); ?>static/js/fx1.js"></script>
	<?php endif; if($page == 'admin'):?>
		<script src="<?php echo base_url(); ?>static/js/fx2.js"></script>
	<?php endif;?>

	<link rel="stylesheet" href="<?php echo base_url(); ?>static/sweetAlert/sweetalert.css">
	<script src="<?php echo base_url(); ?>static/sweetAlert/sweetalert.min.js"></script>
</body>
</html>