"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var LoginFormFields = function (_React$Component) {
    _inherits(LoginFormFields, _React$Component);

    function LoginFormFields() {
        _classCallCheck(this, LoginFormFields);

        return _possibleConstructorReturn(this, (LoginFormFields.__proto__ || Object.getPrototypeOf(LoginFormFields)).apply(this, arguments));
    }

    _createClass(LoginFormFields, [{
        key: "render",
        value: function render() {
            return React.createElement(
                "div",
                null,
                React.createElement(
                    "h2",
                    { className: "form-signin-heading" },
                    "Please sign in"
                ),
                React.createElement(
                    "label",
                    { "for": "inputUsername", className: "sr-only" },
                    "Username"
                ),
                React.createElement("input", { type: "username", id: "inputUsername", className: "form-control", placeholder: "Username", required: true, autofocus: true, defaultValue: "test" }),
                React.createElement(
                    "label",
                    { "for": "inputPassword", className: "sr-only" },
                    "Password"
                ),
                React.createElement("input", { type: "password", id: "inputPassword", className: "form-control", placeholder: "Password", required: true, defaultValue: "asd123" })
            );
        }
    }]);

    return LoginFormFields;
}(React.Component);