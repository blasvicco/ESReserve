'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var FloorMap = function (_React$Component) {
    _inherits(FloorMap, _React$Component);

    function FloorMap() {
        _classCallCheck(this, FloorMap);

        return _possibleConstructorReturn(this, (FloorMap.__proto__ || Object.getPrototypeOf(FloorMap)).apply(this, arguments));
    }

    _createClass(FloorMap, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            var $this = $(ReactDOM.findDOMNode(this));
            $('html, body').animate({
                scrollTop: $this.offset().top
            }, 2000);

            this.scale = 30;
            $('#myCanvas').css({
                width: this.props.calendar.idfloormap.width * this.scale,
                height: this.props.calendar.idfloormap.height * this.scale
            });

            GlobalApiInterface.get('getStands', { id: this.props.calendar.idfloormap.id }).then(function () {
                var response = GlobalApiInterface.getResponse();
                if (!response.warning) {
                    for (var index in response.results.Stands) {
                        var stand = response.results.Stands[index];
                        var api = new ApiInterface();
                        api.setToken(GlobalApiInterface.getToken());
                        api.get('getStandDetail', { id: stand.id, idCalendar: +this.props.calendar.id }).then(function (stand, r) {
                            this.createStandElement(stand, this.scale);
                            if (r.results.Bookedslot == 'available') {
                                this.setFreeStand(stand);
                            } else {
                                this.setCompanyStand(stand, r);
                            }
                        }.bind(this), stand);
                    }
                }
            }.bind(this));
        }
    }, {
        key: 'createStandElement',
        value: function createStandElement(stand, scale) {
            return $('<div/>', {
                id: stand.id,
                title: stand.name
            }).css({
                left: stand.posx * scale,
                top: stand.posy * scale,
                width: stand.width * scale,
                height: stand.height * scale
            }).addClass('stand').appendTo('#myCanvas');
        }
    }, {
        key: 'setFreeStand',
        value: function setFreeStand(stand) {
            $('<div/>').addClass('price').html('$ ' + stand.priceslot).appendTo('#' + stand.id);
            $('<h5/>').addClass('center marginTop').html('AVAILABLE').appendTo('#' + stand.id);
            $('<div/>').addClass('center').html(stand.width + ' x ' + stand.height + ' mts').appendTo('#' + stand.id);
            $('#' + stand.id).addClass('free');
            this.addFreeStandClick(stand, this.props.calendar);
        }
    }, {
        key: 'setCompanyStand',
        value: function setCompanyStand(stand, r) {
            var company = r.results.Contacts[0] ? r.results.Contacts[0].idcompany : r.results.Documents[0].idcompany;
            this.addCompanyLogo(stand, company);
            $('<h3/>').addClass('center marginTop').html(company.name).appendTo('#' + stand.id);
            $('<div/>').addClass('center').html(stand.width + ' x ' + stand.height + ' mts').appendTo('#' + stand.id);
            this.addCompanyStandClick(stand, r, company);
        }
    }, {
        key: 'addCompanyLogo',
        value: function addCompanyLogo(stand, company) {
            $('<img/>', {
                'src': 'img/logos/thumbs_' + company.logopath,
                'alt': company.name
            }).addClass('noBorder').appendTo($('<div/>').addClass('price').appendTo('#' + stand.id));
        }
    }, {
        key: 'addFreeStandClick',
        value: function addFreeStandClick(stand, calendar) {
            $('#' + stand.id).bind('click', function () {
                ReactDOM.unmountComponentAtNode($('#companyRegister')[0]);
                $('#companyRegister').html('');
                ReactDOM.render(React.createElement(CompanyRegister, { stand: stand, calendar: this.props.calendar }), $('#companyRegister')[0]);
            }.bind(this));
        }
    }, {
        key: 'addCompanyStandClick',
        value: function addCompanyStandClick(stand, r, company) {
            $('#' + stand.id).bind('click', function () {
                var contacts = this.getContacts(r);
                var documents = this.getDocuments(r, company);
                $('<div/>').html(contacts.html() + documents.html()).dialog({
                    modal: true,
                    title: company.name,
                    width: 600,
                    open: function open(event, ui) {
                        $('.ui-dialog-titlebar-close').addClass('close').html('x');
                    },
                    buttons: {
                        Ok: function Ok() {
                            $(this).dialog("close");
                        }
                    }
                });
            }.bind(this));
        }
    }, {
        key: 'getContacts',
        value: function getContacts(r) {
            var contacts = $('<div/>').html('<h4>Contacts:</h4>');
            for (var index in r.results.Contacts) {
                var contact = r.results.Contacts[index];
                $('<p/>').html('<b>' + contact.title + ':</b>').appendTo(contacts);
                $('<p/>').html(contact.firstname + ' ' + contact.lastname + ' (' + contact.type + ': ' + contact.value + ')').appendTo(contacts);
            }
            return contacts;
        }
    }, {
        key: 'getDocuments',
        value: function getDocuments(r, company) {
            var documents = $('<div/>').html('<h4>Documents:</h4>');
            for (var index in r.results.Documents) {
                var document = r.results.Documents[index];
                $('<b>' + document.type + ':&nbsp;</b>').appendTo(documents);
                $('<a/>', {
                    href: 'uploads/docs/' + company.hash + '/' + document.filepath,
                    download: 'download',
                    tabindex: '-1'
                }).html(document.filepath).appendTo(documents);
                $('<br/>').appendTo(documents);
            }
            return documents;
        }
    }, {
        key: 'render',
        value: function render() {
            return React.createElement(
                'div',
                null,
                React.createElement(
                    'div',
                    { className: 'page-header' },
                    React.createElement(
                        'h1',
                        null,
                        'Floor Map'
                    )
                ),
                React.createElement('div', { id: 'myCanvas', className: 'floorMap' })
            );
        }
    }]);

    return FloorMap;
}(React.Component);