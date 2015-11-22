var loadingMore = false;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height() &&$('body').find('.loadMoreContentPlayed').length != 0 &&  !loadingMore && !$('.loadMoreContentPlayed').hasClass('noMore')) {
        var url = DOMAIN_NAME + '/load/played/' + $('.loadMoreContentPlayed').data('limit') + '/' + $('.loadMoreContentPlayed').data('offset');
        $.ajax({
            url: url,
            dataType: 'json',
            beforeSend: function() {
                loadingMore = true;
                $('.loadMoreContentPlayed').show();
            },
            success: function(data) {
                var $moreBlocks = $(data.html);
                $('#feeds').append($moreBlocks);
                loadingMore = false;
                if ('' == data.html) {
                    $('.loadMoreContentPlayed').addClass('noMore').html('No more ...');
                } else {
                    $('.loadMoreContentPlayed').data('offset', data.offset);
                    $('.loadMoreContentPlayed').hide();
                }
            }
        });
    }
});
