//function to post values to index.php
$(function(){
  $(".Fr-star.userChoose").Fr_star(function(rating, elm){
  	var topicId = $(elm).parent().data('topic-id');
    $.post("index.php", {'id' : 'index_page', 'rating': rating ,'top': topicId}, function(){
    });
  });
});
