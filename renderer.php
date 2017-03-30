<?php

/**
 * Renderers for component 'local_tematica'.
 *
 * @package   local_tematica
 * @copyright 2017 Michael Meneses  {@link http://michaelmeneses.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/lib.php');

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
        $content .= $this->list_tags();
        return html_writer::tag('div',$content, ['class' => 'tematic_content']);
    }

    function list_tags()
    {
        $output = '';
        $output .= html_writer::start_div('tematic-list-tags');
        $output .= html_writer::tag('h3', get_string('list_tags', 'local_tematica'));
        $tags = getTags();
        if ($tags) {
            $output .= html_writer::start_tag('ul', ['class' => 'tematic-tags']);
            foreach ($tags as $tag) {
                $output .= html_writer::start_tag('li', ['class' => 'tematic-tag']);
                if ($tag->description) {
                    $output .= file_rewrite_pluginfile_urls($tag->description, 'pluginfile.php', context_system::instance()->id, 'tag', 'description', $tag->id);
                }
                $name = html_writer::tag('h4', $tag->rawname);
                $output .= html_writer::link(new moodle_url('/local/tematica/index.php', ['id' => $tag->id]), $name);
                $output .= html_writer::end_tag('li');
            }
            $output .= html_writer::end_tag('ul');
        }
        $output .= html_writer::end_div();
        return $output;
    }
}
