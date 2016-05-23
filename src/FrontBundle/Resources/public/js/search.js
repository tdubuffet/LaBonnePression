var Search = {

    map: null,
    bounds: new google.maps.LatLngBounds(),

    init: function(lat, lnt) {

        var height = $(window).height();
        var width = $('.col-gmaps').width();
        console.log(width);
        $('#gmaps').height(height-55);
        $('#gmaps-container').width(width);

        this.map = new GMaps({
            el: '#gmaps',
            scrollwheel: false,
            zoom: 13,
            styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
        });



        this.bounds =  new google.maps.LatLngBounds();
    },

    addMarker: function(lat, lng, name, id) {

        this.map.addMarker({
            lat: lat,
            lng: lng,
            title: name,
            icon: '/bundles/front/images/cocktail.png',
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
