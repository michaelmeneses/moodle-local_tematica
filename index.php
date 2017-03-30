<?php

/**
 * Component 'local_tematica'.
 *
 * @package   local_tematica
 * @copyright 2017 Michael Meneses  {@link http://michaelmeneses.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$courseid = optional_param('courseid', 0, PARAM_INT);

if ($courseid) {
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $context = context_course::instance($course->id, MUST_EXIST);
    require_login($course);
    $PAGE->set_pagelayout('incourse');
} else {
    $course = null;
    $context = context_system::instance();
    $PAGE->set_pagelayout('standard');
}

$PAGE->set_context($context);
$PAGE->set_heading(get_string('pluginname', 'local_tematica'));
$PAGE->set_title(get_string('pluginname', 'local_tematica'));
$PAGE->set_url('/local/tematica/index.php');
$PAGE->requires->css('/local/tematica/style.css');

$output = $PAGE->get_renderer('local_tematica');

echo $OUTPUT->header();

echo $output->print_header($course);
echo $output->content();

echo $OUTPUT->footer();
