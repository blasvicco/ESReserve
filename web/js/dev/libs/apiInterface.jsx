class ApiInterface {

    constructor() {
        this.url = '/app.php/api/';
        this.response = {};
        this.callback = [];
        this.input = [];
        this.token = null;
    }

    _call( method, action, data, contentType, sync ) {
        $.ajax( {
            async: !sync,
            url: this.url + action + '/',
            type: method,
            headers: this.header,
            processData: ( contentType != 'multipart/form-data' ),
            contentType: ( contentType == 'multipart/form-data' ) ? false : contentType,
            data: data,
            dataType: 'json',
            cache: false,
            success: function( data ) {
                if ( data.error ) {
                    console.log( action + ':', data.error + ':', data.error_description );
                    Message.error( action + ': ' + data.error + ': ', data.error_description );
                    return;
                }
                if ( data.warning ) {
                    console.log( action + ':', data.warning + ':', data.warning_description );
                    Message.warning( data.warning_description );
                }
                if ( data.info ) {
                    console.log( action + ':', data.info + ':', data.info_description );
                    Message.info( data.info_description );
                }
                if ( data.success ) {
                    console.log( action + ':', data.success + ':', data.success_description );
                    Message.success( data.success_description );
                }
                this.setResponse( data );
                if ( this.callback[action] ) {
                    this.callback[action]( this.input[action], data );
                    this.callback[action] = null;
                    this.input[action] = null;
                }
            }.bind( this ),
            error: function( xhr, status, err ) {
                console.log( action + ':', status + ':', err.toString() );
                Message.error( 'AJAX fail', action + ':', status + ':', err.toString() );
            }
        });
    }

    setToken( token ) {
        this.token = token;
        this.header = {
            'Authorization': 'Bearer ' + token
        };
    }

    getToken() {
        return this.token;
    }

    setResponse( response ) {
        this.response = response;
    }

    getResponse() {
        return this.response;
    }

    post( action, data, contentType, sync ) {
        contentType = contentType ? contentType : 'application/x-www-form-urlencoded';
        setTimeout( function() { this._call( 'POST', action, data, contentType, sync ); }.bind( this ), 100 );
        this.action = action;
        return this;
    }

    get( action, data, sync ) {
        setTimeout( function() { this._call( 'GET', action, data, 'application/json', sync ); }.bind( this ), 100 );
        this.action = action;
        return this;
    }

    then( callback, input ) {
        this.callback[this.action] = callback;
        this.input[this.action] = input;
        this.action = null;
    }

}

var GlobalApiInterface = new ApiInterface();