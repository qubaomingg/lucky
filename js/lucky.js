(function($) {
	var lucky = function(){};
	lucky.prototype = {
		msg_placeholder: function() {
			that = this;
			$.each([$('#nickname'), $('#email'), $('#blog'), $('#message_content')], function() {
				that._placeholder($(this));
			});
			$('.placeholder').click(function(){
				$(this).prev().focus();
			});
			$('.textarea_placeholder').click(function(){
				$(this).prev().focus();
			});
			
		},
		_placeholder: function(obj) {
			obj.focus(function() {
				$(this).next('span').css('display','none');
				$(this).css('outline','1px #0192d3 solid');
			});
			obj.blur(function() {
				if(!$(this).val()) {
					$(this).next('span').css('display','inline');	
				}
				$(this).css('outline','1px #3e3d3b solid');
			});	
		},
		draw_circle: function() {
			var canvas = document.getElementById('list_taggle');
			var ctx = canvas.getContext('2d');
			ctx.save();
			ctx.fillStyle = 'white';
			ctx.beginPath();
			ctx.arc(17,17,17,0,Math.PI*2,true);
			ctx.closePath();
			ctx.fill();

			ctx.restore();
			ctx.fillStyle = '#0192d3';
			ctx.beginPath();
			ctx.arc(17,17,14,0,Math.PI*2,true);
			ctx.closePath();
			ctx.fill();

			ctx.lineWidth = 4;
			ctx.strokeStyle = 'white';
			ctx.beginPath();
			ctx.moveTo(20,12);
			ctx.lineTo(13,17);
			ctx.lineTo(20,22);
			ctx.stroke();
		},
		the_same_height: function(obj1, obj2) {
			var h1 = parseInt(obj1.css('height'));
			var h2 = parseInt(obj2.css('height'));
			var larger = h1 > h2 ? h1 : h2;
			obj1.css('height', larger + 'px');
			obj2.css('height', larger + 'px');
		},
		roll_arrow: function() {
			
			$('#list_taggle').hover(function() {
				$(this).addClass('arrowRotate');
				$('#list_taggle').css('-webkit-transform','rotateY(180deg)');
			},function() {
				$('#list_taggle').removeClass('arrowRotate');
			});
			
		},

		hand_click: function() {
			that = this;
			// response message.
			$('.msg_response').click(function() {
				// save time&name to class then form bring from here.
				var time = $(this).prev().text();
				var name = $(this).parents('.say').find('.message_orange').eq(0).text();
				$(this).parents('.message_list').addClass('to_response');
				$(this).parents('.message_list').attr('data-time', time);
				$(this).parents('.message_list').attr('data-name', name);
				
				$('.msg_form input').eq(0).addClass('warning');
				$('.msg_form input').eq(0).focus();
				// remaind to cancel all of this!
				return false;
			});
			// msg submit 
			$('#update_msg_list').click(function() {
				
				// update list
				$.ajax({
					type:'POST',
					url: '/main/update_msg_list',
					timeout: 10000,
					dataType: 'json',
					success: function(json) {
					
						var message_main = '';
						var msglist = json['msg'];
						
						for(var i in msglist) {
							var imgsrc = msglist[i]['nickname'] == 'lucky_pixeldot' ? '../img/message_host.png' : '../img/message_guest.gif';
							message_main += "<div class='message_list'><img src='"+imgsrc+"'><div class='say'><p><span class='message_orange'>"+msglist[i]['mnickname']+"</span>: "+msglist[i]['mbody']+"</p><p><span class='message_time'>"+msglist[i]['mtime']+"</span><a href='' class='msg_response message_orange'>[回复]</a></p></div></div>";
						}
						$('#message_main').empty().html(message_main);
					},
					error: function() {
						// do nothing.
					}
				});
			});
			$('#msg_submit').click(function() {
				// msg form submit 
				var nickname = $('#nickname').val();
				var email = $('#email').val();
				var blog = $('#blog').val();
				var msg = $('#message_content').val();
				
				$.ajax({
					type:'POST',
					url: '/main/msg',
					timeout: 10000,
					dataType: 'json',
					data: {'nickname':nickname, 'email':email,'blog':blog,'message_content':msg},
					success: function(json) {

						$('.msg_form input').val('');
						$('#message_content').val('');
						$('.msg_form input').eq(3).val('留言');// 上面语句会吧留言也消除
						$('.msg_form input').focus().blur();// generat placeholder
						$('#message_content').focus().blur();
						$('.msg_form input').eq(0).focus();
					},
					error: function() {
						// do noting.
					}
				});

				setTimeout(_updatelist, 1000);
				function _updatelist() {
					$('#update_msg_list').click();	
				}
				return false;
			});
			//welcome 2 aticle
			$('.welcome_article .read_all').click(function() {
				var title = $(this).siblings('.article_txt').find('h1').text();
				$.ajax({
					type: 'POST',
					url: '/main/set_num_welcome',
					timeout: 10000,
					data: {'title': title}
				});
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
						that.the_same_height($('#achieve'), $('#achieve_detail'));
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
			$('.list_taggle_outer').click(function() {
				$('.achieve_nav_active').click();
				return false;
			});
			// click somewhere to hide list
			$.each([$('header'), $('#achieve_detail article')], function() {
				$(this).on('click', function() {
					var type = $('.achieve_nav_active').index() + 1;
					$('.list_taggle_outer').append($("<canvas id='list_taggle' width='35' height='35'></canvas>"));
					that.draw_circle();
					that.roll_arrow();
					_move_arrow(type);
					var top = $('.achieve_nav_active').position().top;
					$('#list').animate({
						'height': '40px',
						'top': top + 'px'
						},500,function() {
							$(this).animate({'width':'0px'},100,function() {
								$(this).hide();
							});
					});	
					function _move_arrow(type) {
							
							if(type == 1) {
								$('.list_taggle_outer').animate({
									'top': '3px'
								},'slow');
							} else if(type == 2) {
								$('.list_taggle_outer').animate({
									'top': '44px'
								},'slow');
							} else {
								$('.list_taggle_outer').animate({
									'top': '84px'
								},'slow');
							}
						}
				});
			});
			// click nav li fadeIn list
			
			$('.achieve_nav li').click(function() {
				$('#list_taggle').fadeOut('slow', function() {
					$('.list_taggle_outer').empty();	
				});
				$('.achieve_nav li').removeClass('achieve_nav_active');
				$(this).addClass('achieve_nav_active');
				var top = $('.achieve_nav_active').position().top;
				show_article_list(top);
				return false;
			});
			var that = this;
			// read all click.
			$('#article_list').on('click', '.read_all a', function() {
				var title = $(this).parents('.article_show').find('header').find('h2').text();
				$('.list_taggle_outer').append($("<canvas id='list_taggle' width='35' height='35'></canvas>"));
				
				that.draw_circle();
				that.roll_arrow();
				$.ajax({
					type: 'POST',
					url: '/main/set_num_welcome',
					timeout: 10000,
					data: {'title': title}
				});

				$.ajax({
					type: 'POST',
					url: '/main/get_read_all',
					dataType: 'json',
					timeout: 10000,
					data: {'title': title},
					success: function(json) {
						var type = json['type'];
						
						_move_arrow(type);
						
						var article_detail = '';
						article_detail += "<header class='article_header'><h2>"+json['atitle']+"</h2><p>"+json['atime']+" | 阅读: "+json['anum']+"</p></header><section class='article_body'>"+json['abody']+"</section>";
						$("#achieve_detail article").empty().html(article_detail);
						function _move_arrow(type) {
							
							if(type == 1) {
								$('.list_taggle_outer').animate({
									'top': '3px'
								},'slow');
							} else if(type == 2) {
								$('.list_taggle_outer').animate({
									'top': '44px'
								},'slow');
							} else {
								$('.list_taggle_outer').animate({
									'top': '84px'
								},'slow');
							}
						}
					},
					error: function() {
						var error = "<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p>";
						$("#achieve_detail article").empty().html(error);
					}
				});
				$('#achieve_detail article').click();
				return false;
			});

			// navigation of list
			$('#article_list').on('click', '#navigation a', function() {
				var type = $(this).parents('.clearfix').eq(0).attr('data-value');
				
				var current = $(this).parents('.clearfix').eq(0).attr('data-current');
				var sum = $(this).parents('.clearfix').eq(0).attr('data-sum');//sum false;
				
				var tagbody = $(this).parents('.clearfix').eq(0).attr('data-tagbody');

				var value = $(this).attr('data-value');

				// helper: tell tag and time from type ask.
				function _tell_from_type(type,current) {
					if(parseInt(type) > 4) {
						time_ajax(type, current);
					} else {
						if(tagbody) {
							tag_ajax(type, current);
						} else {
							type_ajax(type, current);
						}
					}
				}
				switch (value) {
					case 'first':  
						current = 1;
						_tell_from_type(type, current);	
						break;
					case 'previous': 
						//if the current is not 1.

						if( current != 1) {
							current = current - 1;
							_tell_from_type(type, current);	
						}
						break;
					case 'next':
						if( parseInt(current) != parseInt(Math.ceil(sum/2))) {
							current = current + 1;
							_tell_from_type(type, current);
						}
						break;
					case 'last':

						if( parseInt(current) != Math.ceil(sum/2)) {
							current = Math.ceil(sum/2);
							_tell_from_type(type, current);	
						}					
						break;
					default:
						// match the other.
						current = value;
						_tell_from_type(type, current);
				}	
				return false;
			});
			
			// tag click;
			$('.achieve_tag').on('click', 'a',function() {
				show_article_list(0);
				var current = 1;
				var tagid = $(this).attr('data-value');
				$.ajax({
					type: "POST",
					url: "/main/get_article_tag",
					dataType: 'json',
					data: {'tagid': tagid, 'current': current},
					timeout: 10000,
					beforeSend: function() {
						$('#article_list').empty().innerHTML = '<img class="loading" src="../img/load.gif">';
					},
					success: function(json) {
						json2divstr(json, tagid, current);
						setCurrent();
					},
					error: function(xhr, status, error ) {

						var error = "<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p><div id='navigation'><ul class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a href='' data-value='1'>1</a></li><li><a href='' data-value='2'>2</a></li><li><a href='' data-value='3'>3</a></li><li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";
						$('#article_list').empty().html(error);	
					}
				});	

				return false;
			});
			// timequery click
			$('.achieve_time').on('click', 'a',function() {
				show_article_list(0);
				var querytime = $(this).attr('data-value');
				var current = 1;
				time_ajax(querytime, current);
				return false;
			});
		
			// click nav li to ask for list info
			$('.achieve_nav li').click(function() {
				var type = $(this).index() + 1;
				var current = 1;
				type_ajax(type, current);
			});

			
			// helpers: json(sum,img,describe.title. time. num), current,type
			function json2divstr(json, type, current) {
				var pre, fakenext, fakecurrent = 0;
				var sum = json['sum'];
				var tagbody = '';
				if(json['tagbody']) {
					var tagbody = json['tagbody']['tagbody'];	
				}
				
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

					if(key != 'sum' && key != 'tagbody' && sum != 0 ) {
						article_list_child += "<div class='article_show'><article><header class='article_header'><h2>"+json[key].title+"</h2><p>"+json[key].time+" | 阅读:<span>"+json[key].num+" </span></p></header>";
						if(json[key].img) {
							article_list_child += "<img src=" + json[key].img+" style='width:638px;height:149px'>";
						}
						article_list_child += "<section class='article_body clearfix'><p>"+json[key].describe+"</p><p class='clearfix read_all'><a href=''>阅读全文&#8594;</a></p></section></article></div>";
					} else if(sum == 0) {
						article_list_child +="<div class='article_show'><article><header class='article_header'><h2>没有文章呢！</h2></header></article></div>";
					}

				}
				if(json['tagbody']) {
					article_list_child += "<div id='navigation'><ul data-tagbody='"+tagbody+"' data-sum='"+sum+"' data-current='"+current+"' data-value='"+type+"' class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a  href='' data-value='"+pre+"'>"+pre+"</a></li>";
				} else {
					article_list_child += "<div id='navigation'><ul data-sum='"+sum+"' data-current='"+current+"' data-value='"+type+"' class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a  href='' data-value='"+pre+"'>"+pre+"</a></li>";					
				}

				
				if(sum > 2) {
					article_list_child += "<li><a href='' data-value='"+fakecurrent+"'>"+fakecurrent+"</a></li>";
				}
				if(sum > 4) {
					article_list_child += "<li><a href='' data-value='"+fakenext+"'>"+fakenext+"</a></li>";
				}
				article_list_child += "<li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";

				$('#article_list').empty().html(article_list_child);
			}

			function time_ajax(querytime, current) {
				$.ajax({
					type: "POST",
					url: "/main/get_article_time",
					dataType: 'json',
					data: {'querytime': querytime, 'current': current},
					timeout: 10000,
					beforeSend: function() {
						$('#article_list').empty().innerHTML = '<img class="loading" src="../img/load.gif">';
					},
					success: function(json) {
						json2divstr(json, querytime, current);
						setCurrent();
					},
					error: function(xhr, status, error ) {

						var error = "<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p><div id='navigation'><ul class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a href='' data-value='1'>1</a></li><li><a href='' data-value='2'>2</a></li><li><a href='' data-value='3'>3</a></li><li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";
						$('#article_list').empty().html(error);	
					}
				});	
			}
			function type_ajax(type, current) {
				$.ajax({
					type: "POST",
					url: "/main/get_article_type",
					dataType: 'json',
					data: {'type': type, 'current': current},
					timeout: 10000,
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
			function tag_ajax(type, current) {
				$.ajax({
					type: "POST",
					url: "/main/get_article_tag",
					dataType: 'json',
					data: {'type': type, 'current': current},
					timeout: 10000,
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
			function show_article_list(top) {
				$('#list').show();
				$('#list').css('top', top + 'px');
				$('#list').animate({
					'width':'725px'
				},200,function() {
					$('#main').css('overflow', 'visible');
					$(this).animate({'height': '438px','top': top - 3 + 'px'},100);
				});
			}
		}
	};
	window.onload = function() {
		var pixeldot = new lucky();
		pixeldot.msg_placeholder();
		pixeldot.roll_arrow();
		pixeldot.hand_click();
		pixeldot.draw_circle();
	};
})(jQuery);

