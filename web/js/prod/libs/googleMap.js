'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var GoogleMap = function () {
    function GoogleMap() {
        _classCallCheck(this, GoogleMap);

        this.map = null;
        this.searchBox = null;
        this.markers = [];
        this.refreshContent = function () {};
    }

    _createClass(GoogleMap, [{
        key: 'init',
        value: function init(callback) {
            var cuenca = { lat: -2.90055, lng: -79.00453 };
            this.map = new google.maps.Map($('#gmap')[0], {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                zoom: 14,
                zoomControl: true,
                scaleControl: true,
                scrollwheel: false,
                center: cuenca
            });
            if (callback) {
                this.refreshContent = callback;
            }
            var input = $('#pac-input')[0];
            this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            this.searchBox = new google.maps.places.SearchBox(input);
            this.searchBox.addListener('places_changed', function () {
                var places = this.searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                }.bind(bounds));
                this.map.fitBounds(bounds);
            }.bind(this));

            //addRefreshContent
            google.maps.event.addListener(this.map, "bounds_changed", function () {
                $('#pac-input').removeClass('hide');this.mapSettleTime();
            }.bind(this));
        }
    }, {
        key: 'mapSettleTime',
        value: function mapSettleTime() {
            clearTimeout(this.mapUpdater);
            this.mapUpdater = setTimeout(function () {
                this.refreshContent();
            }.bind(this), 2000);
        }
    }, {
        key: 'addMarker',
        value: function addMarker(calendar) {
            if (this.map) {
                var id = calendar.id + '_' + calendar.idevent.id;
                var title = calendar.idevent.name + ' (' + calendar.idfloormap.idlocation.name + ' - ' + calendar.idfloormap.name + ')';
                var pos = { lat: calendar.idfloormap.idlocation.latitude, lng: calendar.idfloormap.idlocation.longitude };
                var marker = new google.maps.Marker({
                    id: id,
                    position: pos,
                    map: this.map,
                    title: title,
                    calendar: calendar
                });
                marker.addListener('click', function () {
                    ReactDOM.unmountComponentAtNode($('#eventDetail')[0]);
                    $('#companyRegister').html('');
                    $('#floorMap').html('');
                    $('#eventDetail').html('');
                    ReactDOM.render(React.createElement(EventDetail, { calendar: marker.calendar }), $('#eventDetail')[0]);
                });
                this.markers[id] = marker;
                var mapLabel = new MapLabel({
                    text: title,
                    position: new google.maps.LatLng(pos.lat, pos.lng),
                    map: this.map,
                    fontSize: 12,
                    fontColor: '#882222',
                    strokeWeight: 2,
                    align: 'center'
                });
            }
        }
    }, {
        key: 'removeMarker',
        value: function removeMarker(id) {
            for (var key in this.markers) {
                if (key == id) {
                    this.markers.splice(key, 1);
                }
            }
        }
    }, {
        key: 'getCurrentRangeRadius',
        value: function getCurrentRangeRadius() {
            var bounds = this.map.getBounds();
            var ne = bounds.getNorthEast(); // LatLng of the north-east corner
            var sw = bounds.getSouthWest(); // LatLng of the south-west corder
            var dx = Math.pow(ne.lat() - sw.lat(), 2);
            var dy = Math.pow(ne.lng() - sw.lng(), 2);
            return Math.pow(dx + dy, 1 / 2) / 2;
        }
    }, {
        key: 'getCenterAndRadius',
        value: function getCenterAndRadius() {
            var mapCenter = this.map.getCenter();
            return { 'latitude': mapCenter.lat(), 'longitude': mapCenter.lng(), 'radius': this.getCurrentRangeRadius() };
        }
    }]);

    return GoogleMap;
}();

var GlobalGoogleMap = new GoogleMap();