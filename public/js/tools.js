jQuery( function( $ ) {
  // 表示/非表示
  $(".display-switch").on("click", function() {
  	var status = $(".display", this).text();
  	if (status == "非表示にする") {
  	  $(this).parent().find("table").hide();
  	  $(".display", this).text("表示する");
    } else {
  	  $(this).parent().find("table").show();
  	  $(".display", this).text("非表示にする");
    }
  });

});
