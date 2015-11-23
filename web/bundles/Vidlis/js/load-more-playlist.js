var loadingMore = false;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height() && $('body').find('.loadMoreContentPlaylist').length != 0 &&  !loadingMore && !$('.loadMoreContentPlaylist').hasClass('noMore')) {
        var url = DOMAIN_NAME + '/load/playlist/' + $('.loadMoreContentPlaylist').data('limit') + '/' + $('.loadMoreContentPlaylist').data('offset');
        $.ajax({
            url: url,
            dataType: 'json',
            beforeSend: function() {
                loadingMore = true;
                $('.loadMoreContentPlaylist').show();
            },
            success: function(data) {
                var $moreBlocks = $(data.html);
                $('#feeds').append($moreBlocks);
                loadingMore = false;
                if ('' == data.html) {
                    $('.loadMoreContentPlaylist').addClass('noMore').html('No more ...');
                } else {
                    $('.loadMoreContentPlaylist').data('offset', data.offset);
                    $('.loadMoreContentPlaylist').hide();
                }
            }
        });
    }
});
