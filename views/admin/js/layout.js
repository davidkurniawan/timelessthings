var h = $(document).height();
$toggleNav = $("#toggleNav"),
$mainContent = $("#mainContent");
$(document).ready(function() {

	// $("#mainContent").height(h);

	$("#toggleNav").on("click", function() {
		var self = this;

		if ($("#leftContent").hasClass("collapse")) {

			$("#leftContent").removeClass("collapse");
			$(self).removeClass("active");
			$("#menuBar > li:first-child > a").trigger("click");
			$mainContent.css("padding-left", 270);
		} else {
			
			$(self).addClass("active");
			$("#leftContent").addClass("collapse");
			
			
			$("#menuBar").children().removeClass("current");
			$mainContent.css("padding-left", 70);
			

		}

		return false;
	});
	
	$("#menuBar > li:first-child > a").trigger("click");
});
// 
$(window).on("scroll", function() {
	if ($(this).scrollTop() >= 1) {
		$("#header").addClass('sticky');
	} else {
		$("#header").removeClass('sticky');
	}

});



// Submenu Pager
// 
$('#menuBar > li > a').click(function() {
	$('#menuBar > li > a').parent().removeClass('current');
	// var index = $(this).parent().index();
// 
	// submenu.pager('goto', index);
	$(this).parent().addClass('current');

});

function convert_time(duration) {
	var a = duration.match(/\d+/g);

	if (duration.indexOf('M') >= 0 && duration.indexOf('H') == -1 && duration.indexOf('S') == -1) {
		a = [0, a[0], 0];
	}

	if (duration.indexOf('H') >= 0 && duration.indexOf('M') == -1) {
		a = [a[0], 0, a[1]];
	}
	if (duration.indexOf('H') >= 0 && duration.indexOf('M') == -1 && duration.indexOf('S') == -1) {
		a = [a[0], 0, 0];
	}

	duration = 0;

	if (a.length == 3) {
		duration = duration + parseInt(a[0]) * 3600;
		duration = duration + parseInt(a[1]) * 60;
		duration = duration + parseInt(a[2]);
	}

	if (a.length == 2) {
		duration = duration + parseInt(a[0]) * 60;
		duration = duration + parseInt(a[1]);
	}

	if (a.length == 1) {
		duration = duration + parseInt(a[0]);
	}
	var h = Math.floor(duration / 3600);
	var m = Math.floor(duration % 3600 / 60);
	var s = Math.floor(duration % 3600 % 60);
	return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
}


function parseTpl(template, data) {
	// initiate the result to the basic template
	res = template;
	// for each data key, replace the content of the brackets with the data
	for (var i = 0; i < data.length; i++) {
		res = res.replace(/\{\{(.*?)\}\}/g, function(match, j) {// some magic regex
			return data[i][j];
		})
	}
	return res;
}// and that's it!


function playVideo(el) {
	var videoId = el.getAttribute('data-videoId');
	$parent = $(el).parent().parent();
	$(el).parent().parent().addClass('isPlay');
	$parent.html('<iframe src="https://www.youtube.com/embed/' + videoId + '?controls=1&autoplay=1&fs=1&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0&version=3&enablejsapi=1" allowfullscreen frameborder="0"></iframe>');
	//	$parent.addClass("isPlay");
	// $(el).parent().hide();
}
