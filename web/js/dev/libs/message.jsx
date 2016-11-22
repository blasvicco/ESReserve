class Message {

    constructor( main, message ) {
        this.main = main;
        this.message = message;
    }

    display( msgId, msg ) {
        msg = msg || '';
        $( '#' + this.message ).text( msgId + ' ' + msg );
        $( '#' + this.main ).fadeIn( 1000, function() {
            setTimeout( function() {
                $( "#" + this.main ).fadeOut( 1000 );
            }.bind( this ), 5000 );
        }.bind( this ) );
    }

    error( msgId, msg ) {
        $( '#' + this.main ).removeClass();
        $( '#' + this.main ).addClass( 'alert alertContainer alert-danger' );
        this.display( 'ERROR: ' + msgId, msg );
    }

    warning( msgId, msg ) {
        $( '#' + this.main ).removeClass();
        $( '#' + this.main ).addClass( 'alert alertContainer alert-warning' );
        this.display( 'WARNING: ' + msgId, msg );
    }

    info( msgId, msg ) {
        $( '#' + this.main ).removeClass();
        $( '#' + this.main ).addClass( 'alert alertContainer alert-info' );
        this.display( 'INFO: ' + msgId, msg );
    }

    success( msgId, msg ) {
        $( '#' + this.main ).removeClass();
        $( '#' + this.main ).addClass( 'alert alertContainer alert-success' );
        this.display( 'SUCCESS: ' + msgId, msg );
    }
}

Message = new Message( 'alert', 'alertMessage' );