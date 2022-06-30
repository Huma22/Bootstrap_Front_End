<script>
    function loadMore() {
        jQuery('.playlist').toggleClass('h-full');
        if (jQuery('.playlist').hasClass('h-full')) {
            jQuery('.loadMoreBtn').html("Show Less");
        } else {
            jQuery('.loadMoreBtn').html("Load More");
        }
    }
    $(".video-player").aksVideoPlayer({
        file: [{
            file: $(".video-player").attr('data-video-url'),
            label: "Auto"
        }],
        poster: $(".video-player").attr('data-poster-url'),
        forward: true,
        contextMenu: [{
            type: "urlCopy",
            label: "Copy Video Url",
            url: $(".video-player").attr('data-video-url')
        }],
    });

    $('.currentVideo video').on("ended", function() {
        let nextVideoUrl = $('.currentVideo').attr('data-next-url');
        window.location.href = nextVideoUrl;
    })
</script>