$(function(){
  $(".Fr-star.userChoose").Fr_star(function(rating){
    $.post("index.php", {'id' : 'index_page', 'rating': rating}, function(){
    });
  });
});
