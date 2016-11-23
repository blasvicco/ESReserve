'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var EventDetail = function (_React$Component) {
    _inherits(EventDetail, _React$Component);

    function EventDetail() {
        _classCallCheck(this, EventDetail);

        return _possibleConstructorReturn(this, (EventDetail.__proto__ || Object.getPrototypeOf(EventDetail)).apply(this, arguments));
    }

    _createClass(EventDetail, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            var $this = $(ReactDOM.findDOMNode(this));
            $('html, body').animate({
                scrollTop: $this.offset().top
            }, 2000);
        }
    }, {
        key: 'onClick',
        value: function onClick() {
            ReactDOM.unmountComponentAtNode($('#floorMap')[0]);
            $('#floorMap').html('');
            ReactDOM.render(React.createElement(FloorMap, { calendar: this.props.calendar }), $('#floorMap')[0]);
        }
    }, {
        key: 'render',
        value: function render() {
            var endDate = new Date(this.props.calendar.idevent.enddate).toString();
            var hour = this.props.calendar.hour < 10 ? '0' + this.props.calendar.hour : this.props.calendar.hour;
            var startDate = this.props.calendar.year + '-' + this.props.calendar.monthoftheyear + '-' + this.props.calendar.dayofthemonth + 'T' + hour + ':00:00+0000';
            startDate = new Date(startDate).toString();
            return React.createElement(
                'div',
                null,
                React.createElement(
                    'div',
                    { className: 'page-header' },
                    React.createElement(
                        'h1',
                        null,
                        'Event Details'
                    )
                ),
                React.createElement(
                    'div',
                    { className: 'info' },
                    React.createElement(
                        'div',
                        { className: 'row' },
                        React.createElement(
                            'div',
                            { className: 'col-md-6' },
                            React.createElement(
                                'h4',
                                null,
                                this.props.calendar.idevent.name,
                                ' \xA0',
                                React.createElement(
                                    'small',
                                    { className: 'text-muted subLine' },
                                    'NAME'
                                )
                            )
                        ),
                        React.createElement(
                            'div',
                            { className: 'col-md-6' },
                            React.createElement(
                                'h4',
                                null,
                                this.props.calendar.idfloormap.idlocation.name,
                                ' \xA0',
                                React.createElement(
                                    'small',
                                    { className: 'text-muted subLine' },
                                    'LOCATION'
                                )
                            )
                        )
                    ),
                    React.createElement(
                        'div',
                        { className: 'row' },
                        React.createElement(
                            'div',
                            { className: 'col-md-6' },
                            React.createElement(
                                'h4',
                                null,
                                startDate,
                                ' \xA0',
                                React.createElement(
                                    'small',
                                    { className: 'text-muted subLine' },
                                    'START DATE AND TIME'
                                )
                            )
                        ),
                        React.createElement(
                            'div',
                            { className: 'col-md-6' },
                            React.createElement(
                                'h4',
                                null,
                                this.props.calendar.idfloormap.idlocation.country,
                                ' / ',
                                this.props.calendar.idfloormap.idlocation.state,
                                ' / ',
                                this.props.calendar.idfloormap.idlocation.city,
                                ' \xA0',
                                React.createElement(
                                    'small',
                                    { className: 'text-muted subLine' },
                                    'PLACE'
                                )
                            )
                        )
                    ),
                    React.createElement(
                        'div',
                        { className: 'row' },
                        React.createElement(
                            'div',
                            { className: 'col-md-6' },
                            React.createElement(
                                'h4',
                                null,
                                endDate,
                                ' \xA0',
                                React.createElement(
                                    'small',
                                    { className: 'text-muted subLine' },
                                    'END DATE AND TIME'
                                )
                            )
                        ),
                        React.createElement(
                            'div',
                            { className: 'col-md-6' },
                            React.createElement(
                                'h4',
                                null,
                                this.props.calendar.idfloormap.idlocation.address,
                                ' ',
                                this.props.calendar.idfloormap.idlocation.zipcode,
                                ' \xA0',
                                React.createElement(
                                    'small',
                                    { className: 'text-muted subLine' },
                                    'ADDRESS'
                                )
                            )
                        )
                    )
                ),
                React.createElement(
                    'div',
                    { className: 'row' },
                    React.createElement(
                        'div',
                        { className: 'center marginTop' },
                        React.createElement(
                            'button',
                            { type: 'button', id: 'bookYourPlace', className: 'btn btn-success', onClick: this.onClick.bind(this) },
                            'Book your place'
                        )
                    )
                )
            );
        }
    }]);

    return EventDetail;
}(React.Component);