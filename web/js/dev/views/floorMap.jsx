class FloorMap extends React.Component {
    componentDidMount() {
        var $this = $( ReactDOM.findDOMNode( this ) );
        $( 'html, body' ).animate( {
            scrollTop: $this.offset().top
        }, 2000 );

        this.scale = 30;
        $( '#myCanvas' ).css( {
            width: this.props.calendar.idfloormap.width * this.scale,
            height: this.props.calendar.idfloormap.height * this.scale
        });

        GlobalApiInterface.get( 'getStands', { id: this.props.calendar.idfloormap.id }).then( function() {
            var response = GlobalApiInterface.getResponse();
            if ( !response.warning ) {
                for ( var index in response.results.Stands ) {
                    var stand = response.results.Stands[index];
                    var api = new ApiInterface();
                    api.setToken( GlobalApiInterface.getToken() );
                    api.get( 'getStandDetail', { id: stand.id, idCalendar: +this.props.calendar.id }).then( function( stand, r ) {
                        this.createStandElement( stand, this.scale );
                        if ( r.results.Bookedslot == 'available' ) {
                            this.setFreeStand( stand );
                        } else {
                            this.setCompanyStand( stand, r );
                        }
                    }.bind( this ), stand );
                }
            }
        }.bind( this ) );
    }

    createStandElement( stand, scale ) {
        return $( '<div/>', {
            id: stand.id,
            title: stand.name
        }).css( {
            left: stand.posx * scale,
            top: stand.posy * scale,
            width: stand.width * scale,
            height: stand.height * scale,
        }).addClass( 'stand' ).appendTo( '#myCanvas' );
    }

    setFreeStand( stand ) {
        $( '<div/>' ).addClass( 'price' ).html( '$ ' + stand.priceslot ).appendTo( '#' + stand.id );
        $( '<h5/>' ).addClass( 'center marginTop' ).html( 'AVAILABLE' ).appendTo( '#' + stand.id );
        $( '<div/>' ).addClass( 'center' ).html( stand.width + ' x ' + stand.height + ' mts' ).appendTo( '#' + stand.id );
        $( '#' + stand.id ).addClass( 'free' );
        this.addFreeStandClick( stand, this.props.calendar );
    }

    setCompanyStand( stand, r ) {
        var company = r.results.Contacts[0] ? r.results.Contacts[0].idcompany : r.results.Documents[0].idcompany;
        this.addCompanyLogo( stand, company );
        $( '<h3/>' ).addClass( 'center marginTop' ).html( company.name ).appendTo( '#' + stand.id );
        $( '<div/>' ).addClass( 'center' ).html( stand.width + ' x ' + stand.height + ' mts' ).appendTo( '#' + stand.id );
        this.addCompanyStandClick( stand, r, company );
    }

    addCompanyLogo( stand, company ) {
        $( '<img/>', {
            'src': 'img/logos/thumbs_' + company.logopath,
            'alt': company.name
        }).addClass( 'noBorder' ).appendTo( $( '<div/>' ).addClass( 'price' ).appendTo( '#' + stand.id ) );
    }

    addFreeStandClick( stand, calendar ) {
        $( '#' + stand.id ).bind( 'click', function() {
            ReactDOM.unmountComponentAtNode( $( '#companyRegister' )[0] );
            $( '#companyRegister' ).html( '' );
            ReactDOM.render(
                <CompanyRegister stand={stand} calendar={this.props.calendar} />,
                $( '#companyRegister' )[0]
            );
        }.bind( this ) );
    }

    addCompanyStandClick( stand, r, company ) {
        $( '#' + stand.id ).bind( 'click', function() {
            var contacts = this.getContacts( r );
            var documents = this.getDocuments( r, company );
            $( '<div/>' ).html( contacts.html() + documents.html() ).dialog( {
                modal: true,
                title: company.name,
                width: 600,
                open: function( event, ui ) {
                    $( '.ui-dialog-titlebar-close' ).addClass( 'close' ).html( 'x' );
                },
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }.bind( this ) );
    }

    getContacts( r ) {
        var contacts = $( '<div/>' ).html( '<h4>Contacts:</h4>' );
        for ( var index in r.results.Contacts ) {
            var contact = r.results.Contacts[index];
            $( '<p/>' ).html( '<b>' + contact.title + ':</b>' ).appendTo( contacts );
            $( '<p/>' ).html( contact.firstname + ' ' + contact.lastname + ' (' + contact.type + ': ' + contact.value + ')' ).appendTo( contacts );
        }
        return contacts;
    }

    getDocuments( r, company ) {
        var documents = $( '<div/>' ).html( '<h4>Documents:</h4>' );
        for ( var index in r.results.Documents ) {
            var document = r.results.Documents[index];
            $( '<b>' + document.type + ':&nbsp;</b>' ).appendTo( documents );
            $( '<a/>', {
                href: 'uploads/docs/' + company.hash + '/' + document.filepath,
                download: 'download',
                tabindex: '-1'
            }).html( document.filepath ).appendTo( documents );
            $( '<br/>' ).appendTo( documents );
        }
        return documents;
    }

    render() {
        return (
            <div>
                <div className="page-header">
                    <h1>Floor Map</h1>
                </div>
                <div id="myCanvas" className="floorMap" />
            </div>
        )
    }
}