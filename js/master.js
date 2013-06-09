(function() {
	var master = function(){};
	master.prototype = {
		tagToggle: function() {
			$('.about_me_tag').click(function(){
				$(this).siblings('ul').slideToggle('slow');
				return false;
			});
		},
		timeClick: function() {
			that = this;
			$('.time').click(function() {
				$('.time').removeClass('time_now');
				$(this).addClass('time_now');
				console.log(parseInt($('.article_list').css('top')));
				if( parseInt($('.article_list').css('top')) == 0) return false;
				that.showList();
				return false;
			});
		},
		showList: function() {
			var top = $('.time_now').position().top;

			$('.article_list').css('top', top + 'px');
			$('.article_list').animate({
				'width':'671px'
			},500,function() {
				$(this).animate({'height': '580px','top': '0px'},100);
			});
		},
		hiddenList: function() {
			$.each([$('header'), $('.back_article article')], function() {
				$(this).on('click', function() {
					var top = $('.time_now').position().top;
					$('.article_list').animate({
						'height': '24px',
						'top': top
						},500,function() {
							$(this).animate({'width':'0px'},100);
					});	
				});
			});
		}

	}

	window.onload = function() {
		var back = new master();
		back.tagToggle();
		back.timeClick();
		back.hiddenList();
	};
})();

