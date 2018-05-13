jQuery( function( $ ) {
  // 表示/非表示
  $('.display-switch').on('click', function() {
  	var status = $('.display', this).text();
  	if (status == '非表示にする') {
  	  $(this).parent().find('table').hide();
  	  $('.display', this).text('表示する');
    } else {
  	  $(this).parent().find('table').show();
  	  $('.display', this).text('非表示にする');
    }
  });

 

  // メニューリンク

  var mode = 'close'; 

  $('#menus').addClass('menuClose').append("<i class='fa fa-4x fa-chevron-circle-left' aria-hidden='true' id='arrow' title='メニューリンクを開く'></i><div id='linkMenus'></div>").on('click', function(){

  	menuMove(mode);

  });

  $('#linkMenus').append("<button id='linkCompany' class='btn btn-default btn-sm'>事業者検索</button><br><button id='linkFactory' class='btn btn-default btn-sm'>事業所検索</button><br><button id='linkChemical' class='btn btn-default btn-sm'>化学物質検索</button><br><button id='linkCompare' class='btn btn-default btn-sm'>事業所比較</button><br><button id='linkMenu' class='btn btn-default btn-sm'>メニュー</button><br><button id='pageUp' class='btn btn-default btn-sm'>ページトップへ</button>").css({

  	  height: '100%',

  	  width: '0rem'

  	});


  function menuMove(m) {

  	switch (m) {

  	  case 'close':

  	  	$('#menus').animate({

  	  	  bottom: '0.1rem',

  	  	  right: '1rem'

  	  	}, 200, 'swing', function(){

  	  	  $('#linkMenus').animate({

  	  	  	height: '100%',

  	  	  	width: '20rem'

  	  	  }, 200, 'swing', function(){

  	  	    $("#linkMenus .btn-sm").css('width', '20rem');

  	  	  });

  	  	  $('#arrow').removeClass('fa-chevron-circle-left').addClass('fa-chevron-circle-right').attr('title', 'メニューリンクを閉じる');

  	  	  mode = 'open';

  	  	});

  	    break;

  	  case 'open':

  	  	$('#linkMenus').animate({

  	  	  height: '100%',

  	  	  width: '0rem'

  	  	}, 200, 'swing');

  	  	$('#menus').animate({

  	  	  bottom: '0.1rem',

  	  	  right: '1rem'

  	  	}, 200, 'swing', function(){

  	  	  $('#arrow').removeClass('fa-chevron-circle-right').addClass('fa-chevron-circle-left').attr('title', 'メニューリンクを開く');

  	  	  mode = 'close';

  	  	});

   	}

  }


  $('#linkCompany').on('click', function(){

  	location.href = '/company/search';
  });
  $('#linkFactory').on('click', function(){
  	location.href = '/factory/search';
  });
  $('#linkChemical').on('click', function(){
  	location.href = '/chemical/search';
  });
  $('#linkCompare').on('click', function(){
  	location.href = '/discharge/search';
  });
  $('#linkMenu').on('click', function(){

  	location.href = '/';

  });

  $('#pageUp').on('click', function(){

    location.href = '#breadcrumbs';
  });
 
   //テーブルソーターを適応する
  $('.tablesorter-green').tablesorter();

});
