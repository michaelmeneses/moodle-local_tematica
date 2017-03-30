<?php

/**
 * Functions for component 'local_tematica'.
 *
 * @package   local_tematica
 * @copyright 2017 Michael Meneses  {@link http://michaelmeneses.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

define("PLUGINNAME", "TEMATICA");

/**
 * Return Tags from colletion PLUGINNAME
 */
function getTags(){
    global $DB;

    $collection = $DB->get_record('tag_coll',['name' => PLUGINNAME]);
    if (!$collection->id) {
        throw new moodle_exception('pluginname', 'local_tematica');
    }
    $tags = $DB->get_records('tag', ['tagcollid' => $collection->id]);
    return $tags;
}
