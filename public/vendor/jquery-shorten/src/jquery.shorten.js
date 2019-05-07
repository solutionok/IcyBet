$(document).ready(function() {
  var showChar = 80;
  var ellipsestext = "...";
  var moretext = "more";
  var lesstext = "less";
  $('.shorten-more').each(function() {
    var content = $(this).html();

    if(content.length > showChar) {

      var c = content.substr(0, showChar);
      var h = content.substr(showChar-1, content.length - showChar);

      var html = c + '<span class="shorten-moreellipses">' + ellipsestext+ '&nbsp;</span><span class="shorten-morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="#!" class="shorten-morelink link-muted">' + moretext + '</a></span>';

      $(this).html(html);
    }

  });

  $(".shorten-morelink").click(function(){
    if($(this).hasClass("shorten-less")) {
      $(this).removeClass("shorten-less");
      $(this).html(moretext);
    } else {
      $(this).addClass("shorten-less");
      $(this).html(lesstext);
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
  });
});