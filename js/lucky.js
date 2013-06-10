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
			// click nav li to ask for list info
			$('.achieve_nav li').click(function() {
				var type = $(this).index();

				$.ajax({
					type: "POST",
					url: '/main/response_type_ajax',
					dataType: 'json',
					data:{'type': type},
					timeout: 20000,
					beforeSend: function() {
						$('#article_list').empty().innerHTML = '<img class="loading" src="../img/load.gif">';
					},
					success: function(json) {

						var article_list_child = '';
						var sum = json['sum'];
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
						article_list_child += "<div id='navigation'><ul class='clearfix'><li><a href=''>首页</a></li><li><a href=''><<</a></li><li><a href=''>1</a></li>";
						if(sum > 2) {
							article_list_child += "<li><a href=''>2</a></li>";
						}
						if(sum > 4) {
							article_list_child += "<li><a href=''>3</a></li>";
						}
						article_list_child += "<li><a href=''>>></a></li><li><a href=''>尾页</a></li></ul></div>";
						
						
						$('#article_list').empty().html(article_list_child);
						return false;
					},
					error: function(jqxhr, txtstatus, errthrown) {
						console.log(errthrown);
						$('#article_list').empty().html("<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p>");	
					}
				});
			});

		}


	}
	window.onload = function() {
		var pixeldot = new lucky();
		pixeldot.the_same_height($('#achieve'), $('#achieve_detail'));
		pixeldot.roll_arrow();
		pixeldot.hand_click();
	};
})();

