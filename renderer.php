<?php

/**
 * Renderers for component 'local_tematica'.
 *
 * @package   local_tematica
 * @copyright 2017 Michael Meneses  {@link http://michaelmeneses.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_tematica_renderer extends plugin_renderer_base
{
    function print_header($course = null)
    {
        $output = '';
        $output .= html_writer::tag('h1',get_string('pluginname', 'local_tematica'));
        if ($course) {
            $output .= html_writer::tag('h3', $course->fullname);
        }
        return html_writer::tag('div', $output, ['class' => 'tematic_header']);
    }

    function content()
    {
        $content = '';
        return html_writer::tag('div',$content, ['class' => 'tematic_content']);
    }
}
