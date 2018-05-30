$("document").ready(function(){
	var loaded = 0;

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

	// List Control
	if($('.lessonsListModal').length > 0){
		$.ajax({
			type: "POST",
			url: "/index.php/admin/get_object_list",
			dataType: "json",
			success: function (res) {
				res.forEach(lsn => {
					$('.lessonsListModal').append(`<li class="list-group-item" data-id='${lsn.lesson_id}'>${lsn.lesson_name}<div class='delObject delObj' data-id='${lsn.lesson_id}' data-name='${lsn.lesson_name}'><i class="fas fa-times fa-lg"></i></div></li>`);
				});
				$('.lessonsListModal').append(`<li class="list-group-item listBtnsAdd listBtns" id='objectAdd'><i class="fas fa-plus fa-lg"></i></li>`);
				$('#objectAdd').click(function(){
					$('#addClassesModal').modal('toggle');
				});
				deleteHandle();
			}
		});
	}

	// Add Object Handle
	$('#addObjectForm').submit(function(e){
		e.preventDefault();
		var lsn_name = $('#obj_name').val();
		var lsn_name_shrt = lsn_name.toLowerCase();
		var type = $('#avgTypeObj').val();

		$.ajax({
			type: "POST",
			url: "/index.php/lessons/add_lesson",
			data: {lesson_name: lsn_name, lesson_shrt: lsn_name_shrt, avg_type: type},
			dataType: "json",
			success: function (res) {
				$('#addClassesModal').modal('toggle');
				sweetAlert(res.text, res.type);
				$('.sa-confirm-button-container .confirm').click(function(){
					window.location.reload();
				});
			}
		});
	});

	// Delete Object Handle
	function deleteHandle(){
		$('.delObj').click(function(){
			var id = $(this).data('id');
			var name =  $(this).data('name');
			swal({
				title: "Sunteti Siguri?",
				text: `Doriti sa stergeti obiectul ${name} din lista orelor si toate notele legate cu acesta? (recomandat de facut un backup a bazei de date inainte de aceasta procedura)`,
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Da, sterge!",
				closeOnConfirm: false
			  },
			  function(){
				swal("Succes!", `Obiectul ${name} a fost sters.`, "success");
			  });
			
			$('.sa-confirm-button-container .btn-danger').click(function(){
				$.ajax({
					type: "POST",
					url: "/index.php/lessons/delete_lesson",
					data: {lesson_id: id},
					dataType: "html",
					success: function (res) {
						$('.sa-confirm-button-container .confirm').click(function(){
							window.location.reload();
						});
					}
				});
			});
		});
	}

	// Assign the objects to classes
	$('#attrForm').submit(function(e){
		e.preventDefault();
		var dir_id = $('#classSelect').val();
		showLessons(dir_id);
	});

	function showLessons(dir_id){
		$.ajax({
			type: "POST",
			url: "/index.php/lessons/get_cls_lessons",
			data: {dir_id: dir_id},
			dataType: "json",
			success: function (res) {
				$('#classObjList').removeClass('hidden');
				//console.log(res);
				$('#assignObjectsSel').html("");
				res['unassigned'].forEach(lsn => {
					$('#assignObjectsSel').append($('<option>', {
						value: lsn.lesson_id,
						text: lsn.lesson_name
					}));
				});

				$('#assignedList').html("");
				res['assigned'].forEach(lsn => {
					$('#assignedList').append(`<li class="list-group-item" data-id='${lsn.lesson_id}'>${lsn.lesson_name}<div class='delObject delAssgn' data-id='${lsn.lesson_id}' data-name='${lsn.lesson_name}'><i class="fas fa-times fa-lg"></i></div></li>`);
				});

				assignLsn(dir_id);
				deleteHandleAssign(dir_id);
			}
		});
	}

	// Assign lesson form handle
	function assignLsn(cls){
		$('#assignObjForm').submit(function(e){
			e.preventDefault();
			var id = $('#assignObjectsSel').val();
			$.ajax({
				type: "POST",
				url: "/index.php/lessons/assignObject",
				data: {lesson_id: id, dir_id: cls},
				dataType: "html",
				success: function (res) {
					showLessons(cls);	
				}
			});
		});
	}

	// Assign Object Handle
	function deleteHandleAssign(dir_id){
		$('.delAssgn').click(function(){
			var id = $(this).data('id');
			var name =  $(this).data('name');
			swal({
				title: "Sunteti Siguri?",
				text: `Doriti sa stergeti obiectul ${name} din lista orelor acestei clase si toate notele legate cu acesta? (recomandat de facut un backup a bazei de date inainte de aceasta procedura)`,
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Da, sterge!",
				closeOnConfirm: false
				},
				function(){
				swal("Succes!", `Obiectul ${name} a fost sters.`, "success");
				});
			
			$('.sa-confirm-button-container .btn-danger').click(function(){
				$.ajax({
					type: "POST",
					url: "/index.php/lessons/delete_assign",
					data: {dir_id: dir_id, lesson_id: id},
					dataType: "html",
					success: function (res) {
						showLessons(dir_id);
					}
				});
			});
		});
	}

	// Handle Classes Displaying
	function showClasses(){
		$.ajax({
			type: "POST",
			url: "/index.php/admin/showAllClasses",
			dataType: "json",
			success: function (res) {
				$('.activeClassesList').html("");
				console.log(res);
				res['classes'].forEach(cls => {
					$('.activeClassesList').append(`<li class="list-group-item" data-id='${cls['user_id']}' style='text-align:center; '>${cls['class']}</li>`); // TODO: Redesign the display of the classes
				});
			}
		});
	}

	$('#regUsrShowButton').click(function(){
		$('#showClassesModal').modal('toggle');
		showClasses();
	});

	$('#regUsrRegButton').click(function(){
		$('#regClassModal').modal('toggle');
	});


	regFormSubmit();
	function regFormSubmit(){
		$('#regClassForm').submit(function(e){
			e.preventDefault();
			var firstname = $('#dirFirstName').val().charAt(0).toUpperCase() + $('#dirFirstName').val().slice(1).toLowerCase();
			lastname = $('#dirLastName').val().charAt(0).toUpperCase() + $('#dirLastName').val().slice(1).toLowerCase(),
			className = $('#regClassClassname').val(),
			years = $('#regClassYears').val(),
			profil = $('#regUsrProfil').val();

			$.ajax({
				type: "POST",
				url: "/index.php/admin/regNewClass",
				data: {firstname: firstname, lastname: lastname, className: className, years: years, profil: profil},
				dataType: "json",
				success: function (res) {
					sweetAlert(res.text, res.type);
					$('#regClassModal').modal('toggle');
					$('#dirFirstName').val(""); $('#dirLastName').val(""); $('#regClassClassname').val(""); $('#regClassYears').val(""); $('#regUsrProfil').val("");
				}
			});
		});
	}

});