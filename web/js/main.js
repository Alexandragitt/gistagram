$(document).ready(function() {
    var i = 0;
    
    $('.floating-like').on('click', function(e) {
        i++;
        if(i > 2) $('.floating-like').prop('disabled', true);
        var id = $('.like-btn').data('id');
        if(i % 2 != 0) {
       
       
        $.ajax({
            url: '/profile/like',
            data: {id: id},
            type: "POST",
            success: function(res) {
              $('.like-btn').attr('src', '/images/like-active.png');
        value = $('.like-count-notliked').text();
        value++;
        $('.like-count-notliked').text(value).css('color', '#c55');
            },
            error: function() {
            }
        });
    }
        else {
        $('.like-btn').attr('src', '/images/like-unactive.png');
        value = $('.like-count-notliked').text();
        value--;
        $('.like-count-notliked').text(value).css('color', '#000');
       
        $.ajax({
            url: '/profile/unlike',
            data: {id: id},
            type: "POST",
            success: function(res) {
             
            },
            error: function() {
            }
        });
        }
    });
    
     $('.floating-unlike').on('click', function(e) { 
        var id = $('.unlike-btn').data('id');
        i++;
        if(i > 2) $('.floating-unlike').prop('disabled', true);
        if(i % 2 !== 0) {
        $('.unlike-btn').attr('src', '/images/like-unactive.png');
        value = $('.like-count-liked').text();
        value--;
        $('.like-count-liked').text(value).css('color', '#000');
       
        $.ajax({
            url: '/profile/unlike',
            data: {id: id},
            type: "POST",
            success: function(res) {
             
            },
            error: function() {
            }
        });
        }
        else {
            $('.unlike-btn').attr('src', '/images/like-active.png');
        value = $('.like-count-liked').text();
        value++;
        $('.like-count-liked').text(value).css('color', '#c55');
       
        $.ajax({
            url: '/profile/like',
            data: {id: id},
            type: "POST",
            success: function(res) {
             
            },
            error: function() {
            }
        });
        }
     });
     
     $('.unlike-btn-feed').parent().on('click', function() {
         var id = $(this).data('id');
         $(this).children().attr('src', '/images/like-unactive.png');
         $(this).remove();
         $.ajax({
            url: '/profile/unlike',
            data: {id: id},
            type: "POST",
            success: function(res) {
             
            },
            error: function() {
            }
        });
     });
     
     $('.like-btn-feed').parent().on('click', function() {
         var id = $(this).data('id');
         $(this).children().css('opacity', '0.2');
         $(this).prop('disabled', true);
         $(this).parent().prop('disabled', true);
         $(this).attr('src', '/images/like-active.png');
         $.ajax({
            url: '/profile/like',
            data: {id: id},
            type: "POST",
            success: function(res) {
             
            },
            error: function() {
            }
        });
     });
   $('.block').on('click', function() {
        var res = confirm('Вы уверены, что хотите добавить этого пользователя в чёрный список?');
        if(!res) return false;
   });
   $('.unblock').on('click', function() {
        var res = confirm('Вы уверены, что хотите убрать этого пользователя из чёрного списка?');
        if(!res) return false;
   });
   $('.floating-deletephoto').on('click', function() {
        var res = confirm('Вы уверены, что хотите удалить эту фотографию?');
        if(!res) return false;
   });
    $('.followers').click(function(e) {
        e.preventDefault();
       $('#pModalSubscribers').modal('show')
                  .find('.content')
                  .load('/profile/subscribers');  
   });
});