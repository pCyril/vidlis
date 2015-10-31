var loadingMore = false;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height() && !loadingMore && !$('.loadMoreContent').hasClass('noMore')) {
        var url = DOMAIN_NAME + '/load/artists/' + $('.loadMoreContent').data('limit') + '/' + $('.loadMoreContent').data('offset') + '/' + $('.loadMoreContent').data('tag');
        $.ajax({
            url: url,
            dataType: 'json',
            beforeSend: function() {
                loadingMore = true;
                $('.loadMoreContent').show();
            },
            success: function(data) {
                var $moreBlocks = $(data.html);
                $('#feeds_content').append($moreBlocks);
                bindArtist($moreBlocks);
                loadingMore = false;
                if (data.html == '') {
                    $('.loadMoreContent').addClass('noMore').html('A fini ...');
                } else {
                    $('.loadMoreContent').data('offset', data.offset);
                    $('.loadMoreContent').hide();
                }
            }
        });
    }
});
