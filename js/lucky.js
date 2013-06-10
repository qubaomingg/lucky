(function($) {
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

		hand_click: function() {
			//welcome 2 aticle
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
			// back to top
			$('#more_wrap a').click(function() {
				$(document.body).animate({
					'scrollTop':'0px'
				}, 500);
				return false;
			});
			// click somewhere to hide list
			$.each([$('header'), $('#achieve_detail article'), $('#achieve')], function() {
				$(this).on('click', function() {
					var top = $('.achieve_nav_active').position().top;
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
			// click nav li fadeIn list
			that = this;
			$('.achieve_nav li').click(function() {
				$('.achieve_nav li').removeClass('achieve_nav_active');
				$(this).addClass('achieve_nav_active');
				that.show_article_list();
				return false;
			});

			// read all click.


			// navigation of list
			$('#article_list').on('click', '#navigation a', function() {
				var type = $(this).parents('.clearfix').eq(0).attr('data-value');
				var current = $(this).parents('.clearfix').eq(0).attr('data-current');
				var sum = $(this).parents('.clearfix').eq(0).attr('data-sum');
				
				var value = $(this).attr('data-value');
				
				switch (value) {
					case 'first':
						$('.achieve_nav li').eq(type-1).click();
						break;
					case 'previous': 
						//if the current is not 1.

						if( current != 1) {
							current = current - 1;
							ajax_ask(type, current);	
						}
						break;
					case 'next':
						if( parseInt(current) != parseInt(Math.ceil(sum/2))) {
							current = current + 1;
							ajax_ask(type, current);
						}
						break;
					case 'last':

						if( parseInt(current) != Math.ceil(sum/2)) {
							current = Math.ceil(sum/2);
							ajax_ask(type, current);	
						}					
						break;
					default:
						// match the other.
						current = value;
						ajax_ask(type, current);
				}
				return false;
			});

			
			// click nav li to ask for list info
			$('.achieve_nav li').click(function() {
				var type = $(this).index() + 1;
				var current = 1;
				ajax_ask(type, current);
				
			});

			// helpers: json(sum,img,describe.title. time. num), current,type
			function json2divstr(json, type, current) {
				var pre, fakenext, fakecurrent = 0;
				var sum = json['sum'];
				// generate nav number.
				if(current == 1) {
					pre = 1;
					fakecurrent =2;
					fakenext = 3
				} else if(parseInt(current) == Math.ceil(sum/2)) {
					pre = parseInt(current) - 2;
					fakecurrent = current - 1;
					fakenext = current;

				} else {
					pre = parseInt(current) - 1;
					fakecurrent = current;
					fakenext = parseInt(current) + 1;
				}
				var article_list_child = '';
				
				// concat the required list. 
				for(var key in json) {
					if(key != 'sum') {
						article_list_child += "<div class='article_show'><article><header class='article_header'><h2>"+json[key].title+"</h2><p>"+json[key].time+" | 阅读:"+json[key].num+" </p></header>";
						if(json[key].img) {
							article_list_child += "<img src=" + json[key].img+" style='width:638px;height:149px'>";
						}
						article_list_child += "<section class='article_body clearfix'><p>"+json[key].describe+"</p><p class='clearfix read_all'><a href=''>阅读全文&#8594;</a></p></section></article></div>";
					}
				}
				article_list_child += "<div id='navigation'><ul data-sum='"+sum+"' data-current='"+current+"' data-value='"+type+"' class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a  href='' data-value='"+pre+"'>"+pre+"</a></li>";
				if(sum > 2) {
					article_list_child += "<li><a href='' data-value='"+fakecurrent+"'>"+fakecurrent+"</a></li>";
				}
				if(sum > 4) {
					article_list_child += "<li><a href='' data-value='"+fakenext+"'>"+fakenext+"</a></li>";
				}
				article_list_child += "<li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";

				$('#article_list').empty().html(article_list_child);
			}
			function ajax_ask(type, current) {
				$.ajax({
					type: "POST",
					url: "/main/response_type_ajax",
					dataType: 'json',
					data: {'type': type, 'current': current},
					timeout: 20000,
					beforeSend: function() {
						$('#article_list').empty().innerHTML = '<img class="loading" src="../img/load.gif">';
					},
					success: function(json) {
						json2divstr(json, type, current);
						setCurrent();
					},
					error: function() {
						var error = "<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p><div id='navigation'><ul class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a href='' data-value='1'>1</a></li><li><a href='' data-value='2'>2</a></li><li><a href='' data-value='3'>3</a></li><li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";
						$('#article_list').empty().html(error);	
					}
				});	
			}
			function setCurrent() {
				var current = $('#navigation ul').attr('data-current');
				var now = parseInt(current) + 1;
				$('#navigation ul').find('a').removeClass('iamcurrent');

				$('#navigation ul').find('a').eq(now).addClass('iamcurrent');
			}
		}
	};
	window.onload = function() {
		var pixeldot = new lucky();
		pixeldot.the_same_height($('#achieve'), $('#achieve_detail'));
		pixeldot.roll_arrow();
		pixeldot.hand_click();
	};
})(jQuery);

