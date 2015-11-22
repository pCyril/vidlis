var loadingMore = false;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height() && $('body').find('.loadMoreContent').length != 0 && !loadingMore && !$('.loadMoreContent').hasClass('noMore')) {
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
                $moreBlocks.each(function() {
                    var artisteUrl = $(this).data('url');
                    $(this).on('click', function() {
                        $.ajax({
                            type: 'GET',
                            url: artisteUrl,
                            cache: false,
                            dataType: 'html',
                            beforeSend: function () {
                                $('.modalHTMLArtistContent.modal .modal-content').html('');
                                $('.overlay').show();
                            },
                            success: function (data) {
                                height = $(window).height();
                                height = height * 0.94;
                                $('.modalHTMLArtistContent.modal .modal-content').css('height', height + 'px');
                                $('.modalHTMLArtistContent.modal').show();
                                $('.modalHTMLArtistContent.modal .modal-content').html(data);
                                bindArtist($('.modalHTMLArtistContent.modal .modal-content'));
                            },
                            error: function () {
                                $(".modalHTML.modal .modal-content").html('Oh Mince ! Une erreur c\'est produite');
                            }
                        });
                        return false;
                    });
                });
                loadingMore = false;
                if (data.html == '') {
                    $('.loadMoreContent').addClass('noMore').html('No more ...');
                } else {
                    $('.loadMoreContent').data('offset', data.offset);
                    $('.loadMoreContent').hide();
                }
            }
        });
    }
});
