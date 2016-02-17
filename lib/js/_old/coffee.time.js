/*
class Dashing.Clock extends Dashing.Widget

  ready: ->
    setInterval(@startTime, 500)

  startTime: =>
    today = new Date()

    h = today.getHours()
    m = today.getMinutes()
    s = today.getSeconds()
    m = @formatTime(m)
    s = @formatTime(s)
    @set('time', h + ":" + m + ":" + s)
    @set('date', today.toDateString())

  formatTime: (i) ->
    if i < 10 then "0" + i else i

*/
var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Dashing.Clock = (function(_super) {
  __extends(Clock, _super);

  function Clock() {
    this.startTime = __bind(this.startTime, this);
    return Clock.__super__.constructor.apply(this, arguments);
  }

  Clock.prototype.ready = function() {
    return setInterval(this.startTime, 500);
  };

  Clock.prototype.startTime = function() {
    var h, m, s, today;
    today = new Date();
    h = today.getHours();
    m = today.getMinutes();
    s = today.getSeconds();
    m = this.formatTime(m);
    s = this.formatTime(s);
    this.set('time', h + ":" + m + ":" + s);
    return this.set('date', today.toDateString());
  };

  Clock.prototype.formatTime = function(i) {
    if (i < 10) {
      return "0" + i;
    } else {
      return i;
    }
  };

  return Clock;

})(Dashing.Widget);