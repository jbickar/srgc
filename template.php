<?php
// $Id: template.php,v 1.2 2010-10-22 22:22:13 jbickar Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to srgc_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: srgc_breadcrumb()
 *
 *   where srgc is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/*
 * Add any conditional stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that ALWAYS need to be included, you should add them to
 * your .info file instead. Only use this section if you are including
 * stylesheets based on certain conditions.
 */
/* -- Delete this line if you want to use and modify this code
// Example: optionally add a fixed width CSS file.
if (theme_get_setting('srgc_fixed')) {
  drupal_add_css(path_to_theme() . '/layout-fixed.css', 'theme', 'all');
}
// */


/**
 * Implementation of HOOK_theme().
 */
function srgc_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function srgc_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function srgc_preprocess_page(&$vars, $hook) {
  if ((!in_array('authenticated user', $vars['user']->roles)) && ((in_array('page-activities-bullseye-league-shooter', $vars['template_files'])) || (preg_match('/Bullseye League Results for/', $vars['title']) >= 1))) {
    $title_orig = $vars['title'];
    $title = preg_split('/\s/', $title_orig);
    $count = count($title) - 1;
    $title[$count] = substr($title[$count], 0, 2) .'.';
    $title = implode(' ', $title);
    $vars['title'] = t($title);
    $vars['head_title'] = t($title) ." | ". t('Sunnyvale Rod and Gun Club');
  }

//  $vars['sample_variable'] = t('Lorem ipsum.');
}


/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */

/*function srgc_preprocess_node(&$vars, $hook) {
//  $vars['sample_variable'] = t('Lorem ipsum.');
}
//*/

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function srgc_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function srgc_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function srgc_breadcrumb($breadcrumb) { 
  if (!empty($breadcrumb)) {
    $path = explode('/', $_SERVER['REQUEST_URI']);
    $title = drupal_get_title();
    global $user;
    if ((!in_array('authenticated user', $user->roles)) && (preg_match('/Bullseye League Results for/', $title) >= 1)) {
      $title = preg_split('/\s/', $title);
      $count = count($title) - 1;
      $title[$count] = substr($title[$count], 0, 2) .'.';
      $title = implode(' ', $title);
    }
    if($path[1]) {
//      unset($breadcrumb);
//      $breadcrumb[] = l(ucfirst($path[1]), $path[1], $options = array());
      $breadcrumb[] = $title; 
   }
   return implode(' &gt;&gt; ', $breadcrumb);
  }
}

/**
 * Implements theme_menu_item_link()
 */
function srgc_menu_item_link($link) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }

  // If an item is a LOCAL TASK, render it as a tab
  if ($link['type'] & MENU_IS_LOCAL_TASK) {
    $link['title'] = '<span class="tab">' . check_plain($link['title']) . '</span>';
    $link['localized_options']['html'] = TRUE;
  }

  return l($link['title'], $link['href'], $link['localized_options']);
}

/*
 * Theme override of theme_number_formatter_us_2().
 * Turns floating point decimals into Xs.
 */

function srgc_number_formatter_us_2($element) {
  $field = content_fields($element['#field_name'], $element['#type_name']);
  $value = $element['#item']['value'];

  if (($allowed_values = content_allowed_values($field))) {
    if (isset($allowed_values[$value]) && $allowed_values[$value] != $value) {
      return $allowed_values[$value];
    }
  }

  if (empty($value) && $value !== '0') {
    return '';
  }

  switch ($element['#formatter']) {
    case 'us_0':
      $output = number_format($value, 0, '.', ',');
      break;
    case 'us_1':
      $output = number_format($value, 1, '.', ',');
      break;
    case 'us_2':
      $output = number_format($value, 2, '.', ',');
      break;
    case 'be_0':
      $output = number_format($value, 0, ',', '.');
      break;
    case 'be_1':
      $output = number_format($value, 1, ',', '.');
      break;
    case 'be_2':
      $output = number_format($value, 2, ',', '.');
      break;
    case 'fr_0':
      $output = number_format($value, 0, ', ', ' ');
      break;
    case 'fr_1':
      $output = number_format($value, 1, ', ', ' ');
      break;
    case 'fr_2':
      $output = number_format($value, 2, ', ', ' ');
      break;
    default:
      $output = $value;
      break;
  }
  $score_exes = explode('.', $output);
  $exes = $score_exes[1];
  if (strpos($exes, '0') == 0) {
    $exes = str_replace('0', '', $exes);
    if ($exes == '') {
      $exes = '0';
    }
  }
  $score_exes[1] = $exes;
  $output = implode(' - ', $score_exes);
  $output = $output .'x';
  $prefixes = isset($field['prefix']) ? array_map('content_filter_xss', explode('|', $field['prefix'])) : array('');
  $suffixes = isset($field['suffix']) ? array_map('content_filter_xss', explode('|', $field['suffix'])) : array('');
  $prefix = (count($prefixes) > 1) ? format_plural($value, $prefixes[0], $prefixes[1]) : $prefixes[0];
  $suffix = (count($suffixes) > 1) ? format_plural($value, $suffixes[0], $suffixes[1]) : $suffixes[0];

  return $prefix . $output . $suffix;
}

/**
 * Theme function for 'computed_value' text field formatter.
 * Replace floating points with Xs.
 */
function srgc_computed_field_formatter_computed_value($element) {
  $this_node = node_load($node->nid);
//  dsm($element);
  $output = $element['#item']['value'];
  $output = round($output, 2);
  $score_exes = explode('.', $output);
  $exes = $score_exes[1];
  if (strlen($exes) == '1') {
    $exes = $exes .'0';
  }
  if (strpos($exes, '0') == 0) {
    $exes = str_replace('0', '', $exes);
    if ($exes == '') {
      $exes = '0';
    }
  }
  $score_exes[1] = $exes;
  $output = implode(' - ', $score_exes);
  $output = $output .'x';

  return $output;
}


/**
 * Create the calendar date box.
 */
function srgc_preprocess_calendar_datebox(&$vars) {
  $date = $vars['date'];
  $view = $vars['view'];
  $vars['day'] = intval(substr($date, 8, 2));
  $force_view_url = !empty($view->date_info->block) ? TRUE : FALSE;
  $vars['url'] = date_real_url($view, NULL, $date, $force_view_url);
  if (($view->name == 'bullseye_calendar') && ($vars['mini'] == TRUE)) {
    $vars['link'] = l($vars['day'], 'activities/bullseye/league/' .$date);
  }
  else{
    $vars['link'] = l($vars['day'], $vars['url']);
  }
  $vars['granularity'] = $view->date_info->granularity;
  $vars['mini'] = $view->date_info->mini;
  
  if ($view->date_info->mini) {
    if (!empty($vars['selected'])) {
      $vars['class'] = 'mini-day-on';
    }
    else {
      $vars['class'] = 'mini-day-off';
    }
  }
  else {
    $vars['class'] = 'day';
  }
}

/*
 *
 * Override of search#noresults
 * See hook_help() in search.module
 *
 */
function srgc_box($title, $content, $region = 'main') {
  if ($title == 'Your search yielded no results') {
    $content = '<h3>Search Tips</h3>';
    $content .= '<ul><li>Check if your spelling is correct.</li>';
    $content .= '<li>Simplify your search by using fewer words.</li><li>Remove quotes around phrases to match each word individually: <em>"action pistol"</em> will match less than <em>action pistol</em>.</li>';
    $content .= '<li>Consider loosening your query with <em>OR</em>: <em>action pistol</em> will match less than <em>action OR pistol</em>.</li>';
    $content .= '<li>Feel free to <a href="/contact">contact us</a> if you have further questions.</li></ul>';
  }
  $output = '<h2 class="title">'. $title .'</h2><div>'. $content .'</div>';
  return $output;
}
