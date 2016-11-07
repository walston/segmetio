<?php
namespace SegMetrics_IO_Hook\Facing;

add_action('wp_enqueue_scripts', '\\SegMetrics_IO_Hook\\Facing\\post_type_filter');

function post_type_filter()
{
  if (get_post_meta(get_the_ID(), 'use_segmetrics', true) === "on") {
    add_action('wp_footer', '\\SegMetrics_IO_Hook\\Facing\\script_tag');
  }
}

function script_tag()
{
  ?>

  <!-- SegMetrics -->
  <script type="text/javascript">
  var _segq = _segq || [];
  var _segs = _segs || {};
  _segs.integration = '1381';
  (function() {
      var dc = document.createElement('script');
      dc.type = 'text/javascript'; dc.async = true;
      dc.src = '//tag.segmetrics.io/segmet.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(dc, s);
  })();
  </script>

 <?php
}
