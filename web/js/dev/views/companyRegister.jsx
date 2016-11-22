class CompanyRegister extends React.Component {
    componentDidMount() {
        var $this = $( ReactDOM.findDOMNode( this ) );
        $( 'html, body' ).animate( {
            scrollTop: $this.offset().top
        }, 2000 );

        $.validate( {
            form: '#registration',
            modules: 'file'
        });

        $( '#registration' ).bind( 'submit', function( e ) {
            e.preventDefault();
            this.bookTheStand();
        }.bind( this ) );

        this.bindContactInputChange();
        this.bindDocumentInputChange();
    }

    bindContactInputChange() {
        $( '.addNewContact' ).unbind( 'click' );
        $( '.addNewContact' ).bind( 'click', function() {
            var currentRow = $( '.addNewContact' ).parent().parent().parent();
            var newRow = $( currentRow ).clone();
            $( newRow ).find( '.contactsTitle' ).val( 'Admin' );
            $( newRow ).find( '.contactsType' ).val( $( currentRow ).find( '.contactsType' ).val() );
            $( newRow ).find( '.contactsFirstName' ).val( '' );
            $( newRow ).find( '.contactsLastName' ).val( '' );
            $( newRow ).find( '.contactsValue' ).val( '' );
            var preButton = $( currentRow ).find( '.addNewContact' );
            $( preButton ).removeClass( 'btn-primary addNewContact' ).addClass( 'btn-danger removeContact' ).text( 'Remove contact' );
            $( preButton ).unbind( 'click' );
            $( preButton ).bind( 'click', function() {
                $( preButton ).parent().parent().parent().remove();
            }.bind( preButton ) );
            $( newRow ).appendTo( $( currentRow ).parent() );
            this.bindContactInputChange();
        }.bind( this ) );

        $( '.contactsType' ).unbind( 'change' );
        $( '.contactsType' ).bind( 'change', function() {
            var validationType = 'alphanumeric';
            var val = $( this ).find( 'option:selected' ).val();
            var contactsValue = $( this ).parent().parent().parent().next().find( '.contactsValue' );
            contactsValue.attr( 'placeholder', 'Enter ' + val );
            if ( val == 'Email' ) {
                validationType = 'email';
                contactsValue.attr( 'data-validation-length', '');
                contactsValue.attr( 'data-validation-allowing', '');
            } else {
                validationType = 'length';
                contactsValue.attr( 'data-validation-length', 'min5');
                contactsValue.attr( 'data-validation-allowing', 'range[1;99999999999999999999]');
            }
            contactsValue.attr( 'data-validation', 'required ' + validationType );
            contactsValue.prev().text( val );
            $.validate();
        });

    }

    bindDocumentInputChange() {
        $( '.documentFile' ).last().bind( 'change', function() {
            var el = $( '.documentFile' ).last();
            if ( $( el ).val() != '' ) {
                $( el ).unbind( 'change' );
                var currentRow = $( el ).parent().parent().parent().parent();
                $( currentRow ).clone().appendTo( $( currentRow ).parent() );
                this.bindDocumentInputChange();
            }
        }.bind( this ) );

        $( '.documentFileClean' ).unbind( 'click' );
        $( '.documentFileClean' ).bind( 'click', function() {
            $( this ).parent().parent().parent().remove();
        });
        $( '.documentFileClean' ).last().unbind( 'click' );
    }

    bookTheStand() {
        if ( $( '#registration' ).isValid() ) {
            var data = new FormData();
            var company = {
                name: document.getElementById( 'company.name' ).value,
            };
            var contacts = [];
            var contactRows = $( '.contactRows' ).each( function( i, e ) {
                contacts.push( {
                    title: $( e ).find( '.contactsTitle' ).val(),
                    type: $( e ).find( '.contactsType' ).val(),
                    firstName: $( e ).find( '.contactsFirstName' ).val(),
                    lastName: $( e ).find( '.contactsLastName' ).val(),
                    value: $( e ).find( '.contactsValue' ).val()
                });
            }.bind( contacts ) );
            data.append( 'company', JSON.stringify( company ) );
            data.append( 'contacts', JSON.stringify( contacts ) );
            data.append( 'logo', document.getElementById( 'company.logo' ).files[0], document.getElementById( 'company.logo' ).files[0]['name'] );
            var index = 0;
            var documentRows = $( '.documentRows' ).each( function( i, e ) {
                var fileInput = document.getElementsByName( 'documents[]' )[index].files[0];
                if ( fileInput && fileInput['name'] ) {
                    data.append( 'documents[]', fileInput, fileInput['name'] );
                }
                index++;
            }.bind( data ) );
            GlobalApiInterface.post( 'registerCompany', data, 'multipart/form-data' ).then( function( input, r ) {
                Message.success('Company registered');
                var data = {
                    idStand: this.props.stand.id,
                    idCalendar: this.props.calendar.id,
                    idCompany: r.results.Company.id
                };
                var api = new ApiInterface();
                api.setToken( GlobalApiInterface.getToken() );
                api.post( 'bookStand', data ).then( function( input, r ) {
                    Message.success('Stand booked');
                    $('#companyRegister').html('');
                    $('#bookYourPlace').trigger('click');
                }.bind( this ) );
            }.bind( this ) );
        }
    }

    render() {
        return (
            <div>
                <div className="page-header">
                    <h1>Company Registration</h1>
                </div>
                <form enctype="multipart/form-data" id="registration">
                    <h4>Company</h4>
                    <div>
                        <div className="form-group">
                            <label for="company.name">Name</label>
                            <input className="form-control" id="company.name" placeholder="Enter name"
                                data-validation="required alphanumeric" />
                        </div>
                    </div>
                    <div className="form-group">
                        <label for="company.logo">Logo</label>
                        <input type="file" className="form-control-file" id="company.logo" aria-describedby="logoHelp"
                            data-validation="required mime size"
                            data-validation-allowing="jpg"
                            data-validation-max-size="1M" />
                        <small id="logoHelp" className="form-text text-muted">The company logo must be a JPG file and less than 1Mb.</small>
                    </div>
                    <h4>Contacts</h4>
                    <div>
                        <div className="panel-body contactRows">
                            <h5>Contact</h5>
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label for="contacts[].title">Title</label>
                                        <select className="form-control contactsTitle" id="contacts[].title" defaultValue="Admin">
                                            <option value="Admin">Admin</option>
                                            <option value="Stand exhibitor">Stand exhibitor</option>
                                        </select>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label for="contacts[].type">Type</label>
                                        <select className="form-control contactsType" id="contacts[].type" defaultValue="phone">
                                            <option value="Phone">Phone</option>
                                            <option value="Mobile">Mobile</option>
                                            <option value="Email">Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label for="contacts[].firstName">First name</label>
                                        <input className="form-control contactsFirstName" id="contacts[].firstName" placeholder="Enter first name"
                                            data-validation="required alphanumeric" />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label for="contacts[].value">Phone</label>
                                        <input className="form-control contactsValue" id="contacts[].values" placeholder="Enter phone"
                                            data-validation="required number length"
                                            data-validation-length="min5"
                                            data-validation-allowing="range[1;99999999999999999999]" />
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label for="contacts[].lastName">Last name</label>
                                        <input className="form-control contactsLastName" id="contacts[].lastName" placeholder="Enter last name"
                                            data-validation="required alphanumeric" />
                                    </div>
                                </div>
                                <div className="col-md-6"><button type="button" className="btn btn-primary addNewContact">Add new contact</button></div>
                            </div>
                        </div>
                    </div>
                    <h4>Documents</h4>
                    <div>
                        <div className="documentRows">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label for="documents[]">Document</label>
                                        <input type="file" className="form-control-file documentFile" id="documents[]" name="documents[]" aria-describedby="documentsHelp"
                                            data-validation="size"
                                            data-validation-max-size="1M" />
                                        <small id="documentsHelp" className="form-text text-muted">Any file type less than 1Mb.</small>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="documentFileClean"><span className="glyphicon glyphicon-remove red" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="center marginTop">
                            <button type="submit" className="btn btn-success" >Book the stand</button>
                        </div>
                    </div>
                </form>
            </div>
        )
    }
}