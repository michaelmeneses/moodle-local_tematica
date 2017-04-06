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
function get_tags(){
    global $DB;

    $collection = $DB->get_record('tag_coll',['name' => PLUGINNAME]);
    if (!$collection->id) {
        throw new moodle_exception('pluginname', 'local_tematica');
    }
    $tags = $DB->get_records('tag', ['tagcollid' => $collection->id]);
    return $tags;
}

/**
 * Return Resources from Tag
 */
function get_tag_resources($tag, $course = null) {
    global $DB, $OUTPUT;

    $resources = array();
    if ($course) {
        $modinfo = get_fast_modinfo($course);
        $sql = "SELECT cm.id as cmid, cm.section as sectionid, cs.name as sectionname
                FROM mdl_tag_instance tagi
                JOIN mdl_course_modules cm ON cm.id = tagi.itemid
                JOIN mdl_course_sections cs ON cs.id = cm.section
                WHERE tagi.itemtype like 'course_modules' AND cm.course = $course->id AND tagi.tagid = $tag->id AND cm.visible = 1
                ORDER BY cm.section";
        $items = $DB->get_recordset_sql($sql);

        foreach ($items as $item) {
            $resources[$item->sectionid][] = $modinfo->get_cm($item->cmid);
        }

        return $resources;
    } else {
        $items = course_get_tagged_course_modules($tag);
        $resources = $items;
    }

    return $resources;
}

/**
 * Return sectionname
 */
function get_sectionname($course, $sectionid) {
    global $DB;

    $format = course_get_format($course);
    $section = $DB->get_record('course_sections', array('id' => $sectionid));
    $sectionname = $format->get_section_name($section);

    return $sectionname;
}
