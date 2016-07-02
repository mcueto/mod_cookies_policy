<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();

// Get input cookie object
$inputCookie  = JFactory::getApplication()->input->cookie;

// Get cookie data (the module won't render if the cookie exists)
$cookies_policy_accepted = $inputCookie->get($name = 'cookies_policy_accept', $defaultValue = null);

$doc->addScriptDeclaration("

    function setCookie(key, value) {
      var expires = new Date();
      expires.setTime(expires.getTime() + 31536000000); //1 year
      document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
      var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
      return keyValue ? keyValue[2] : null;
    }


    jQuery(document).ready(function(){
      jQuery('#cookies_policy_accept_button').click(function(){
        jQuery('#cookies_policy_module').fadeOut();
        setCookie('cookies_policy_accept', new Date());
      });
    });");
?>

<?php if ($cookies_policy_accepted===null) : ?>
<div class="cookies_policy_module<?php echo '' ?>"  id="cookies_policy_module">
  <h3><?php echo $params->get("title");?></h3>
  <p>
    <?php echo $params->get("message");?>
  </p>
  <p>
    <a class="button button-primary" id="cookies_policy_accept_button">
      <?php echo $params->get("accept_button_text");?>
    </a>
    <a class="button" id="cookies_policy_more_button" href="<?php echo $params->get("more_button_link");?>">
      <?php echo $params->get("more_button_text");?>
    </a>
  </p>
</div>
<?php endif; ?>
