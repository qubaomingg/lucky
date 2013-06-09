(function() {
	var lucky = function(){};
	lucky.prototype = {
		the_same_height: function(obj1, obj2) {
			var h1 = parseInt(obj1.css('height'));
			var h2 = parseInt(obj2.css('height'));
			var larger = h1 > h2 ? h1 : h2;
			obj1.css('height', larger + 'px');
			obj2.css('height', larger + 'px');
		},
		roll_arrow: function() {
			$('.list_taggle').hover(function() {
				$(this).addClass('arrowRotate');
			},function() {
				$(this).removeClass('arrowRotate');
			});
		},
		achieve_click: function() {
			that = this;
			$('.achieve_nav li').click(function() {
				$('.achieve_nav li').removeClass('achieve_nav_active');
				$(this).addClass('achieve_nav_active');
				that.show_article_list();
				
				return false;
			});
		},
		show_article_list: function() {
			$('#list').show();
			var top = $('.achieve_nav_active').position().top;
			$('#list').css('top', top + 'px');
			$('#list').animate({
				'width':'725px'
			},200,function() {
				$(this).animate({'height': '690px','top': top - 3 + 'px'},100);
			});
		},
		hide_article_list: function() {
			$.each([$('header'), $('#achieve_detail article'), $('#achieve')], function() {
				$(this).on('click', function() {
					var top = $('.achieve_nav_active').position().top;
					console.log(top);
					$('#list').animate({
						'height': '40px',
						'top': top + 'px'
						},500,function() {
							$(this).animate({'width':'0px'},100,function() {
								$(this).hide();
							});

					});	
				});
			});
		},
		article_top: function() {
			$('#more_wrap a').click(function() {
				$(document.body).animate({
					'scrollTop':'0px'
				}, 500);
				console.log('ds');
				return false;
			});
		},
		leave_welcome: function() {
			$('.welcome_article .read_all').click(function() {
				$('#welcome').animate({
					'width': '0px',
					'left': '480px'
				},1000,function() {
					$("#welcome").css('display', 'none');
					$('footer').css('marginTop', '0px');
				});
				$('#main').fadeIn('slow').animate({
						'width': '100%',
						'marginLeft': '0px'
					},500,function() {
				});
				return false;
			});
		}

	}
	window.onload = function() {
		var pixeldot = new lucky();
		pixeldot.the_same_height($('#achieve'), $('#achieve_detail'));
		pixeldot.roll_arrow();
		pixeldot.achieve_click();
		pixeldot.hide_article_list();
		pixeldot.article_top();
		pixeldot.leave_welcome();
		
	};
})();

