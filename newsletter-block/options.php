<?php
/* 
 * @var $options array contains all the options the current block we're ediging contains
 * @var $controls NewsletterControls 
 */
?>
<style>
    .CodeMirror {
        height: 300px;
    }
</style>
<script>
    var templateEditor;
    jQuery(function() {
        templateEditor = CodeMirror.fromTextArea(document.getElementById("options-code"), {
            lineWrapping: true,
        });
    });
    
    function example_code() {
    	templateEditor.getDoc().setValue('[playable:eJzFVl1v4jgUfedX3EYaqV01JASKSgJV1YfZfRitZl+621bVysSX4MGxI8cE2Kr72/c6AQZoR12pzMwDIb6+Pj4598Menvg+fJZsxcYS4VZw1OfwmVlUFn7XbYjO+53u+WXUAd+/GpZ2JfGqdZ0jFwxO/QWOZ8L6lVvmF2sUXygpFJ7BU+uXh43xEWoneAIuSmeMYSx1OoMTkRfaWKZsAs+vLPgXRJ7tLlNa4cGq59b1DFcTw3IsYUvDYIVMEgsIPxCALlgqLAGEyURIi8YxmJvTfq9YnjkUuKj99ibDzVwn3AfpNPsOg0aSIcn4ICaQl/rxamhrMZkUmRp5KUmJxoOxNhzNyAs9SFHK0iGpbDsuGOfrMQEY+vFDhGo9trrwYCG4nY68XuT8Tx5QcTF5dDHiotpqMPLuoo+r+z9vV3/8dlPe/SWnd/lSflL3xf2vt5UHNfmRN2bpLDN6rrgvcpZhPDfydGptUcZBkHLV3uC165gEHHP9mi3u9aPLfv+iOwi73e7gIgq6wQtTpx8PAj+QelGatP2lyM6Snf1L8Q/GqVaWCbVrN1ggs7HS67fduUKXwgqt4kYoaP6SnJlMqDgENrc6YYo+rfY6TJBOSa5LvxY0Jj2LZaIrNBNiGE8F56gSr5H1/8j1mjZLwf9+VZ/2nGaeBH8mOZgL/0stHHmIwg/vFGNrNihJhgqTKYpsauOw/vjtYJ2G/lhbq/OY0r5Nme8EYDA1OBl57/zQVIp0FmxA9tfTLk3Rr4U+DEvz7krx6/ewcanl3GKyaRCuPxzE3gNyt674flhSeyC1LiAnZhxajoWDrguzbPojdVM9NylC3UxH3lvdlCn+tePmQvkcK5GiX4glSt+43I6he0ZFbdJ3R6l2vO4u23nR88CuCopGs9gZvgv16KjUo+NQPyKlNm2U7xOqLT+R0TcUamavhu7g3TlmoGkS68HbJbruKXUFfrtc61vAi3o9ZiLUaCXaoxUFdKJ+uDiHI/GDy96x0ICCsAP13bscDAYLkpfOqfLtLtCpiBplRkVLmKRw3IgMbuZ0B7yZK7XyIKDUY/Sjo3bz3LtWBZa7h3EPh7x372k5X6DhwW3W3Vv/A8aNqx8]');
    }
</script>
<p><span style="float:right"><a href="https://playable.video/project/how-to-add-video-to-newsletter-email/" target="_blank">Help</a> &middot; <a href="#" onclick="example_code();return false;">Example</a></span>Paste your Embed Code here:</p>
<?php $controls->textarea('code') ?>
<?php $fields->block_commons() ?>