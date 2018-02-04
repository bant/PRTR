jQuery( function( $ ) {
  // 表示/非表示
  $(".display-switch .display").on("click", function() {
  	var status = $(this).text();
  	if (status == "非表示にする") {
  	  $(this).parent().next().hide();
  	  $(this).text("表示する");
    } else {
      $(this).parent().next().show();
  	  $(this).text("非表示にする");
    }
  });

});
