$('document').ready(function(){
	// Stretch the page
		function stretch(){
			$('.teacherRow').css('height', $(window).innerHeight()-17);
		}

		stretch();

		$(window).resize(function(){
			stretch();
		});

	// Redirect to a page. (class.php)
		$('.menuUl .list-group-item').click(function(){
			var id = $(this).attr('id');
			var url = window.location.href;
			window.location.href = id;
		});

	// Handling the marks page. (class.php)
		function handleUserListClick(){
			$('.usrMarksData').click(function(){
				var id = $(this).data('id');
				$('#studentList').css('margin-left', -1 * $(window).innerWidth());
				$('#' + id + '-marksTable').css('margin-left', $(window).innerWidth());
				if($('.backButton').hasClass('disabled')){
					$('.backButton').removeClass('disabled');
				}
			});
		}

		function returnUserListClick(){
			$('.backButton').click(function(){
				if(!$('.backButton').hasClass('disabled')){
					$('#studentList').css('margin-left', 0);
					$('.marksTable').css('margin-left', $(window).innerWidth()*2);
					$('.backButton').addClass('disabled');
				}
			});
		}

	// Generate the layout for the class.php. (class.php)
		function genCard(st_name, usr_id){
			return `<div class="card usrMarksData" data-id='${usr_id}'><div class="card-body"><span class='card-st-name'>${st_name}</span><span style='float:right;' id='${usr_id}-avg'></span></div></div>
					<div class='marksTable' id='${usr_id}-marksTable'><ul class='marksList' id='${usr_id}-marksList'></ul></div>`;
		}

		function genMarks(markArr, user_id, lesson){
			$('#' + user_id + '-marksList').html('');
			$('#' + user_id + '-marksList').append(`<li class="list-group-item addMarkButton" data-id='${user_id}' data-lesson='${lesson}'><span style="display: block; text-align: center; color: white;"><i class="fas fa-plus fa-lg"></i></span></li>`);
			$('#' + user_id + '-marksList').append('<li class="list-group-item infobarMarks"><div class="li_el li_mark"> Nota </div><div class="li_el li_date"> Data </div></li>');
			markArr.forEach(mrk => {
				if(mrk.status == 0){
					var stat = '';
				}else if(mrk.status == 1){
					var stat = '<span class="badge badge-primary">Test</span>';
				}else if(mrk.status == 2){
					var stat = '<span class="badge badge-warning">Teza</span>';
				}

				$('#' + user_id + '-marksList').append('<li class="list-group-item"><div class="li_el li_mark">' + mrk.mark + '</div><div class="li_el li_date">' + mrk.date + '</div><div><div class="li_btns"><button class="delete_btn btn btn-danger" data-mrkid='+ mrk.mark_id +' data-usrid='+ mrk.user_id +' data-lsn=' + mrk.lesson + '><i class="fas fa-eraser"></i></button><button class="edit_btn btn btn-info" data-mrkid='+ mrk.mark_id +' data-usrid='+ mrk.user_id +' data-lsn=' + mrk.lesson + '><i class="far fa-edit"></i></button></div><div class="li_el li_stat">' + stat + '</div></div></li>');
			});
			$('#' + user_id + '-marksTable').css('margin-left', $(window).innerWidth()*2);
			addMarksHandle(); deleteMarksFx(); editMarksFx();
		}

		function genAbs(absArr, user_id, lesson){
			$('#' + user_id + '-marksList').html('');
			$('#' + user_id + '-marksList').append(`<li class="list-group-item addAbsButton" data-id='${user_id}' data-lesson='${lesson}'><span style="display: block; text-align: center; color: white;"><i class="fas fa-plus fa-lg"></i></span></li>`);
			$('#' + user_id + '-marksList').append('<li class="list-group-item infobarAbs"><div class="li_el li_mark"> Tipul </div><div class="li_el li_date"> Data </div></li>');
			absArr.forEach(abs => {
				if(abs.type == 1){
					var stat = '<span class="badge badge-primary" style="font-size: 18px;">Motivat</span>';
					$('#' + user_id + '-marksList').append('<li class="list-group-item"><div class="li_el li_mark" style="margin-right: -75px;">' + stat + '</div><div class="li_el li_date">' + abs.date + '</div><div class="li_btns"><button class="delete_abs_btn btn btn-danger" data-mrkid='+ abs.absence_id +' data-usrid='+ abs.user_id +' data-lsn=' + abs.lesson + '><i class="fas fa-eraser"></i></button></div></li>');
				}else if(abs.type == 2){
					var stat = '<span class="badge badge-danger" style="font-size: 18px;">Nemotivat</span>';
					$('#' + user_id + '-marksList').append('<li class="list-group-item"><div class="li_el li_mark" style="margin-right: -100px;">' + stat + '</div><div class="li_el li_date">' + abs.date + '</div><div class="li_btns"><button class="delete_abs_btn btn btn-danger" data-mrkid='+ abs.absence_id +' data-usrid='+ abs.user_id +' data-lsn=' + abs.lesson + '><i class="fas fa-eraser"></i></button></div></li>');
				}
			});
			$('#' + user_id + '-marksTable').css('margin-left', $(window).innerWidth()*2);
			addAbsHandle(); deleteAbsFx();
		}

		function showMarksNum(num){
			$('.infobar_marks .marks_num').html(num + ' note.');
		}

		function showAbsNum(num){
			$('.infobar_abs .abs_num').html(num + ' absente.');
		}

		function capitalizeFirstLetter(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		}

		function avgBadgeColor(avg, txt, cls){
			if(avg >= 8){
				return '<span class="badge badge-success ' + cls +'">Media ' + txt + ': ' + avg + '</span>';
			}else if(avg >= 6 && avg < 8){
				return '<span class="badge badge-warning ' + cls +'">Media ' + txt + ': ' + avg + '</span>';
			}else{
				return '<span class="badge badge-danger  ' + cls +'">Media ' + txt + ': ' + avg + '</span>';
			}
		}

	// Sending the AJAX request and receiving the marks data. (class.php)

		$('#subM').click(function(){
			var val = $('#sel').val();
			$.ajax({
				type: "POST",
				url: "/index.php/teacher/display_current_marks",
				data: {lesson: val},
				dataType: "json",
				success: function (res) {
					var st = res.students;
					var totalMarks = 0;
					var avg_sum = 0;
					var avg_count = 0;
					//console.log(res);
					$('#studentList').html("");
					st.forEach(el => {
						var stat = false;
						res['attr_students'].forEach(lsn => {
							if(el.user_id == lsn.user_id){
								stat = true;
							}
						});
						if(stat){
							$('#studentList').append(genCard(el.firstname + ' ' + el.lastname, el.user_id));
							var marks = res[el.user_id];
							var sum = 0; var num = 0; var teza = null;
							marks.forEach(mrk => {
								if(mrk['status'] != 2){
									sum += parseInt(mrk['mark']); num++; totalMarks++;
								}else if(mrk['status'] == 2){
									teza = mrk['mark'];
								}
							});
	
							if(sum > 0){
								var med = (sum/num).toString().substring(0,4);
								med = parseFloat(med);
								var lsn_type = res['lsn_type'];
								if(lsn_type['avg_type'] == 'de' && teza != null){
									var avg = (parseFloat(med) + parseInt(teza)) / 2;
									//console.log(med);
									//console.log(teza);
								}else if(lsn_type['avg_type'] == 'pr'  && teza != null){
									var avg = parseFloat(med)*0.6 +  parseInt(teza)*0.4;
								}else{
									var avg = med;
								}
								
								avg = avg.toString().substring(0,4);
								avg_sum += parseFloat(avg);
								avg_count++;
								$('#' + el.user_id + '-avg').html(avgBadgeColor(avg, '', ''));
							}
							genMarks(marks, el.user_id, val);
							handleUserListClick();
							returnUserListClick();
						}
					});
					showMarksNum(totalMarks);
					$('.infobar_marks .infobar_lesson').html(capitalizeFirstLetter(val));
					$('.infobar_marks .class_avg').html(avgBadgeColor(parseFloat((avg_sum / avg_count).toString().substring(0,4)), 'Clasei', 'class_avg_badge'));
					$('.infobar_marks .backButton').css('display', 'inline-block');
					$('.infobar_marks .stModList').css('display', 'inline-block');
					$('.infobar_marks .stModList').attr({'data-lesson': res['lsn_type']['lesson_id']});
					assignstudents(st, res['attr_students']);
				}
			});
		});

		// Add Mark Modal Handling
		function addMarksHandle(){
			$('.marksList .addMarkButton').click(function(){
				var id = $(this).data('id');
				var lesson = $(this).data('lesson');
				$('#addMarkModal').modal('toggle');
				$('#amUserId').val(id);
				$('#amLesson').val(lesson);
			});
		}

		// Add Mark AJAX Handling
		$('#amSubmitButton').click(function(){
			var mark = $('#amMark').val();
			var month = $('#amMonth').val();
			var day = $('#amDay').val();
			var user_id = $('#amUserId').val();
			var lesson = $('#amLesson').val();

			if($('#amTest').is(':checked')){ var test = 1; }else{ var test = -1; }
			$.ajax({
				type: "POST",
				url: "/index.php/marks/add_mark",
				data: {mark: mark, month: month, day: day, test: test, user_id: user_id, lesson: lesson},
				dataType: "json",
				success: function (res) {
					$('#amMark').val(''); $('#amMonth').val(''); $('#amDay').val(''); $('#amUserId').val(''); $('#amLesson').val('');
					$('#addMarkModal').modal('toggle');
					updateMarks(user_id, lesson, 'add');
					sweetAlert(res.text, res.type);
				}
			});
		});

		// Update the user's marks
		function updateMarks(user_id, lesson, type){
			$.ajax({
				type: "POST",
				url: "/index.php/teacher/update_marks",
				data: {user_id: user_id, lesson: lesson},
				dataType: "json",
				success: function (res) {
					var marks = [];
					var sum = 0; var num = 0;
					var avg_sum = 0;
					var avg_count = 0;

					res.forEach(mrk => {
						marks.push(mrk);
						sum += parseInt(mrk.mark); num++;
					});

					if(sum > 0){
						var avg = (sum/num).toString().substring(0,4);
						avg_sum += parseFloat(avg);
						avg_count++;
						$('#' + user_id + '-avg').html(avgBadgeColor(avg, '', ''));
					}

					genMarks(marks, user_id, lesson);
					$('#' + user_id + '-marksTable').css('margin-left', $(window).innerWidth());
				
					// TODO: Update the class average mark
					var totMarks = $('.infobar_marks .marks_num').html();
					if(type == 'add'){
						showMarksNum(parseInt(totMarks.substring(0, totMarks.indexOf('note'))) + 1);
					}else if(type == 'del'){
						showMarksNum(parseInt(totMarks.substring(0, totMarks.indexOf('note'))) - 1);
					}
					updateAvg(user_id, lesson);
					updateClassAvg(lesson);
				}
			});
		}

		function updateClassAvg(lesson){
			$.ajax({
				type: "POST",
				url: "/index.php/teacher/genClassAvg/" + lesson,
				dataType: "html",
				success: function (res) {
					$('.infobar_marks .class_avg').html('');
					$('.infobar_marks .class_avg').html(avgBadgeColor(parseFloat(res), 'Clasei', 'class_avg_badge'));
				}
			});
		}

		// Random color for .cardImagine (Student avatar)
		var colors = ["#E57373", "#3E2723", "#B71C1C", "#4A148C", "#8E24AA", "#CE93D8", "#D50000", "#673AB7", "#42A5F5", "#3F51B5", 
					  "#BBDEFB", "#304FFE", "#00695C", "#26A69A", "#0097A7", "#40C4FF", "#AED581", "#7CB342", "#2E7D32", "#AFB42B", 
					  "#F57C00", "#E65100", "#795548", "#D84315", "#546E7A", "#FFA000", "#2E7D32", "#4CAF50", "#009688", "#CDDC39"];
        $('.cardImagine').each(function () {
        	var id = $(this).data('id');
                var rand = Math.floor(Math.random() * colors.length);
                $('#'+id+'-color').css("background-color", colors[rand]);
			});

		
		// Animation for hamburger
		$(".hamburger").click(function(){
			$(this).toggleClass("is-active");
			$(".menuUl").slideToggle();
			return false;
		});

		// Alert
		function sweetAlert(text, type){
			if(type == 'succ'){
				swal("Succes!", text, "success");
			}else if(type == 'warn'){
				swal("Atentie!", text, "warning");
			}else if(type == 'fail'){
				swal("Insucces!", text, "error");
			}
		}

	// Handling deleting a mark
		function deleteMarksFx(){
			$('.delete_btn').click(function(){
				var mrkid = $(this).data('mrkid');
				var usrid = $(this).data('usrid');
				var lesson = $(this).data('lsn');
				$('#deleteMarkModal').modal('toggle');
				$('#dmSubmitButton').click(function(){
					$.ajax({
						type: "POST",
						url: "/index.php/marks/delete_mark",
						data: {mark_id: mrkid},
						dataType: "json",
						success: function (res) {
							updateMarks(usrid, lesson, 'del');
							$('#deleteMarkModal').modal('toggle');
							sweetAlert(res.text, res.type);
						}
					});
				});
			});
		}

	// Handling marks edit
		function editMarksFx(){
			$('.edit_btn').click(function(){
				var mark_id = $(this).data('mrkid');
				var usrid = $(this).data('usrid');
				var lesson = $(this).data('lsn');
				
				$.ajax({
					type: "POST",
					url: "/index.php/marks/mrkdata",
					data: {mark_id: mark_id},
					dataType: "json",
					success: function (res) {
						$('#edMark').val(''); $('#edMonth').val(''); $('#edDay').val(''); $('#edTest').prop('checked', false); $('#edUserId').val(); $('#edLesson').val();
						$('#edMark').val(res.info.mark); $('#edMonth').val(res.info.date.substring(5,7)); $('#edDay').val(res.info.date.substring(8,10));
						if(res.info.status == 1){
							$('#edTest').prop('checked', true);
						}
						 $('#edUserId').val(res.info.user_id); $('#edLesson').val(res.info.lesson);
					}
				});
				$('#editMarkModal').modal('toggle');
				$('#edSubmitButton').click(function(){
					var mark = $('#edMark').val();
					var month = $('#edMonth').val();
					var day = $('#edDay').val();
					var user_id = $('#edUserId').val();
					var lesson = $('#edLesson').val();
		
					if($('#edTest').is(':checked')){ var test = 1; }else{ var test = -1; }
					$.ajax({
						type: "POST",
						url: "/index.php/marks/edit_marks",
						data: {mark: mark, mark_id: mark_id, month: month, day: day, test: test, user_id: user_id, lesson: lesson},
						dataType: "json",
						success: function (res) {
							$('#edMark').val(''); $('#edMonth').val(''); $('#edDay').val(''); $('#edUserId').val(''); $('#edLesson').val('');
							$('#editMarkModal').modal('toggle');
							updateMarks(user_id, lesson, '');
							sweetAlert(res.text, res.type);
						}
					});
				});
			});
		}

	// Updating the avg_mark
		function updateAvg(user_id, lesson){
			$.ajax({
				type: "POST",
				url: "/index.php/marks/update_avg",
				data: {user_id: user_id, lesson: lesson},
				dataType: "html",
				success: function (res) {
				}
			});
		}

	// Handling Logout
		$('.logout').click(function(){
			$.ajax({
				type: "POST",
				url: "/index.php/login/logout",
				success: function (res) {
					window.location('/');
				}
			});
		});

	// Select the lesson for the multi mark input
		$('#subMulti').click(function(){
			var val = $('#selMulti').val();
			var val_id = $('#selMulti').find(':selected').data('id')
			$('#multiFormDiv').removeClass('hidden');
				$.ajax({
					type: "POST",
					url: "/index.php/teacher/getStLsn",
					data: {'lesson_id': val_id},
					dataType: "json",
					success: function (res) {
						$('#bunchInputList').html("");
						res['students'].forEach(st => {
							$('#bunchInputList').append(`
							<span class='stMulti'>
								<label class='multiLabel'>${st['firstname']}  ${st['lastname']}</label>
								<input type="number" min='1' max='10' id='${st['user_id']}-multiMarks' class='form-control'/>
							</span>`);
						});
					}
				});
			$('#multiForm').submit(function(e){
				e.preventDefault();
				res = $(this).serializeArray();
				var month = res[0].value;
				var day = res[1].value;
				if($('#baTest').is(':checked')){ var test = 1; }else{ var test = -1; }
				if($('#baTeza').is(':checked')){ var teza = 1; }else{ var teza = -1; }

				var students = []; var vals = [];
				$.ajax({
					type: "POST",
					url: "/index.php/teacher/getStudents",
					dataType: "json",
					success: function (res) {
						res.forEach(st =>{
							students.push(st['user_id']);
						});

						students.forEach( id=> {
							var value = $('#' + id + '-multiMarks').val();
							if(value > 0 && value != undefined){
								vals[id] = value;
							}
						});

						$.ajax({
							type: "POST",
							url: "/index.php/marks/insert_multimarks",
							data: {month: month, day: day, test: test, teza: teza, data: vals, lesson: val},
							dataType: "json",
							success: function (res) {
								sweetAlert(res.text, res.type);
								students.forEach( id=> {
									updateMarks(id, val, '');
								});
							}
						});
					}
				});
			});
		});

	// Absences
			// Sending the AJAX request and receiving the absences data. (class.php)

			$('#subAbs').click(function(){
				var val = $('#sel').val();
				$.ajax({
					type: "POST",
					url: "/index.php/teacher/display_get_absences",
					data: {lesson: val},
					dataType: "json",
					success: function (res) {
						$('#studentList').html("");					
						var st = res.students;
						var totalAbs = 0;
						
						st.forEach(el => {
							var stat = false;
							res['attr_students'].forEach(lsn => {
								if(el.user_id == lsn.user_id){
									stat = true;
								}
							});
							if(stat){
								$('#studentList').append(genCard(el.firstname + ' ' + el.lastname, el.user_id));
								var abs = res[el.user_id];
								var usrAbs = 0;
								abs.forEach(ab =>{
									totalAbs++;
									usrAbs++;
								});
								$('#' + el.user_id + '-avg').html(usrAbs * 2); // NOTE: CHANGE * 2 TO 1 For schools with 45 min lessons
								$('#' + el.user_id + '-avg').css('font-size', '20px');
								genAbs(abs, el.user_id, val);
								handleUserListClick();
								returnUserListClick();
							}
						});
						$('.card-st-name').css('margin-top', '0');
						$('.infobar_abs .infobar_lesson').html(capitalizeFirstLetter(val));
						$('.abs_num').html(showAbsNum(totalAbs * 2)); // NOTE: CHANGE * 2 TO 1 For schools with 45 min lessons
						$('.infobar_abs .backButton').css('display', 'inline-block');
					}
				});
			});

			// Add Absence Modal Handling
			function addAbsHandle(){
				$('.addAbsButton').click(function(){
					var id = $(this).data('id');
					var lesson = $(this).data('lesson');
					$('#addAbsModal').modal('toggle');
					$('#abUserId').val(id);
					$('#abLesson').val(lesson);
				});
			}

			// Add Absence AJAX Handling
			$('#abSubmitButton').click(function(){
				var type = $('#abType').val();
				var month = $('#abMonth').val();
				var day = $('#abDay').val();
				var user_id = $('#abUserId').val();
				var lesson = $('#abLesson').val();

				$.ajax({
					type: "POST",
					url: "/index.php/absences/add_abs",
					data: {type: type, month: month, day: day, user_id: user_id, lesson: lesson},
					dataType: "json",
					success: function (res) {
						$('#abMark').val(''); $('#abMonth').val(''); $('#abDay').val(''); $('#abUserId').val(''); $('#abLesson').val('');
						$('#addAbsModal').modal('toggle');
						updateAbs(user_id, lesson, 'add');
						sweetAlert(res.text, res.type);
					}
				});
			});

			// Handling deleting an absence
			function deleteAbsFx(){
				$('.delete_abs_btn').click(function(){
					var absence_id = $(this).data('mrkid');
					var usrid = $(this).data('usrid');
					var lesson = $(this).data('lsn');
					$('#deleteAbsModal').modal('toggle');
					$('#daSubmitButton').click(function(){
						$.ajax({
							type: "POST",
							url: "/index.php/absences/delete_abs",
							data: {absence_id: absence_id, user_id: usrid},
							dataType: "json",
							success: function (res) {
								updateAbs(usrid, lesson, 'del');
								$('#deleteAbsModal').modal('toggle');
								sweetAlert(res.text, res.type);
							}
						});
					});
				});
			}

			// Update the user's absences
			function updateAbs(user_id, lesson, type){
				$.ajax({
					type: "POST",
					url: "/index.php/teacher/update_absences",
					data: {user_id: user_id, lesson: lesson},
					dataType: "json",
					success: function (res) {
						var abs = [];

						res.forEach(ab => {
							abs.push(ab);
						});

						$('#' + user_id + '-avg').html(abs.length);

						genAbs(abs, user_id, lesson);
						$('#' + user_id + '-marksTable').css('margin-left', $(window).innerWidth());
						

						var totMarks = $('.infobar_abs .abs_num').html();
						if(type == 'add'){
							showAbsNum(parseInt(totMarks.substring(0, totMarks.indexOf('absente'))) + 1 * 2); // NOTE: CHANGE * 2 TO 1 For schools with 45 min lessons
						}else if(type == 'del'){
							showAbsNum(parseInt(totMarks.substring(0, totMarks.indexOf('absente'))) - 1 * 2);
						}
					}
				});
			}

	// RegUsr
		// Add a New
		$('.misc_students_list .addMarkButton').click(function(){
			$('#addStudentModal').modal('toggle');
			$('#addUsrSubmitButton').click(function(){
				var data = $('#addUsrForm').serializeArray();
				$.ajax({
					type: "POST",
					url: "/index.php/regusr/add_usr",
					data: {lastname: data[0].value, firstname: data[1].value, language: data[2].value},
					dataType: "json",
					success: function (res) {
						sweetAlert(res.text, res.type);
						$('.sa-confirm-button-container .confirm').click(function(){
							window.location.reload();
						});
					}
				});
			});
		});

	function assignstudents(allStudents, assigned){
		$('.assignUsrModalList').html("");
		allStudents.forEach(st => {
			var stat = false;
			assigned.forEach(assignSt => {
				if(st['user_id'] == assignSt['user_id']){
					stat = true;
				}
			});
			if(stat){
				$('.assignUsrModalList').append(`<div class="col-10 col-md-10">${st['firstname']} ${st['lastname']}</div>
				<div class="col-2 col-md-2">
					<label class="switch">
						<input type="checkbox" id="${st['user_id']}-assign" checked>
						<span class="slider round"></span>
					</label>
				</div>`); 
			}else if(stat == false){
				$('.assignUsrModalList').append(`<div class="col-10 col-md-10">${st['firstname']} ${st['lastname']}</div>
				<div class="col-2 col-md-2">
					<label class="switch">
						<input type="checkbox" id="${st['user_id']}-assign">
						<span class="slider round"></span>
					</label>
				</div>`); 
			}
		});
		submitAssign(allStudents);
	}

	$('.infobar_marks .stModList').click(function(){
		$('#editAssignLesson').modal('toggle');
	});

	function submitAssign(allStudents){
		$('#editAssignButton').click(function(){
			var values = [];
			var lsn = $('.infobar_marks .stModList').data('lesson');
			allStudents.forEach(st => {
				values.push({'user_id': st['user_id'], 'val': $(`#${st['user_id']}-assign`).is(':checked')});
			});
			$.ajax({
				type: "POST",
				url: "/index.php/lessons/assignSt",
				data: {data: values, lsn: lsn},
				dataType: "html",
				success: function (res) {
					window.location.reload();
				}
			});
		});
	}
		
});