'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var MainApp = function (_React$Component) {
    _inherits(MainApp, _React$Component);

    function MainApp(props) {
        _classCallCheck(this, MainApp);

        var _this = _possibleConstructorReturn(this, (MainApp.__proto__ || Object.getPrototypeOf(MainApp)).call(this, props));

        _this.state = { auth: _this.props.initialToken };

        _this.state = { auth: props.initialAuth };
        return _this;
    }

    _createClass(MainApp, [{
        key: '_loadMarkers',
        value: function _loadMarkers() {
            var response = GlobalApiInterface.getResponse();
            for (var index in response.results) {
                GlobalGoogleMap.addMarker(response.results[index]);
            }
        }
    }, {
        key: '_loadMap',
        value: function _loadMap(data) {
            GlobalApiInterface.setToken(data.access_token);
            GlobalApiInterface.get('hello').then(function (data) {
                this.setState({ auth: data });
                GlobalGoogleMap.init(function () {
                    GlobalApiInterface.get('loadEvents', GlobalGoogleMap.getCenterAndRadius()).then(function () {
                        this._loadMarkers();
                    }.bind(this));
                }.bind(this));
            }.bind(this), data);
        }
    }, {
        key: 'onClick',
        value: function onClick() {
            $.ajax({
                url: '/app.php/getToken/',
                type: 'POST',
                data: { 'username': $('#inputUsername').val(), 'password': $('#inputPassword').val() },
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.error) {
                        console.log('getToken:', data.error + ':', data.error_description);
                        Message.error('getToken: ' + data.error + ': ', data.error_description);
                        return;
                    } else {
                        this._loadMap(data);
                    }
                }.bind(this),
                error: function (xhr, status, err) {
                    console.log('getToken:', status + ':', err.toString());
                    Message.error('getToken: ' + status + ': ', err.toString());
                }.bind(this)
            });
        }
    }, {
        key: 'render',
        value: function render() {
            if (this.state.auth.access_token) {
                return React.createElement(
                    'div',
                    null,
                    React.createElement(Greeting, { username: GlobalApiInterface.getResponse().username })
                );
            } else {
                return React.createElement(
                    'form',
                    { className: 'form-signin' },
                    React.createElement(LoginFormFields, null),
                    React.createElement(
                        'button',
                        { className: 'btn btn-lg btn-primary btn-block', type: 'button', onClick: this.onClick.bind(this) },
                        'Sign in'
                    )
                );
            }
        }
    }]);

    return MainApp;
}(React.Component);

MainApp.propTypes = { initialAuth: React.PropTypes.any };
MainApp.defaultProps = { initialAuth: {} };


ReactDOM.render(React.createElement(MainApp, null), document.getElementById('login'));