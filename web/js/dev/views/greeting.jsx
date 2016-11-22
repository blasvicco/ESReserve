class Greeting extends React.Component {
    componentDidMount() {
        var $this = $( '#gmap' );
        $( 'html, body' ).animate( {
            scrollTop: $this.offset().top
        }, 2000 );
    }

    render() {
        Message.success( 'Hello ' + this.props.username + ', these are the upcoming events in Cuenca, Ecuador.' );
        return (
            <div>
                <input id="pac-input" className="controls hide" type="text" placeholder="Search" />
                <div id="gmap"></div>
            </div>
        );
    }
}