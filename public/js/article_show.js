$(document).ready(function(){

    $(".js-like-article").on('click',function(e){
        e.preventDefault();
        var $link = $(e.currentTarget);
        $link.toggleClass("fa fa-heart-o").toggleClass("fa fa-heart");


        $.ajax({
            method:"POST",
            url:$link.attr('href')
        }).done(function(data){
            $(".js-article-count").html(data.hearts);
        })
    })



})