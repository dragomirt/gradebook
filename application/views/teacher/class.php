<!-- Downloading a font -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

<!-- Actual Page -->
<div class="row teacherRow">
	<!-- Menu Beginning -->
	<div class="col-md-2 col-xs-12 leftPanel">
		<div class='menuHeader'>
			<span class='menu_logo'><div class='div-fa cloud_ico'><i class="fas fa-cloud fa-2x"></i></div><span class='menu_txt'><?php echo $class; ?></span></span>
			<div class="hamburger" id="hamburger-1">
          		<span class="line"></span>
          		<span class="line"></span>
          		<span class="line"></span>
        	</div>
		</div>
		<ul class="list-group menuUl">
			<li class="list-group-item <?php echo $stat_st; ?>" id='students'><div class='div-fa'><i class="fas fa-users fa-lg menuFa"></i></div><span class='txt-li'>Elevi</span></li>
			<li class="list-group-item <?php echo $stat_mrk; ?>" id='marks'><div class='div-fa'><i class="fas fa-bolt fa-lg menuFa"></i></div><span class='txt-li'>Note</span></li>
			<li class="list-group-item <?php echo $stat_abs; ?>" id='absences'><div class='div-fa'><i class="fas fa-bell"></i></div><span class='txt-li'>Absente</span></li>
			<li class="list-group-item <?php echo $stat_tst; ?>" id='test'><div class='div-fa'><i class="fas fa-list-ul"></i></div><span class='txt-li'>Test</span></li>
			<li class="list-group-item <?php echo $stat_misc; ?>" id='misc'><div class='div-fa'><i class="fas fa-th-large"></i></div><span class='txt-li'>Alte</span></li>
			<li class="list-group-item logout"><div class='div-fa'><i class="fas fa-sign-out-alt"></i></div><span class='txt-li'>Iesire</span></li>
		</ul>
	</div>
	<!-- Menu End -->

	<!-- Content Beginning -->
	<div class="col-md-10 col-xd-12 rightPanel">
		<?php if($subpage == 'students'):?>
			<div class="row">
				<?php foreach ($users as $user): ?>
					<div class="card col-xs-12 col-md-4 cardPersonal" style="<?php if($user['avg_mark'] < 5){echo 'border-right: 5px solid black;';} elseif($user['avg_mark'] < 6 && $user['avg_mark'] >= 5){echo 'border-right: 5px solid red;';} elseif($user['avg_mark'] < 8 && $user['avg_mark'] >= 7){echo 'border-right: 5px solid orange;';} else {echo 'border-right: 5px solid green;';};?>">
						<div class="card-body">
							<div class="cardBodyLeft">
								<div class='cardImagine' data-id='<?php $imgfname=$user['firstname']; $imglname=$user['lastname']; echo $user['user_id']; ?>' id='<?php echo $user['user_id']; ?>-color'><span><?php echo mb_substr("$imgfname", 0, 1 ); ?></span><span><?php echo mb_substr("$imglname", 0, 1 ); ?></span></div>
							</div>
							<div class="cardName"><span><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></span></div>
							<div class="cardInfo"><span>Media: <?php echo $user['avg_mark'];?></span><span>Absentele: <?php echo $user['absences'] * 2; // NOTE: Delete * 2 for schools with 45 min lessons?></span></div>	
						</div>
					</div>
				<?php endforeach;?> 
			<div>
		<?php endif;?>

		<?php if($subpage == 'marks'): ?>
			<div class="panelHeader">
				<div class='select_object'>
					<div class="row">
					<div class="col-xs-12 col-md-10">
						<select id="sel" class="custom-select">
							<?php foreach ($lessons as $ls):?>
								<option value="<?php echo $ls['lesson_shrt']; ?>"><?php echo $ls['lesson_name']; ?></option>
							<?php endforeach; ?>
						</select>
						</div>
						<div class="col-xs-12 col-md-2">
							<button class='btn btn-success' id='subM' style='width: 100%;'>Submit</button>
						</div>
					</div>
				</div>
			</div>
				<div class='infobar_marks'>
					<span class='infobar_text infobar_lesson'></span><span class='marks_num'></span><span class='badge badge-info stModList' data-lesson='#'><i class="fas fa-list-ul fa-lg"></i></span><span class='class_avg'></span><button class='btn btn-primary backButton disabled'><i class="fas fa-caret-left"></i> Inapoi</button>
				</div>
			<div id="studentList"></div>
		<?php endif; ?>

		<?php if($subpage == 'absences'): ?>
			<div class="panelHeader">
				<div class='select_object'>
					<div class="row">
					<div class="col-xs-12 col-md-10">
						<select id="sel" class="custom-select">
							<?php foreach ($lessons as $ls):?>
								<option value="<?php echo $ls['lesson_shrt']; ?>"><?php echo $ls['lesson_name']; ?></option>
							<?php endforeach; ?>
						</select>
						</div>
						<div class="col-xs-12 col-md-2">
							<button class='btn btn-success' id='subAbs' style='width: 100%;'>Submit</button>
						</div>
					</div>
				</div>
			</div>
				<div class='infobar_abs'>
					<span class='infobar_text infobar_lesson'></span><span class='abs_num'></span><button class='btn btn-primary backButton disabled'><i class="fas fa-caret-left"></i> Inapoi</button>
				</div>
			<div id="studentList"></div>
		<?php endif; ?>

		<?php if($subpage == 'test'): ?>
			<div class="panelHeader">
				<div class='select_object_multi'>
					<div class="row">
					<div class="col-xs-12 col-md-10">
						<select id="selMulti" class="custom-select" style='width: 100%;'>
							<?php foreach ($lessons as $ls):?>
								<option value="<?php echo $ls['lesson_shrt']; ?>" data-id='<?php echo $ls['lesson_id']; ?>'><?php echo $ls['lesson_name']; ?></option>
							<?php endforeach; ?>
						</select>
						</div>
						<div class="col-xs-12 col-md-2">
							<button class='btn btn-success' id='subMulti' style='width: 100%;'>Submit</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row hidden" id='multiFormDiv'>
				<div class="col-xs-12 col-md-2">
					<form action="" id='multiForm'>
						<label for="month">Luna</label>
						<input type="number" class='form-control' name='month' min='<?php echo $semMin; ?>' max='<?php echo $semMax; ?>' required>
						<label for="day">Ziua</label>
						<input type="number" class='form-control' name='day' min='1' max='31' required>
						<span class='middle'>
							<span class='inline'>
								<label for="test">Test</label>
								<label class="switch">
									<input type="checkbox" id='baTest'>
									<span class="slider round"></span>
								</label>
							</span>
							<span class='inline'>
								<label for="teza">Teza</label>
								<label class="switch">
									<input type="checkbox" id='baTeza'>
									<span class="slider round"></span>
								</label>
							</span>
						</span>
						<input type="hidden" name='ammLesson' value='ammLesson'>
						<input type="submit" id='bunchSubmitButton' class='btn btn-success' value='Submit' style='width: 100%;'>
					</form>
				</div>
				<div class="col-xs-12 col-md-10">
					<span id='bunchInputList'></span>
				</div>
			</div>
		<?php endif; ?>

		<?php if($subpage == 'misc'): ?>
			<div class="container" style='margin-top: 25px;'>
				<ul class="list-group misc_list">
					<a href="/index.php/regusr/view"><li class="list-group-item st_controll" style='font-family: "Open Sans", sans-serif;'>Controlul Elevilor</li></a>
				</ul>
			</div>
		<?php endif; ?>
	</div>
	<!-- Content End -->
</div>