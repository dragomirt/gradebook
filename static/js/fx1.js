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

	// Modify on startup
		if(loaded == 0){
			$('.marksTable').css('margin-left', $(window).innerWidth()*2);
			loaded = 1;
		}

	// Handling the marks page. (class.php)
		function handleUserListClick(){
			$('.usrMarksData').click(function(){
				var id = $(this).data('id');
				$('#objectList').css('margin-left', -1 * $(window).innerWidth());
				$('#' + id + '-marksTable').css('margin-left', $(window).innerWidth());
				if($('.backButton').hasClass('disabled')){
					$('.backButton').removeClass('disabled');
				}
			});
		}

		function returnUserListClick(){
			$('.backButton').click(function(){
				if(!$('.backButton').hasClass('disabled')){
					$('#objectList').css('margin-left', 0);
					$('.marksTable').css('margin-left', $(window).innerWidth()*2);
					$('.backButton').addClass('disabled');
				}
			});
		}

		handleUserListClick();
		returnUserListClick();

	// Animation for hamburger
	$(".hamburger").click(function(){
		$(this).toggleClass("is-active");
		$(".menuUl").slideToggle();
		return false;
	});
});