<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

<nav class="navbar navbar-light bg-light" style='background-color: #34495e!important;'>
  <span class="navbar-brand mb-0 h1" style='color: white;'>Controlul Elvilor</span> <span style='float:right;'><a href="/index.php/teacher/view/" class='btn btn-primary'><i class="fas fa-caret-left" style='margin-right: 5px;'></i> Inapoi</a></span>
</nav>

<div class="container">
	<ul class="list-group misc_students_list">
		<?php foreach ($students as $st): ?>
			<li class="list-group-item student_data"><?php echo $st["fullname"]; ?></li>
		<?php endforeach; ?>
		<li class="list-group-item addMarkButton"><span style="display: block; text-align: center; color: white;"><i class="fas fa-plus fa-lg"></i></span></li>
	</ul>
</div>