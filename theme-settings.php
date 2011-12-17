<?php
// $Id: theme-settings.php,v 1.1.1.1 2010-02-26 21:18:44 jbickar Exp $

// Include the definition of zen_settings() and zen_theme_get_default_settings().
include_once './' . drupal_get_path('theme', 'zen') . '/theme-settings.php';


/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array.
 */
function srgc_settings($saved_settings) {

  // Get the default values from the .info file.
  $defaults = zen_theme_get_default_settings('srgc');

  // Merge the saved variables and their default values.
  $settings = array_merge($defaults, $saved_settings);

  /*
   * Create the form using Forms API: http://api.drupal.org/api/6
   */
  $form = array();
  /* -- Delete this line if you want to use this setting
  $form['srgc_example'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Use this sample setting'),
    '#default_value' => $settings['srgc_example'],
    '#description'   => t("This option doesn't do anything; it's just an example."),
  );
  // */

  // Add the base theme's settings.
  $form += zen_settings($saved_settings, $defaults);

  // Remove some of the base theme's settings.
  unset($form['themedev']['zen_layout']); // We don't need to select the base stylesheet.

  // Return the form
  return $form;
}
