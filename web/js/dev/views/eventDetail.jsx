class EventDetail extends React.Component {
    componentDidMount() {
        var $this = $( ReactDOM.findDOMNode( this ) );
        $( 'html, body' ).animate( {
            scrollTop: $this.offset().top
        }, 2000 );
    }

    onClick() {
        ReactDOM.unmountComponentAtNode( $( '#floorMap' )[0] );
        $( '#floorMap' ).html( '' );
        ReactDOM.render(
            <FloorMap calendar={this.props.calendar} />,
            $( '#floorMap' )[0]
        );
    }

    render() {
        var endDate = ( new Date( this.props.calendar.idevent.enddate ) ).toString();
        var hour = this.props.calendar.hour < 10 ? '0' + this.props.calendar.hour : this.props.calendar.hour;
        var startDate = this.props.calendar.year + '-' + this.props.calendar.monthoftheyear + '-' + this.props.calendar.dayofthemonth + 'T' + hour + ':00:00+0000';
        startDate = ( new Date( startDate ) ).toString();
        return (
            <div>
                <div className="page-header">
                    <h1>Event Details</h1>
                </div>
                <div className="info">
                    <div className="row">
                        <div className="col-md-6">
                            <h4>
                                {this.props.calendar.idevent.name} &nbsp;
                                    <small className="text-muted subLine">NAME</small>
                            </h4>
                        </div>
                        <div className="col-md-6">
                            <h4>
                                {this.props.calendar.idfloormap.idlocation.name} &nbsp;
                                    <small className="text-muted subLine">LOCATION</small>
                            </h4>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <h4>
                                {startDate} &nbsp;
                                    <small className="text-muted subLine">START DATE AND TIME</small>
                            </h4>
                        </div>
                        <div className="col-md-6">
                            <h4>
                                {this.props.calendar.idfloormap.idlocation.country} / {this.props.calendar.idfloormap.idlocation.state} / {this.props.calendar.idfloormap.idlocation.city} &nbsp;
                                    <small className="text-muted subLine">PLACE</small>
                            </h4>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <h4>
                                {endDate} &nbsp;
                                    <small className="text-muted subLine">END DATE AND TIME</small>
                            </h4>
                        </div>
                        <div className="col-md-6">
                            <h4>
                                {this.props.calendar.idfloormap.idlocation.address} {this.props.calendar.idfloormap.idlocation.zipcode} &nbsp;
                                    <small className="text-muted subLine">ADDRESS</small>
                            </h4>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="center marginTop">
                        <button type="button" id="bookYourPlace" className="btn btn-success" onClick={this.onClick.bind( this )}>Book your place</button>
                    </div>
                </div>
            </div>
        );
    }
}