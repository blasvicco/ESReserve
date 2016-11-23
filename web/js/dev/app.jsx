class MainApp extends React.Component {
    static propTypes = { initialAuth: React.PropTypes.any };
    static defaultProps = { initialAuth: {} };
    state = { auth: this.props.initialToken };

    constructor( props ) {
        super( props );
        this.state = { auth: props.initialAuth };
    }

    _loadMarkers() {
        var response = GlobalApiInterface.getResponse();
        for ( var index in response.results ) {
            GlobalGoogleMap.addMarker( response.results[index] );
        }
    }

    _loadMap( data ) {
        GlobalApiInterface.setToken( data.access_token );
        GlobalApiInterface.get( 'hello' ).then( function( data ) {
            this.setState( { auth: data });
            GlobalGoogleMap.init( function() {
                GlobalApiInterface.get(
                    'loadEvents',
                    GlobalGoogleMap.getCenterAndRadius()
                ).then( function() {
                    this._loadMarkers();
                }.bind( this ) );
            }.bind( this ) );
        }.bind( this ), data );
    }

    onClick() {
        $.ajax( {
            url: '/getToken/',
            type: 'POST',
            data: { 'username': $( '#inputUsername' ).val(), 'password': $( '#inputPassword' ).val() },
            dataType: 'json',
            cache: false,
            success: function( data ) {
                if ( data.error ) {
                    console.log( 'getToken:', data.error + ':', data.error_description );
                    Message.error( 'getToken: ' + data.error + ': ', data.error_description );
                    return;
                } else {
                    this._loadMap( data );
                }
            }.bind( this ),
            error: function( xhr, status, err ) {
                console.log( 'getToken:', status + ':', err.toString() );
                Message.error( 'getToken: ' + status + ': ', err.toString() );
            }.bind( this )
        });
    }

    render() {
        if ( this.state.auth.access_token ) {
            return ( <div><Greeting username={GlobalApiInterface.getResponse().username} /></div> );
        } else {
            return (
                <form className="form-signin">
                    <LoginFormFields />
                    <button className="btn btn-lg btn-primary btn-block" type="button" onClick={this.onClick.bind( this )}>Sign in</button>
                </form>
            );
        }
    }
}

ReactDOM.render(
    <MainApp />,
    document.getElementById( 'login' )
);