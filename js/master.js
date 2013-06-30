(function() {
	var master = function(){};
	master.prototype = {
		tagToggle: function() {
			$('.about_me_tag').click(function(){
				$(this).siblings('ul').slideToggle('slow');
				return false;
			});
		},
		handleClick: function() {
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
				
				if( parseInt($('.article_list').css('top')) == 0) return false;
				that.showList();
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
				var is_delete = confirm('确定要删除么?');
				if(!is_delete) {
					return false;
				}
				return true;
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
		back.handleClick();
		back.hiddenList();
	};
})();

