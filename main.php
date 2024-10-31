<?php
/**
* Plugin Name: Playable Video
* Description: Official <a href="https://playable.video">Playable Video</a> support for WordPress. Add video to your MailPoet and Newsletter campaigns.
* Version: 1.1.3
* Author: Playable
* Author URI: https://playable.video
**/

// convert embed code into HTML snippet that renders the video
function playable_decode_video($code) {
	return zlib_decode(base64_decode($code));
}

// MailPoet
function playable_mailpoet_shortcode($shortcode, $newsletter, $subscriber, $queue, $newsletter_body) {
  // only match "[playable:.*]"
  if (substr($shortcode, 0, 10) !== "[playable:") return $shortcode; 
  
  // decode video and add merge tag to enable reporting of click-to-open rates
  $video = strtr(playable_decode_video(substr($shortcode, 10, -1)), array(
    '{id}' => $subscriber->id
  ));
  
  return $video;
}
add_filter('mailpoet_newsletter_shortcode', 'playable_mailpoet_shortcode', 10, 5);

// Newsletter
add_action('newsletter_register_blocks', function() {
  TNP_Composer::register_block(__DIR__ . '/newsletter-block');
});

// Email Subscribers & Newsletters
add_shortcode('playable', function($params) {
  if (!$params[0]) {
  	return '[playable]';
  }

  try {
    // decode video and add UUID to enable reporting of click-to-open rates
    $video = strtr(playable_decode_video($params[0]), array(
      '{id}' => wp_generate_uuid4()
    ));
  } catch (Exception $ex) {
    $video = '[playable]';
  }
  
  return $video;
});

// Settings
add_action('admin_menu', function() {
  add_options_page('Playable Video Settings', 'Playable Video', 'manage_options', 'playable-video', 'playable_settings_page');
});

function playable_settings_page() {
?>
  <h1>Playable Video</h1>
  <p><a href="https://playable.video" target="_blank">Playable Video</a> adds video content to your email campaigns.</p>
  <p>Videos play automatically on over 98% of inboxes, when the email is opened.</p>

  <h2>Requirements</h2>
  <p>You need one of these WordPress plugins to send your email campaigns:
  <br>* MailPoet - <a href="https://wordpress.org/plugins/mailpoet/" target="_blank">https://wordpress.org/plugins/mailpoet/</a>
  <br>* Newsletter - <a href="https://wordpress.org/plugins/newsletter/" target="_blank">https://wordpress.org/plugins/newsletter/</a>
  <br>* Email Subscribers & Newsletters - <a href="https://wordpress.org/plugins/email-subscribers/" target="_blank">https://wordpress.org/plugins/email-subscribers/</a></p>

  <p>You also need a Playable account (free or paid). <a href="https://signup.playable.video" target="_blank">Signup here</a>.

  <h2>Instructions - MailPoet</h2>
  <p>Playable generates an "Embed Code" for each of your videos, that you paste into your email template to display the video in your email campaign.</p> 
  <p><img src="https://ps.w.org/playable-video/assets/screenshot-1.gif" width="600" alt="MailPoet">
  <br><em>Paste the Embed Code into MailPoet and see the video when you Preview or Send the campaign.</em></p>
  <p>A complete step-by-step tutorial for adding video to your MailPoet campaigns is <a href="https://playable.video/project/how-to-add-video-to-mailpoet-email/" target="_blank">here</a>.</p>
  <p>Here's a sample video embed code for testing purposes:</p>
  <textarea readonly disabled style="width:800px;height:65px;">[playable:eJzFVl1v4jgUfedX3EYaqV01JASKSgJV1YfZfRitZl+621bVysSX4MGxI8cE2Kr72/c6AQZoR12pzMwDIb6+Pj4598Menvg+fJZsxcYS4VZw1OfwmVlUFn7XbYjO+53u+WXUAd+/GpZ2JfGqdZ0jFwxO/QWOZ8L6lVvmF2sUXygpFJ7BU+uXh43xEWoneAIuSmeMYSx1OoMTkRfaWKZsAs+vLPgXRJ7tLlNa4cGq59b1DFcTw3IsYUvDYIVMEgsIPxCALlgqLAGEyURIi8YxmJvTfq9YnjkUuKj99ibDzVwn3AfpNPsOg0aSIcn4ICaQl/rxamhrMZkUmRp5KUmJxoOxNhzNyAs9SFHK0iGpbDsuGOfrMQEY+vFDhGo9trrwYCG4nY68XuT8Tx5QcTF5dDHiotpqMPLuoo+r+z9vV3/8dlPe/SWnd/lSflL3xf2vt5UHNfmRN2bpLDN6rrgvcpZhPDfydGptUcZBkHLV3uC165gEHHP9mi3u9aPLfv+iOwi73e7gIgq6wQtTpx8PAj+QelGatP2lyM6Snf1L8Q/GqVaWCbVrN1ggs7HS67fduUKXwgqt4kYoaP6SnJlMqDgENrc6YYo+rfY6TJBOSa5LvxY0Jj2LZaIrNBNiGE8F56gSr5H1/8j1mjZLwf9+VZ/2nGaeBH8mOZgL/0stHHmIwg/vFGNrNihJhgqTKYpsauOw/vjtYJ2G/lhbq/OY0r5Nme8EYDA1OBl57/zQVIp0FmxA9tfTLk3Rr4U+DEvz7krx6/ewcanl3GKyaRCuPxzE3gNyt674flhSeyC1LiAnZhxajoWDrguzbPojdVM9NylC3UxH3lvdlCn+tePmQvkcK5GiX4glSt+43I6he0ZFbdJ3R6l2vO4u23nR88CuCopGs9gZvgv16KjUo+NQPyKlNm2U7xOqLT+R0TcUamavhu7g3TlmoGkS68HbJbruKXUFfrtc61vAi3o9ZiLUaCXaoxUFdKJ+uDiHI/GDy96x0ICCsAP13bscDAYLkpfOqfLtLtCpiBplRkVLmKRw3IgMbuZ0B7yZK7XyIKDUY/Sjo3bz3LtWBZa7h3EPh7x372k5X6DhwW3W3Vv/A8aNqx8=]</textarea> 
  
  <h2>Instructions - Newsletter</h4>  
  <p>Playable generates an "Embed Code" for each of your videos, that you paste into your email template to display the video in your email campaign.</p> 
  <p><img src="https://ps.w.org/playable-video/assets/screenshot-2.gif" width="600" alt="Newsletter">
  <br><em>Drag a Video block into your campaign and paste the Embed Code.</em></p>
  <p>A complete step-by-step tutorial for adding video to your Newsletter campaigns is <a href="https://playable.video/project/how-to-add-video-to-newsletter-email/" target="_blank">here</a>.</p>
  <p>Here's a sample video embed code for testing purposes:</p>
  <textarea readonly disabled style="width:800px;height:65px;">[playable:eJzFVl1v4jgUfedX3EYaqV01JASKSgJV1YfZfRitZl+621bVysSX4MGxI8cE2Kr72/c6AQZoR12pzMwDIb6+Pj4598Menvg+fJZsxcYS4VZw1OfwmVlUFn7XbYjO+53u+WXUAd+/GpZ2JfGqdZ0jFwxO/QWOZ8L6lVvmF2sUXygpFJ7BU+uXh43xEWoneAIuSmeMYSx1OoMTkRfaWKZsAs+vLPgXRJ7tLlNa4cGq59b1DFcTw3IsYUvDYIVMEgsIPxCALlgqLAGEyURIi8YxmJvTfq9YnjkUuKj99ibDzVwn3AfpNPsOg0aSIcn4ICaQl/rxamhrMZkUmRp5KUmJxoOxNhzNyAs9SFHK0iGpbDsuGOfrMQEY+vFDhGo9trrwYCG4nY68XuT8Tx5QcTF5dDHiotpqMPLuoo+r+z9vV3/8dlPe/SWnd/lSflL3xf2vt5UHNfmRN2bpLDN6rrgvcpZhPDfydGptUcZBkHLV3uC165gEHHP9mi3u9aPLfv+iOwi73e7gIgq6wQtTpx8PAj+QelGatP2lyM6Snf1L8Q/GqVaWCbVrN1ggs7HS67fduUKXwgqt4kYoaP6SnJlMqDgENrc6YYo+rfY6TJBOSa5LvxY0Jj2LZaIrNBNiGE8F56gSr5H1/8j1mjZLwf9+VZ/2nGaeBH8mOZgL/0stHHmIwg/vFGNrNihJhgqTKYpsauOw/vjtYJ2G/lhbq/OY0r5Nme8EYDA1OBl57/zQVIp0FmxA9tfTLk3Rr4U+DEvz7krx6/ewcanl3GKyaRCuPxzE3gNyt674flhSeyC1LiAnZhxajoWDrguzbPojdVM9NylC3UxH3lvdlCn+tePmQvkcK5GiX4glSt+43I6he0ZFbdJ3R6l2vO4u23nR88CuCopGs9gZvgv16KjUo+NQPyKlNm2U7xOqLT+R0TcUamavhu7g3TlmoGkS68HbJbruKXUFfrtc61vAi3o9ZiLUaCXaoxUFdKJ+uDiHI/GDy96x0ICCsAP13bscDAYLkpfOqfLtLtCpiBplRkVLmKRw3IgMbuZ0B7yZK7XyIKDUY/Sjo3bz3LtWBZa7h3EPh7x372k5X6DhwW3W3Vv/A8aNqx8=]</textarea> 
   
  <h2>Instructions - Email Subscribers & Newsletters</h2>
  <p>Playable generates an "Embed Code" for each of your videos, that you paste into your email template to display the video in your email campaign.</p> 
  <p>Here's a sample embed code for testing on Email Subscribers & Newsletters:</p>
  <textarea readonly disabled style="width:800px;height:65px;">[playable eJzFVl1v4jgUfedX3EYaqV01JASKSgJV1YfZfRitZl+621bVysSX4MGxI8cE2Kr72/c6AQZoR12pzMwDIb6+Pj4598Menvg+fJZsxcYS4VZw1OfwmVlUFn7XbYjO+53u+WXUAd+/GpZ2JfGqdZ0jFwxO/QWOZ8L6lVvmF2sUXygpFJ7BU+uXh43xEWoneAIuSmeMYSx1OoMTkRfaWKZsAs+vLPgXRJ7tLlNa4cGq59b1DFcTw3IsYUvDYIVMEgsIPxCALlgqLAGEyURIi8YxmJvTfq9YnjkUuKj99ibDzVwn3AfpNPsOg0aSIcn4ICaQl/rxamhrMZkUmRp5KUmJxoOxNhzNyAs9SFHK0iGpbDsuGOfrMQEY+vFDhGo9trrwYCG4nY68XuT8Tx5QcTF5dDHiotpqMPLuoo+r+z9vV3/8dlPe/SWnd/lSflL3xf2vt5UHNfmRN2bpLDN6rrgvcpZhPDfydGptUcZBkHLV3uC165gEHHP9mi3u9aPLfv+iOwi73e7gIgq6wQtTpx8PAj+QelGatP2lyM6Snf1L8Q/GqVaWCbVrN1ggs7HS67fduUKXwgqt4kYoaP6SnJlMqDgENrc6YYo+rfY6TJBOSa5LvxY0Jj2LZaIrNBNiGE8F56gSr5H1/8j1mjZLwf9+VZ/2nGaeBH8mOZgL/0stHHmIwg/vFGNrNihJhgqTKYpsauOw/vjtYJ2G/lhbq/OY0r5Nme8EYDA1OBl57/zQVIp0FmxA9tfTLk3Rr4U+DEvz7krx6/ewcanl3GKyaRCuPxzE3gNyt674flhSeyC1LiAnZhxajoWDrguzbPojdVM9NylC3UxH3lvdlCn+tePmQvkcK5GiX4glSt+43I6he0ZFbdJ3R6l2vO4u23nR88CuCopGs9gZvgv16KjUo+NQPyKlNm2U7xOqLT+R0TcUamavhu7g3TlmoGkS68HbJbruKXUFfrtc61vAi3o9ZiLUaCXaoxUFdKJ+uDiHI/GDy96x0ICCsAP13bscDAYLkpfOqfLtLtCpiBplRkVLmKRw3IgMbuZ0B7yZK7XyIKDUY/Sjo3bz3LtWBZa7h3EPh7x372k5X6DhwW3W3Vv/A8aNqx8=]</textarea> 

  <h2>Support</h2>
  <p><a href="mailto:support@playable.video">support@playable.video</a> - here to help!</p>
<?php
} ?>