"use strict"
$(document).ready(function(){

    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }

    if ( $('div').hasClass('comments') ){

        $(document).on('click', '.comment__glyphicon > .glyphicon', function(){

            var $comment_hidden = $(this).parents('.comment').find('.comment-hidden');

            if ( $(this).hasClass('glyphicon-triangle-bottom') ){
                $(this).removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-right');
                $comment_hidden.fadeOut();
            }
            else{
                $(this).removeClass('glyphicon-triangle-right').addClass('glyphicon-triangle-bottom');
                $comment_hidden.fadeIn();
            }
        });

        //обработчик нажатия "ответить"
        $(document).on('click', '.comment__answer', function(e){
            e.preventDefault();
            var $comment_text = $(this).parent().find('.comment__text').text();
            var $comment_id = $(this).parents('.comment').data('cid');
            $('.alert .text').text($comment_text);
            $('input[name="parent_id"]').val($comment_id);
            $('.alert').show();
        });

        //обработчик закрытия alert
        $(document).on('click', '.alert .close', function(e){
            $('input[name="parent_id"]').val(0);
            $('.alert').hide();
        });
    }
});
