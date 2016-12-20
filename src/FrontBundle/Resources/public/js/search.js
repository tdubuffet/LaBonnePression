var Search = {

    map: null,
    bounds: new google.maps.LatLngBounds(),

    init: function(lat, lnt) {

        var height = $(window).height();
        var width = $('.col-gmaps').width();
        
        $('#gmaps').height(height-55);
        $('#gmaps-container').width(width);

        this.map = new GMaps({
            el: '#gmaps',
            scrollwheel: false,
            zoom: 13,
            styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]
        });



        this.bounds =  new google.maps.LatLngBounds();
    },

    addMarker: function(lat, lng, name, id) {

        this.map.addMarker({
            lat: lat,
            lng: lng,
            title: name,
            icon: path + '/bundles/front/images/location-pin.png',
            click: function(e) {

                //get the top offset of the target anchor
                var target_offset = $("#bar-" + id).offset();
                var target_top = target_offset.top;

                //goto that anchor by setting the body scroll top to anchor top
                $('html, body').animate({scrollTop:target_top}, 1500);
            }
        });
        this.bounds.extend(new google.maps.LatLng(lat, lng));

    },

    setBounds: function() {
        this.map.fitBounds(this.bounds);
    },


};
