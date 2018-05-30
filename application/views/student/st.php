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
			<li class="list-group-item <?php echo $stat_mrk; ?>" id='marks'><div class='div-fa'><i class="fas fa-bolt fa-lg menuFa"></i></div><span class='txt-li'>Note</span></li>
			<li class="list-group-item <?php echo $stat_abs; ?>" id='absences'><div class='div-fa'><i class="fas fa-bell"></i></div><span class='txt-li'>Absente</span></li>
			<li class="list-group-item logout"><div class='div-fa'><i class="fas fa-sign-out-alt"></i></div><span class='txt-li'>Iesire</span></li>
		</ul>
	</div>
	<!-- Menu End -->


	<!-- Content Beginning -->
		<?php if($subpage == 'marks'): ?>
		<div class="col-md-10 col-xs-12 rightPanel">
			<div class="panelHeader">
				</div>
				<div class='infobar_marks'>
					<span class='infobar_text infobar_lesson'>Notele Elveului</span><span id='marks_num' class='marks_num'></span><span id='usr_avg' class='class_avg'></span><button class='btn btn-primary backButton disabled backButtonSt'><i class="fas fa-caret-left"></i> Inapoi</button>
				</div>
			<div id="objectList">
				<?php	$obj_list_temp = []; $glob_marks_count = 0; $glob_marks_sum = 0;
				if(count($marks) > 0):
					foreach ($marks as $mrk) {
						array_push($obj_list_temp, $mrk['lesson']);
					}
					$obj_list = array_unique($obj_list_temp);
					sort($obj_list);
					foreach ($obj_list as $lsn):
						?> <div class='marksTable modMarksTable' id='<?php echo $lsn; ?>-marksTable'><ul class='marksList' id='<?php echo $lsn; ?>-marksList'><li class="list-group-item infobarMarks"><div class="li_el li_mark"> Nota </div><div class="li_el li_date"> Data </div></li></ul></div> <?php
						$marks_sum = 0; $marks_count = 0;
						foreach ($marks as $mrk) {
							if($mrk['lesson'] == $lsn){
								foreach($avgs as $avg){
									if($avg['lesson'] == $lsn){
										$glob_marks_sum += $avg['mark'];
										$glob_marks_count++;
										$avg_mark = $avg['mark'];
									}
								}
								?>
									<script>if(<?php echo $mrk['status']; ?> == 1){ var stat = '<span class="badge badge-primary">Test</span>'}else if(<?php echo $mrk['status']; ?> == 2){ var stat = '<span class="badge badge-warning">Teza</span>'}else{var stat = ''};
									document.getElementById('<?php echo $lsn; ?>-marksList').innerHTML += `<li class="list-group-item"><div class="li_el li_mark"><?php echo $mrk["mark"]; ?></div><div class="li_el li_date"><?php echo $mrk["date"]; ?></div><div class="li_el li_stat">` + stat + `</div></li>`;</script>
								<?php
							}
						}
					?>

						<?php if($glob_marks_count > 0){
							$avg_mark_glob = substr($glob_marks_sum / $glob_marks_count, 0, 4);
						}else{ $avg_mark_glob = ''; }?>
	
						<div class="card usrMarksData" data-id='<?php echo $lsn; ?>'><div class="card-body"><span class='card-st-name'><?php echo ucfirst($lsn); ?></span><span style='float:right;' ><script> document.write(avgBadgeColor(<?php echo $avg_mark; ?>,'',''));</script></span></div></div>
						<script>document.getElementById('marks_num').innerHTML = "<?php echo $glob_marks_count; ?> note.";
								document.getElementById('usr_avg').innerHTML = avgBadgeColor(<?php echo $avg_mark_glob; ?>, 'Generala', 'usr_avg_badge');</script>
				<?php endforeach; endif; ?>
			</div>
		<?php endif; ?>

		<?php if($subpage == 'absences'): ?>
		<div class="col-md-10 col-xs-12 rightPanel">
			<div class="panelHeader">
				</div>
				<div class='infobar_marks'>
					<span class='infobar_text infobar_lesson'>Absentele Elveului</span><span id='abs_num' class='marks_num'></span><span id='usr_avg' class='class_avg'></span><button class='btn btn-primary backButton disabled backButtonSt'><i class="fas fa-caret-left"></i> Inapoi</button>
				</div>
			<div id="objectList">
				<?php	$obj_list_temp = []; $glob_abs_count = 0;
				if(count($abs) > 0):
					foreach ($abs as $ab) {
						array_push($obj_list_temp, $ab['lesson']);
					}
					$obj_list = array_unique($obj_list_temp);
					sort($obj_list);
					foreach ($obj_list as $lsn):
						?> <div class='marksTable modMarksTable' id='<?php echo $lsn; ?>-marksTable'><ul class='marksList' id='<?php echo $lsn; ?>-marksList'><li class="list-group-item infobarMarks"><div class="li_el li_mark"> Tipul Absentei </div><div class="li_el li_date"> Data </div></li></ul></div> <?php
						$abs_count = 0;
						foreach ($abs as $ab) {
							if($ab['lesson'] == $lsn){
								$abs_count++;
								$glob_abs_count++; ?>
									<script>if(<?php echo $ab['type']; ?> == 1){ var stat = '<span class="badge badge-primary" style="font-size: 18px;">Motivat</span>'
												document.getElementById('<?php echo $lsn; ?>-marksList').innerHTML += `<li class="list-group-item"><div class="li_el li_mark" style="margin-right: -10px;">` + stat + `</div><div class="li_el li_date"><?php echo $ab["date"]; ?></div></li>`;	
											}else if(<?php echo $ab['type']; ?> == 2){ var stat = '<span class="badge badge-danger" style="font-size: 18px;">Nemotivat</span>'
												document.getElementById('<?php echo $lsn; ?>-marksList').innerHTML += `<li class="list-group-item"><div class="li_el li_mark" style="margin-right: -35px;">` + stat + `</div><div class="li_el li_date"><?php echo $ab["date"]; ?></div></li>`;};
									</script>
								<?php
							}
						} ?>
	
						<div class="card usrMarksData" data-id='<?php echo $lsn; ?>'><div class="card-body"><span class='card-st-name' style='margin-top: 0px;'><?php echo ucfirst($lsn); ?></span><span style='float:right; font-size: 20px;' ><?php echo $abs_count * 2; // NOTE: Delete * 2 for schools with 45 min lessons ?></span></div></div>
						<script>document.getElementById('abs_num').innerHTML = "<?php echo $glob_abs_count * 2; // NOTE: Delete * 2 for schools with 45 min lessons ?> absente.";</script>
				<?php endforeach; endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<!-- Content End -->
</div>