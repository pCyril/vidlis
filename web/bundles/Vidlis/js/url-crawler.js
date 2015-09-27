var UrlCrawler = function (url, domain) {
    this.domain = domain;
    var self = this;
    $.address.crawlable(1).state(url).init(function () {
    }).change(function (e) {
        $.address.state() + decodeURI(e.path).replace(/\/\//, '/');
        self.load(e.path);
    });
};

UrlCrawler.prototype.load = function(url) {
    $('#loading').show();
    $.ajax({
        url: this.domain + url,
        type: 'POST',
        dataType: 'json',
        cache: true,
        success: function (data, textStatus, jqXHR) {
            document.title = data.title;
            $('#content').html(data.content);
            $('#loading').hide();
            $('body').trigger('pageLoaded');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showError('Oh Mince ! Une erreur est survenue pendant le chargement de la page :\'(');
            return false;
        }
    });
}
