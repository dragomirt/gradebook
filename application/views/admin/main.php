<!-- Downloading a font -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

<script>
	function avgBadgeColor(avg, txt, cls){
		if(avg >= 8){
			return '<span class="badge badge-success ' + cls +'">Media ' + txt + ': ' + avg + '</span>';
		}else if(avg >= 6 && avg < 8){
			return '<span class="badge badge-warning ' + cls +'">Media ' + txt + ': ' + avg + '</span>';
		}else{
			return '<span class="badge badge-danger  ' + cls +'">Media ' + txt + ': ' + avg + '</span>';
		}
	}
</script>

<!-- Actual Page -->
<div class="row teacherRow">
	<!-- Menu Beginning -->
	<div class="col-md-2 col-xs-12 leftPanel">
		<div class='menuHeader'>
			<span class='menu_logo'><div class='div-fa cloud_ico'><i class="fas fa-cloud fa-2x"></i></div><span class='menu_txt'><?php echo $fullname; ?></span></span>
			<div class="hamburger" id="hamburger-1">
          		<span class="line"></span>
          		<span class="line"></span>
          		<span class="line"></span>
        	</div>
		</div>
		<ul class="list-group menuUl">
			<li class="list-group-item <?php echo $stat_cls; ?>" id='classes'><div class='div-fa'><i class="fas fa-bolt fa-lg menuFa"></i></div><span class='txt-li'>Clase</span></li>
			<li class="list-group-item <?php echo $stat_lsn; ?>" id='dynamic_lessons'><div class='div-fa'><i class="fas fa-list-ul fa-lg"></i></div><span class='txt-li'>Controlul Orelor</span></li>
			<li class="list-group-item <?php echo $stat_cls_reg; ?>" id='reg_class'><div class='div-fa'><i class="fas fa-plus-square fa-lg"></i></div><span class='txt-li'>Registrarea Claselor</span></li>
			<li class="list-group-item logout"><div class='div-fa'><i class="fas fa-sign-out-alt"></i></div><span class='txt-li'>Iesire</span></li>
		</ul>
	</div>
	<!-- Menu End -->


	<!-- Content Beginning -->
		<?php if($subpage == 'classes'): ?>

		<?php endif; ?>

		<?php if($subpage == 'dynamic_lessons'): ?>
			<div class="col-md-10 col-sm-12 rightPanel">
				<div class="panelHeader">
					</div>
					<div class='infobar_marks'>
						<span class='infobar_text infobar_lesson'>Controlul Obiectelor Dinamice</span>
					</div>
				<div id="objectList">
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<span class='topText'>Lista Obiectelor</span>
							<ul class="list-group lessonsListModal"></ul>
						</div>
						<div class="col-sm-12 col-md-6">
							<span class='topText'>Atribuirea Obiectelor</span>
								<form action="" id="attrForm">
									<div class="row">
										<div class="col-8 col-sm-8 col-md-10">
											<select class='form-control' id="classSelect">
												<?php foreach ($classes as $class): ?>
													<option value="<?php echo $class['user_id']; ?>"><?php echo $class['class']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="col-4 col-sm-4 col-md-2">
											<button class='btn btn-success'>Submit</button>
										</div>
									</div>
								</form>
								<div id='classObjList' class='hidden' style='margin-top: 10px;'>
									<form action="#" id="assignObjForm">
									<div class="row">
										<div class="col-8 col-sm-8 col-md-10">
											<select id="assignObjectsSel" class='form-control'></select>
										</div>

										<div class="col-4 col-sm-4 col-md-2">
											<button class='btn btn-success' style='color: white;'><i class="fas fa-plus fa-lg"></i></button>
										</div>
									</div>
										
									</form>

									<div class="col-12 col-md-12" style='margin-top: 30px;'><ul class="list-group" id='assignedList'></ul></div>

								</div>
						</div>
					</div>
				</div>
		<?php endif; ?>

		<?php if($subpage == 'reg_class'): ?>
			<div class="col-md-10 col-sm-12 rightPanel">
				<div class="panelHeader">
					</div>
					<div class='infobar_marks'>
						<span class='infobar_text infobar_lesson'>Registrarea Claselor</span>
					</div>
				<div id="sandbox">
						<div class="container">
							<div class="col-12 col-md-12">
								<ul class="list-group">
									<li class="list-group-item regUsrButtons" id="regUsrShowButton"><i class="fas fa-eye fa-lg"></i></li>
									<li class="list-group-item regUsrButtons" id="regUsrRegButton"><i class="fas fa-plus fa-lg"></i></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
		<?php endif; ?>
	</div>
	<!-- Content End -->
</div>