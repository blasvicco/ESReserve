'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var CompanyRegister = function (_React$Component) {
    _inherits(CompanyRegister, _React$Component);

    function CompanyRegister() {
        _classCallCheck(this, CompanyRegister);

        return _possibleConstructorReturn(this, (CompanyRegister.__proto__ || Object.getPrototypeOf(CompanyRegister)).apply(this, arguments));
    }

    _createClass(CompanyRegister, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            var $this = $(ReactDOM.findDOMNode(this));
            $('html, body').animate({
                scrollTop: $this.offset().top
            }, 2000);

            $.validate({
                form: '#registration',
                modules: 'file'
            });

            $('#registration').bind('submit', function (e) {
                e.preventDefault();
                this.bookTheStand();
            }.bind(this));

            this.bindContactInputChange();
            this.bindDocumentInputChange();
        }
    }, {
        key: 'bindContactInputChange',
        value: function bindContactInputChange() {
            $('.addNewContact').unbind('click');
            $('.addNewContact').bind('click', function () {
                var currentRow = $('.addNewContact').parent().parent().parent();
                var newRow = $(currentRow).clone();
                $(newRow).find('.contactsTitle').val('Admin');
                $(newRow).find('.contactsType').val($(currentRow).find('.contactsType').val());
                $(newRow).find('.contactsFirstName').val('');
                $(newRow).find('.contactsLastName').val('');
                $(newRow).find('.contactsValue').val('');
                var preButton = $(currentRow).find('.addNewContact');
                $(preButton).removeClass('btn-primary addNewContact').addClass('btn-danger removeContact').text('Remove contact');
                $(preButton).unbind('click');
                $(preButton).bind('click', function () {
                    $(preButton).parent().parent().parent().remove();
                }.bind(preButton));
                $(newRow).appendTo($(currentRow).parent());
                this.bindContactInputChange();
            }.bind(this));

            $('.contactsType').unbind('change');
            $('.contactsType').bind('change', function () {
                var validationType = 'alphanumeric';
                var val = $(this).find('option:selected').val();
                var contactsValue = $(this).parent().parent().parent().next().find('.contactsValue');
                contactsValue.attr('placeholder', 'Enter ' + val);
                if (val == 'Email') {
                    validationType = 'email';
                    contactsValue.attr('data-validation-length', '');
                    contactsValue.attr('data-validation-allowing', '');
                } else {
                    validationType = 'length';
                    contactsValue.attr('data-validation-length', 'min5');
                    contactsValue.attr('data-validation-allowing', 'range[1;99999999999999999999]');
                }
                contactsValue.attr('data-validation', 'required ' + validationType);
                contactsValue.prev().text(val);
                $.validate();
            });
        }
    }, {
        key: 'bindDocumentInputChange',
        value: function bindDocumentInputChange() {
            $('.documentFile').last().bind('change', function () {
                var el = $('.documentFile').last();
                if ($(el).val() != '') {
                    $(el).unbind('change');
                    var currentRow = $(el).parent().parent().parent().parent();
                    $(currentRow).clone().appendTo($(currentRow).parent());
                    this.bindDocumentInputChange();
                }
            }.bind(this));

            $('.documentFileClean').unbind('click');
            $('.documentFileClean').bind('click', function () {
                $(this).parent().parent().parent().remove();
            });
            $('.documentFileClean').last().unbind('click');
        }
    }, {
        key: 'bookTheStand',
        value: function bookTheStand() {
            if ($('#registration').isValid()) {
                var data = new FormData();
                var company = {
                    name: document.getElementById('company.name').value
                };
                var contacts = [];
                var contactRows = $('.contactRows').each(function (i, e) {
                    contacts.push({
                        title: $(e).find('.contactsTitle').val(),
                        type: $(e).find('.contactsType').val(),
                        firstName: $(e).find('.contactsFirstName').val(),
                        lastName: $(e).find('.contactsLastName').val(),
                        value: $(e).find('.contactsValue').val()
                    });
                }.bind(contacts));
                data.append('company', JSON.stringify(company));
                data.append('contacts', JSON.stringify(contacts));
                data.append('logo', document.getElementById('company.logo').files[0], document.getElementById('company.logo').files[0]['name']);
                var index = 0;
                var documentRows = $('.documentRows').each(function (i, e) {
                    var fileInput = document.getElementsByName('documents[]')[index].files[0];
                    if (fileInput && fileInput['name']) {
                        data.append('documents[]', fileInput, fileInput['name']);
                    }
                    index++;
                }.bind(data));
                GlobalApiInterface.post('registerCompany', data, 'multipart/form-data').then(function (input, r) {
                    Message.success('Company registered');
                    var data = {
                        idStand: this.props.stand.id,
                        idCalendar: this.props.calendar.id,
                        idCompany: r.results.Company.id
                    };
                    var api = new ApiInterface();
                    api.setToken(GlobalApiInterface.getToken());
                    api.post('bookStand', data).then(function (input, r) {
                        Message.success('Stand booked');
                        $('#companyRegister').html('');
                        $('#bookYourPlace').trigger('click');
                    }.bind(this));
                }.bind(this));
            }
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
                        'Company Registration'
                    )
                ),
                React.createElement(
                    'form',
                    { enctype: 'multipart/form-data', id: 'registration' },
                    React.createElement(
                        'h4',
                        null,
                        'Company'
                    ),
                    React.createElement(
                        'div',
                        null,
                        React.createElement(
                            'div',
                            { className: 'form-group' },
                            React.createElement(
                                'label',
                                { 'for': 'company.name' },
                                'Name'
                            ),
                            React.createElement('input', { className: 'form-control', id: 'company.name', placeholder: 'Enter name',
                                'data-validation': 'required alphanumeric' })
                        )
                    ),
                    React.createElement(
                        'div',
                        { className: 'form-group' },
                        React.createElement(
                            'label',
                            { 'for': 'company.logo' },
                            'Logo'
                        ),
                        React.createElement('input', { type: 'file', className: 'form-control-file', id: 'company.logo', 'aria-describedby': 'logoHelp',
                            'data-validation': 'required mime size',
                            'data-validation-allowing': 'jpg',
                            'data-validation-max-size': '1M' }),
                        React.createElement(
                            'small',
                            { id: 'logoHelp', className: 'form-text text-muted' },
                            'The company logo must be a JPG file and less than 1Mb.'
                        )
                    ),
                    React.createElement(
                        'h4',
                        null,
                        'Contacts'
                    ),
                    React.createElement(
                        'div',
                        null,
                        React.createElement(
                            'div',
                            { className: 'panel-body contactRows' },
                            React.createElement(
                                'h5',
                                null,
                                'Contact'
                            ),
                            React.createElement(
                                'div',
                                { className: 'row' },
                                React.createElement(
                                    'div',
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'div',
                                        { className: 'form-group' },
                                        React.createElement(
                                            'label',
                                            { 'for': 'contacts[].title' },
                                            'Title'
                                        ),
                                        React.createElement(
                                            'select',
                                            { className: 'form-control contactsTitle', id: 'contacts[].title', defaultValue: 'Admin' },
                                            React.createElement(
                                                'option',
                                                { value: 'Admin' },
                                                'Admin'
                                            ),
                                            React.createElement(
                                                'option',
                                                { value: 'Stand exhibitor' },
                                                'Stand exhibitor'
                                            )
                                        )
                                    )
                                ),
                                React.createElement(
                                    'div',
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'div',
                                        { className: 'form-group' },
                                        React.createElement(
                                            'label',
                                            { 'for': 'contacts[].type' },
                                            'Type'
                                        ),
                                        React.createElement(
                                            'select',
                                            { className: 'form-control contactsType', id: 'contacts[].type', defaultValue: 'phone' },
                                            React.createElement(
                                                'option',
                                                { value: 'Phone' },
                                                'Phone'
                                            ),
                                            React.createElement(
                                                'option',
                                                { value: 'Mobile' },
                                                'Mobile'
                                            ),
                                            React.createElement(
                                                'option',
                                                { value: 'Email' },
                                                'Email'
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
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'div',
                                        { className: 'form-group' },
                                        React.createElement(
                                            'label',
                                            { 'for': 'contacts[].firstName' },
                                            'First name'
                                        ),
                                        React.createElement('input', { className: 'form-control contactsFirstName', id: 'contacts[].firstName', placeholder: 'Enter first name',
                                            'data-validation': 'required alphanumeric' })
                                    )
                                ),
                                React.createElement(
                                    'div',
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'div',
                                        { className: 'form-group' },
                                        React.createElement(
                                            'label',
                                            { 'for': 'contacts[].value' },
                                            'Phone'
                                        ),
                                        React.createElement('input', { className: 'form-control contactsValue', id: 'contacts[].values', placeholder: 'Enter phone',
                                            'data-validation': 'required number length',
                                            'data-validation-length': 'min5',
                                            'data-validation-allowing': 'range[1;99999999999999999999]' })
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
                                        'div',
                                        { className: 'form-group' },
                                        React.createElement(
                                            'label',
                                            { 'for': 'contacts[].lastName' },
                                            'Last name'
                                        ),
                                        React.createElement('input', { className: 'form-control contactsLastName', id: 'contacts[].lastName', placeholder: 'Enter last name',
                                            'data-validation': 'required alphanumeric' })
                                    )
                                ),
                                React.createElement(
                                    'div',
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'button',
                                        { type: 'button', className: 'btn btn-primary addNewContact' },
                                        'Add new contact'
                                    )
                                )
                            )
                        )
                    ),
                    React.createElement(
                        'h4',
                        null,
                        'Documents'
                    ),
                    React.createElement(
                        'div',
                        null,
                        React.createElement(
                            'div',
                            { className: 'documentRows' },
                            React.createElement(
                                'div',
                                { className: 'row' },
                                React.createElement(
                                    'div',
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'div',
                                        { className: 'form-group' },
                                        React.createElement(
                                            'label',
                                            { 'for': 'documents[]' },
                                            'Document'
                                        ),
                                        React.createElement('input', { type: 'file', className: 'form-control-file documentFile', id: 'documents[]', name: 'documents[]', 'aria-describedby': 'documentsHelp',
                                            'data-validation': 'size',
                                            'data-validation-max-size': '1M' }),
                                        React.createElement(
                                            'small',
                                            { id: 'documentsHelp', className: 'form-text text-muted' },
                                            'Any file type less than 1Mb.'
                                        )
                                    )
                                ),
                                React.createElement(
                                    'div',
                                    { className: 'col-md-6' },
                                    React.createElement(
                                        'div',
                                        { className: 'documentFileClean' },
                                        React.createElement('span', { className: 'glyphicon glyphicon-remove red', 'aria-hidden': 'true' })
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
                                { type: 'submit', className: 'btn btn-success' },
                                'Book the stand'
                            )
                        )
                    )
                )
            );
        }
    }]);

    return CompanyRegister;
}(React.Component);