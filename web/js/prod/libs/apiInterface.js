'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ApiInterface = function () {
    function ApiInterface() {
        _classCallCheck(this, ApiInterface);

        this.url = '/app.php/api/';
        this.response = {};
        this.callback = [];
        this.input = [];
        this.token = null;
    }

    _createClass(ApiInterface, [{
        key: '_call',
        value: function _call(method, action, data, contentType, sync) {
            $.ajax({
                async: !sync,
                url: this.url + action + '/',
                type: method,
                headers: this.header,
                processData: contentType != 'multipart/form-data',
                contentType: contentType == 'multipart/form-data' ? false : contentType,
                data: data,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.error) {
                        console.log(action + ':', data.error + ':', data.error_description);
                        Message.error(action + ': ' + data.error + ': ', data.error_description);
                        return;
                    }
                    if (data.warning) {
                        console.log(action + ':', data.warning + ':', data.warning_description);
                        Message.warning(data.warning_description);
                    }
                    if (data.info) {
                        console.log(action + ':', data.info + ':', data.info_description);
                        Message.info(data.info_description);
                    }
                    if (data.success) {
                        console.log(action + ':', data.success + ':', data.success_description);
                        Message.success(data.success_description);
                    }
                    this.setResponse(data);
                    if (this.callback[action]) {
                        this.callback[action](this.input[action], data);
                        this.callback[action] = null;
                        this.input[action] = null;
                    }
                }.bind(this),
                error: function error(xhr, status, err) {
                    console.log(action + ':', status + ':', err.toString());
                    Message.error('AJAX fail', action + ':', status + ':', err.toString());
                }
            });
        }
    }, {
        key: 'setToken',
        value: function setToken(token) {
            this.token = token;
            this.header = {
                'Authorization': 'Bearer ' + token
            };
        }
    }, {
        key: 'getToken',
        value: function getToken() {
            return this.token;
        }
    }, {
        key: 'setResponse',
        value: function setResponse(response) {
            this.response = response;
        }
    }, {
        key: 'getResponse',
        value: function getResponse() {
            return this.response;
        }
    }, {
        key: 'post',
        value: function post(action, data, contentType, sync) {
            contentType = contentType ? contentType : 'application/x-www-form-urlencoded';
            setTimeout(function () {
                this._call('POST', action, data, contentType, sync);
            }.bind(this), 100);
            this.action = action;
            return this;
        }
    }, {
        key: 'get',
        value: function get(action, data, sync) {
            setTimeout(function () {
                this._call('GET', action, data, 'application/json', sync);
            }.bind(this), 100);
            this.action = action;
            return this;
        }
    }, {
        key: 'then',
        value: function then(callback, input) {
            this.callback[this.action] = callback;
            this.input[this.action] = input;
            this.action = null;
        }
    }]);

    return ApiInterface;
}();

var GlobalApiInterface = new ApiInterface();