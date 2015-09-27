$('#share a').on('click', function() {
    if (curentVideoId != '') {
        $.ajax({
            type: 'GET',
            url: this + '/' + curentVideoId,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $(".modalWithHeader .modal-header h4").html('Chargement en cours');
                $(".modalWithHeader .modal-body").html('');
                $('.modal.modalWithHeader, .overlay').show();
            },
            success: function (data) {
                $('.modal.modalWithHeader').show();
                $(".modalWithHeader .modal-header h4").html(data.title);
                $(".modalWithHeader .modal-body").html(data.content);
            },
            error: function () {
                $(".modalWithHeader .modal-header h4").html('Oups :\'(');
                $(".modalWithHeader .modal-body").html('Oh Mince ! Une erreur c\'est produite');
            }
        }).done(function () {
            sendFormToAjax();
        });
        return false;
    }
});
