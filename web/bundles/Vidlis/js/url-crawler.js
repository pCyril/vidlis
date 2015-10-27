var UrlCrawler = function (url, domain, mprogress) {
    this.domain = domain;
    this.first = true;
    this.mprogress = mprogress;
    var self = this;
    $.address.crawlable(1)
        .state(url)
        .change(function (e) {
        $.address.state() + decodeURI(e.path).replace(/\/\//, '/');
        self.load(e.path, self.mprogress);
    });
};

UrlCrawler.prototype.load = function(url, mprogress) {
    mprogress.start();
    var mprogressSelf = mprogress;
    if (this.first) {
        $('body').trigger('pageLoaded');
        mprogressSelf.end(true);
        this.first = false;
        return;
    }
    $.ajax({
        url: this.domain + url,
        type: 'POST',
        dataType: 'json',
        cache: true,
        success: function (data, textStatus, jqXHR) {
            document.title = data.title;
            $('#content').html(data.content);
            mprogressSelf.end(true);
            $('body').trigger('pageLoaded');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showError('Oh Mince ! Une erreur est survenue pendant le chargement de la page :\'(');
            return false;
        }
    });
}
