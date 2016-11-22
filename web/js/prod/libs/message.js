'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Message = function () {
    function Message(main, message) {
        _classCallCheck(this, Message);

        this.main = main;
        this.message = message;
    }

    _createClass(Message, [{
        key: 'display',
        value: function display(msgId, msg) {
            msg = msg || '';
            $('#' + this.message).text(msgId + ' ' + msg);
            $('#' + this.main).fadeIn(1000, function () {
                setTimeout(function () {
                    $("#" + this.main).fadeOut(1000);
                }.bind(this), 5000);
            }.bind(this));
        }
    }, {
        key: 'error',
        value: function error(msgId, msg) {
            $('#' + this.main).removeClass();
            $('#' + this.main).addClass('alert alertContainer alert-danger');
            this.display('ERROR: ' + msgId, msg);
        }
    }, {
        key: 'warning',
        value: function warning(msgId, msg) {
            $('#' + this.main).removeClass();
            $('#' + this.main).addClass('alert alertContainer alert-warning');
            this.display('WARNING: ' + msgId, msg);
        }
    }, {
        key: 'info',
        value: function info(msgId, msg) {
            $('#' + this.main).removeClass();
            $('#' + this.main).addClass('alert alertContainer alert-info');
            this.display('INFO: ' + msgId, msg);
        }
    }, {
        key: 'success',
        value: function success(msgId, msg) {
            $('#' + this.main).removeClass();
            $('#' + this.main).addClass('alert alertContainer alert-success');
            this.display('SUCCESS: ' + msgId, msg);
        }
    }]);

    return Message;
}();

Message = new Message('alert', 'alertMessage');