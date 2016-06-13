var Homepage = {

    videoArray: new Array(),
    videoCurrentIndex: 1,

    initSearch: function(uri) {
        $("#location").select2({
            language: "fr",
            placeholder: 'Où boire un verre ?',
            ajax: {
                url: uri,
                dataType: 'json',
                quietMillis: 100,
                data: function (term) {
                    console.log(term);
                    return {
                        q: term.term
                    };
                },
                results: function (data) {
                    var myResults = [];
                    $.each(data.results, function (index, item) {
                        myResults.push({
                            'id': item.id,
                            'text': item.name
                        });
                    });
                    return {
                        results: myResults
                    };
                },
                processResults: function (data, params) {

                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    },
    
    addVideo: function(mp4, webm) {
        Homepage.videoArray.push({
            mp4: mp4,
            webm: webm
        })
    },
    
    changeVideo: function() {
        var sourceMp4 = document.getElementById('source-mp4');
        var sourceWebm = document.getElementById('source-webm');
        var video = document.getElementById('backgroundVideo');

        setTimeout(function() {
            video.pause();

            sourceMp4.setAttribute('src', Homepage.videoArray[1].mp4);
            sourceWebm.setAttribute('src', Homepage.videoArray[1].webm);
            video.load();
            video.play();


            Homepage.videoCurrentIndex++;

            if (Homepage.videoCurrentIndex == (Homepage.videoCurrentIndex.length-1))
                Homepage.videoCurrentIndex = 0;

            Homepage.changeVideo();
        }, 30000);

    },

    initVideo: function() {
        $( document ).ready(function() {

            scaleVideoContainer();

            initBannerVideoSize('.video-container .poster img');
            initBannerVideoSize('.video-container .filter');
            initBannerVideoSize('.video-container video');

            $(window).on('resize', function() {
                scaleVideoContainer();
                scaleBannerVideoSize('.video-container .poster img');
                scaleBannerVideoSize('.video-container .filter');
                scaleBannerVideoSize('.video-container video');
            });

        });

        function scaleVideoContainer() {

            var height = $(window).height() + 5;
            var unitHeight = parseInt(height) + 'px';
            $('.homepage-hero-module').css('height',unitHeight);

        }

        function initBannerVideoSize(element){

            $(element).each(function(){
                $(this).data('height', $(this).height());
                $(this).data('width', $(this).width());
            });

            scaleBannerVideoSize(element);

        }

        function scaleBannerVideoSize(element){

            var windowWidth = $(window).width(),
                windowHeight = $(window).height() + 5,
                videoWidth,
                videoHeight;

            console.log(windowHeight);

            $(element).each(function(){
                var videoAspectRatio = $(this).data('height')/$(this).data('width');

                $(this).width(windowWidth);

                if(windowWidth < 1000){
                    videoHeight = windowHeight;
                    videoWidth = videoHeight / videoAspectRatio;
                    $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

                    $(this).width(videoWidth).height(videoHeight);
                }

                $('.homepage-hero-module .video-container video').addClass('fadeIn animated');

            });
        }
    }

};
