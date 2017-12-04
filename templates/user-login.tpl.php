<?php
/**
 * @file
 * Code for login block.
 */

?>

<p><?php print render($intro_text); ?></p>

<div class="row">
  <div class="col-md-6">
    <?php print drupal_render_children($form) ?>
    <div class="md-top-margin">
      <?php print l(t('Forgot your password?'), 'user/password') ?>
      <div>
        <?php $register_url = (module_exists('obiba_agate') ? 'agate' : 'user') . '/register/';
        $option_sign_up = [];
        if (module_exists('obiba_agate')) {
          $option_sign_up = array('fragment' => 'join');
        }
        print l(t('Not a member? Join now'), $register_url, $option_sign_up) ?>
      </div>
    </div>
  </div>
</div>
