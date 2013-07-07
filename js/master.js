(function() {
	var master = function(){};
	master.prototype = {
		hasList: false,
		tagToggle: function() {
			$('.about_me_tag').click(function(){
				$(this).siblings('ul').slideToggle('slow');
				return false;
			});
		},
		handleClick: function() {
			// .article_list li click
			$('.article_list').on('click', 'li', function() {
				var title = $(this).find('.back_article_header').find('h2').text();
				$.ajax({
					type: 'POST',
					url: '/main/get_read_all',
					dataType: 'json',
					timeout: 10000,
					data: {'title': title},
					success: function(json) {
						var article_detail = '';
						article_detail += "<div class='back_article_header'><h2>"+json['atitle']+"</h2><time>"+json['atime']+"｜"+json['anum']+"</time></div><section>"+json['abody']+"</section>";
						$(".back_article article").empty().html(article_detail);

						$('#write_update').attr('href','/master/update/'+json['detailid']);

					},
					error: function() {
						var error = "<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p>";
						$(".back_article article").empty().html(error);
					}
				});
				$('#header_content header').click();
				return false;
			});
			// tag click
			$('#oldTag').on('click', 'span', function() {
				var content = $(this).text();
				var oldstr = $('#add_tag').val();

				if(!oldstr) oldstr = "";
				if(oldstr !== '') {
					oldstr += "," + content;	
				} else {
					oldstr += content;
				}
				$('#add_tag').val(oldstr);
			});

			// time click
			that = this;
			$('.time').click(function() {
				$('.time').removeClass('time_now');
				$(this).addClass('time_now');
				that.showList();
				var type = $(this).attr('data-type');
				var time = $(this).attr('data-value');
				current = 1;
				
				that.article_ask(type, time, current);
				return false;
			});
			// ok click;
			$('#write_ok').click(function() {
				var title = $('#add_title').val();
				var achieve = $('#add_achieve').val();
				var tags = $('#add_tag').val();
				var content = tqEditor.content();
				
				 
				if(title == '' || achieve == '' || tags == ''|| content == '') {
					alert('请输入完整的文章信息！');
				}else {
					$('#write').val(content);
					$('#add_form').submit();	
				}
				return false;
			});

			$("#write_delete").click(function() {
				var title = $('.back_article_header h2').text();
				if(!title) {
					return false;
				}
				var is_delete = confirm('确定要删除么?');
				if(!is_delete) {
					return false;
				}
				return true;
			});

			// navigation > li > a click.
			$('.article_list').on('click', '#navigation a', function() {
				var type = $(this).parents('.clearfix').eq(0).attr('data-value');
				var year = $(this).parents('.clearfix').eq(0).attr('data-time');
				var current = $(this).parents('.clearfix').eq(0).attr('data-current');
				var sum = $(this).parents('.clearfix').eq(0).attr('data-sum');//sum false;
				
				var value = $(this).attr('data-value');

				switch (value) {
					case 'first': 
						current = 1;
						
						that.article_ask(type, year, current);
						break;
					case 'previous': 
						//if the current is not 1.

						if( current != 1) {
							current = current - 1;
							that.article_ask(type, year, current);
						}
						break;
					case 'next':
						if( parseInt(current) != parseInt(Math.ceil(sum/2))) {
							current = current + 1;
							that.article_ask(type, year, current);
						}
						break;
					case 'last':

						if( parseInt(current) != Math.ceil(sum/2)) {
							current = Math.ceil(sum/2);
							that.article_ask(type, year, current);
						}					
						break;
					default:
						// match the other.
						current = value;
						that.article_ask(type, year, current);
				}	
				return false;
			});

		},
		
		article_ask: function(type, time, current) {
			$.ajax({
				type: "POST",
				url: "/master/get_master_article",
				dataType: 'json',
				data: {'type': type, 'time': time, 'current':current},
				timeout: 10000,
				beforeSend: function() {
					$('.article_list').empty().innerHTML = '<img class="loading" src="../img/load.gif">';
				},
				success: function(json) {
					
					json2article(json, type, time, current);
					setCurrent();
				},
				error: function(xhr, status, thrown) {
					
					var error = "<p class='error'>I'm sorry, your Internet connection is not good, please try again later</p><div id='navigation'><ul class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a href='' data-value='1'>1</a></li><li><a href='' data-value='2'>2</a></li><li><a href='' data-value='3'>3</a></li><li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";
					$('.article_list').empty().html(error);	
				}
			});
		},
		
		showList: function() {
			if(!this.hasList) {
				var top = $('.time_now').position().top;
				$('.article_list').css('top', top + 'px');	
				$('.article_list').animate({
					'width':'671px'
				},300,function() {
					$(this).animate({'height': '448px','top': '0px'},100);
				});	
			}
			this.hasList = true;
		},
		hiddenList: function() {
			var that = this;
			$.each([$('header'), $('.back_article article')], function() {
				$(this).on('click', function() {
					var top = $('.time_now').position().top;
					$('.article_list').animate({
						'height': '24px',
						'top': top
						},500,function() {
							that.hasList = false;
							$(this).animate({'width':'0px'},100);
					});	
				});
			});
		}

	}
	function setCurrent() {
		var current = $('#navigation ul').attr('data-current');
		var now = parseInt(current) + 1;
		$('#navigation ul').find('a').removeClass('iamcurrent');

		$('#navigation ul').find('a').eq(now).addClass('iamcurrent');
	}
	 function json2article(json, type, time, current) {
			var pre, fakenext, fakecurrent = 0;
			var sum = json['sum'];
			var year = json['year'];
			
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
			var article_list_child = '<ul>';
			
			// concat the required list. 

			for(var key in json) {

				if(key != 'sum' && key != 'year' && sum != 0 ) {
					article_list_child += "<li><div class='back_article_header'><h2>"+json[key].title+"</h2><time>"+json[key]['time']+"｜"+json[key]['num']+"</time></div><section><p>"+json[key]['describe']+"</p></section></li>";
				} else if(sum == 0) {
					article_list_child +="<li><p>还没有文章呢！</p></li>";
				}

			}
			article_list_child += "</ul>";
			article_list_child += "<div id='navigation'><ul data-time='"+year+"'data-sum='"+sum+"' data-current='"+current+"' data-value='"+type+"' class='clearfix'><li><a href='' data-value='first'>首页</a></li><li><a href='' data-value='previous'><<</a></li><li><a  href='' data-value='"+pre+"'>"+pre+"</a></li>";
			
			if(sum > 2) {
				article_list_child += "<li><a href='' data-value='"+fakecurrent+"'>"+fakecurrent+"</a></li>";
			}
			if(sum > 4) {
				article_list_child += "<li><a href='' data-value='"+fakenext+"'>"+fakenext+"</a></li>";
			}
			article_list_child += "<li><a href='' data-value='next'>>></a></li><li><a href='' data-value='last'>尾页</a></li></ul></div>";

			$('.article_list').empty().html(article_list_child);
		}

	window.onload = function() {
		var back = new master();
		back.tagToggle();
		back.handleClick();
		back.hiddenList();
	};
})();

