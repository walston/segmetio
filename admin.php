<?php
namespace SegMetrics_IO_Hook\Admin;

add_action('add_meta_boxes', '\\SegMetrics_IO_Hook\\Admin\\insert_meta_box');
function insert_meta_box()
{
  add_meta_box(
    'SegMetricsScript', # html ID
    'SegMetrics.io Script', # Title
    '\\SegMetrics_IO_Hook\\Admin\\meta_box', # callable
    'page', # $screen
    'side', # $context
    'high' # $priority
  );
}

function meta_box($object)
{

  wp_nonce_field('Seggy555kosher_', 'segmetrics_nonce');

  $use_script = get_post_meta($object->ID, 'use_segmetrics', true);

  $checkbox = sprintf(
    '<input id="%1$s" name="%2$s" type="checkbox" %3$s>',
    'segmetrics',
    'segmetrics',
    $use_script == "on" ? 'checked="true"' : ''
  )

  ?>

  <div>
    <label for="segmetrics">
      <?php echo $checkbox; ?>
      Use SegMetrics.io script
    </label>
  </div>

  <?php
}

add_action('save_post', '\\SegMetrics_IO_Hook\\Admin\\validate_post_meta');

function validate_post_meta($post_id)
{
  $can_edit    = current_user_can('edit_post', $post_id);
  $is_post     = get_post_type($post_id) !== "post";
  $has_nonce   = isset($_POST['segmetrics_nonce']);
  $valid_nonce = wp_verify_nonce($_POST['segmetrics_nonce'], 'Seggy555kosher_');

  if ($can_edit && $is_post && $has_nonce && $valid_nonce) {
    save_this_meta($post_id, 'use_segmetrics', $_POST['segmetrics']);
  }
  else {
    return $post_id;
  }

}

function save_this_meta($post_id, $key, $value)
{
  if (isset($value)) {
    update_post_meta($post_id, $key, $value);
  }
  else {
    delete_post_meta($post_id, $key);
  }
}
