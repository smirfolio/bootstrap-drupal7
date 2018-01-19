<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */

?>

<?php if (arg(0) == "agate"): ?>
  <?php
  /* check if the path is example.com/agate */
  include 'page--user.tpl.php';
  /* load a custom page--user.tpl.php */
  ?>
<?php else: ?>
<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="container">
    <div class="navbar-header">
      <?php if ($logo): ?>
        <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>"
          title="<?php print t('Home'); ?>">
          <img class="img-responsive" src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
        </a>
      <?php endif; ?>

      <?php if (!empty($site_name)): ?>
        <a class="name navbar-brand" href="<?php print $front_page; ?>"
          title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
      <?php endif; ?>

      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <button type="button" class="navbar-toggle" data-toggle="collapse"
        data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="navbar-collapse collapse">
      <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>

        <nav role="navigation">
          <?php if (!empty($primary_nav)): ?>
            <?php print render($primary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($secondary_nav)): ?>
            <?php print render($secondary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($page['navigation'])): ?>
            <?php print render($page['navigation']); ?>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
        <ul class="nav navbar-nav navbar-right">
          <?php if (empty($user->roles[1]) || $user->roles[1] !== 'anonymous user'): ?>
          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <?php print !empty($user->data['real_name'])?$user->data['real_name']:$user->name; ?>
              <i class="fa fa-caret-down"></i></a>
            <ul class="dropdown-menu pull-right">
              <li><?php print l('<i class="fa fa-cog"></i> ' .
                  t('My Profile'), $profile_path,
                  array('html' => TRUE, 'fragment' => 'view')) ?></li>
              <li class="divider"></li>
              <?php
              if (module_exists('obiba_agate')){
                $logout_path_redirect = obiba_agate_redirect_path();
                $redirect_place_holder = variable_get_value('obiba_logout_redirection_page')=='<current>'?'redirection-place-holder':'no-redirection';
              }
              else{
                $logout_path_redirect = current_path();
              }
                ?>
              <li><?php
                $link_logout = l('<i class="fa fa-sign-out"></i> ' . t('Sign Out'), 'user/logout', array(
                  'attributes' => array('class' => array(!empty($redirect_place_holder)?$redirect_place_holder:'redirection-place-holder')),
                  'query' => array('destination' => $logout_path_redirect),
                  'html' => TRUE));
                print $link_logout ?></li>
            </ul>
          </li>
            <!--        Switch lang if enabled-->
      <?php else: ?>
          <?php $register_url = (module_exists('obiba_agate') ? 'agate' : 'user') . '/register/';?>
          <?php $option_sign_up = array('attributes' => array('class' => array('redirection-place-holder', ''))) ;
          if(module_exists('obiba_agate')){
            $option_sign_up = array_merge($option_sign_up, array('fragment' => 'join'));
          }
          ?>
          <li><?php print l(variable_get_value('access_signup_button'),
              $register_url, $option_sign_up) ?></li>
         <li> <?php
          print l(variable_get_value('access_signin_button'), 'user/login', array(
            'attributes' => array('class' => array('redirection-place-holder', '')),
            'query' => array('destination' => current_path()),
          )) ?></li>
      <?php endif; ?>
            <!--        Switch lang if enabled-->
          <?php if (!empty($content_lang_switch) && module_exists('locale')): ?>
            <?php print render($content_lang_switch); ?>
          <?php endif; ?>
            <!--     Switch lang if enabled   -->
        </ul>

    </div>
  </div>
</header>

  <div class="main-container container" ng-app="mica"
    ng-controller="MainController">

  <header role="banner" id="page-header">
    <?php if (!empty($site_slogan)): ?>
      <p class="lead"><?php print $site_slogan; ?></p>
    <?php endif; ?>

    <?php print render($page['header']); ?>

  </header>
  <!-- /#page-header -->

  <div class="row">
    <div<?php print $content_column_class; ?>>
    <?php if (!empty($breadcrumb)): print $breadcrumb;
    endif; ?>
    <?php if (!empty($title)): ?>
      <h1 class="page-header">
        <?php if (!empty($classes_array['title_page'])) : ?>
          <span
            class="t_badge color_<?php print $classes_array['title_page']; ?> i-obiba-<?php print $classes_array['title_page']; ?>">
          </span>
        <?php endif; ?>
        <?php print $title; ?>
      </h1>
    <?php endif; ?>
    <?php if (!empty($page['obiba_help'])): ?>
      <div class="row ">
        <div class="help-info-box alert alert-info alert-dismissible"
          role="alert">
          <button type="button" class="close" data-dismiss="alert"
            aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php print render($page['obiba_help']); ?>
      </div>
      </div>
    <?php endif; ?>
    </div>
    <?php if (!empty($page['sidebar_first']) || !empty($page['facets'])): ?>
      <aside class="col-sm-4 col-lg-3" role="complementary">
        <?php if (!empty($page['facets'])): ?>
          <?php print render($page['facets']); ?>
        <?php endif; ?>
        <?php if (!empty($page['sidebar_first'])) : ?>
          <?php print render($page['sidebar_first']); ?>
        <?php endif; ?>
      </aside>
      <!-- /#sidebar-first -->
    <?php endif; ?>

    <section<?php print $content_column_class; ?>>
      <?php if (!empty($page['highlighted'])): ?>
        <div
          class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>

      <a id="main-content"></a>
      <?php print render($title_prefix); ?>

      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <?php print render($page['help']); ?>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
    </section>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>
      <!-- /#sidebar-second -->
    <?php endif; ?>
    <!-- Sidebar -->

    <!-- Fixed side -->
    <div id="fixed-sidebar">
      <div id="sidebar-wrapper"
        class="side-bar-content sidebar-untoggled"></div>
    </div>
    <!-- /#Fixed side -->

    <!-- /#sidebar-wrapper -->
  </div>
</div>
<footer class="footer container">
  <?php print render($page['footer']); ?>
</footer>
<?php endif; ?>
