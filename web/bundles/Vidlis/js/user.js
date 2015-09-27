var User = function(name) {
    this.id;
    this.videoId;
    this.group = false;
    this.status;
    this.playlist = [];
    this.volume = 100;
    this.currentPlayedIndex = -1;
    this.name = name || '';
};

User.prototype.changeVolume = function(volume) {
    this.volume = volume;
};

User.prototype.changeVideoId = function(id) {
    this.videoId = id;
};

User.prototype.changeStatus = function(status) {
    this.status = status;
};

User.prototype.changeName = function(name) {
    this.name = name;
};
