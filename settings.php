<?php

/**
 * Settings for component 'local_tematica'.
 *
 * @package   local_tematica
 * @copyright 2017 Michael Meneses  {@link http://michaelmeneses.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if (is_siteadmin()) {
    $settings = new admin_settingpage('local_tematica', get_string('pluginname', 'local_tematica'));
    $ADMIN->add('localplugins', $settings);
}
