<video id=example-video width=960 height=540 class="video-js vjs-default-skin" controls>
  <source
     src="uploads/tsfiles/HEYYA/HEYYA.m3u8"
     type="application/x-mpegURL">
</video>
<script src="videojs-contrib-hls.js"></script>
<script src="videojs-contrib-hls.min.js"></script>
<script>
var player = videojs('example-video');
player.play();
</script>