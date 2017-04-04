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
    public $course;
    public $tag;

    function print_header($course = null, $tag = null)
    {
        if (!is_null($course)) {
            $this->course = $course;
        }
        if (!is_null($tag)) {
            $this->tag = $tag;
        }
        $output = '';
        $output .= html_writer::tag('h1',get_string('pluginname', 'local_tematica'), ['class' => 'tematic-pagename']);
        if ($this->course) {
            $output .= html_writer::tag('h3', $this->course->fullname, ['class' => 'tematic-coursename']);
        }
        if ($this->tag) {
            $output .= html_writer::start_div('tematic-tag');
            $output .= file_rewrite_pluginfile_urls($this->tag->description, 'pluginfile.php', context_system::instance()->id, 'tag', 'description', $this->tag->id);
            $output .= html_writer::tag('h3', $this->tag->rawname);
            $output .= html_writer::end_div();
        }
        return html_writer::tag('div', $output, ['class' => 'tematic-header clearfix']);
    }

    function content()
    {
        $content = '';
        if ($this->tag) {
            $content .= $this->list_resources();
        } else {
            $content .= $this->list_tags();
        }
        return html_writer::tag('div',$content, ['class' => 'tematic-content']);
    }

    function list_tags()
    {
        $output = '';
        $output .= html_writer::start_div('tematic-list-tags');
        $output .= html_writer::tag('h3', get_string('list_tags', 'local_tematica'));
        $tags = get_tags();
        if ($tags) {
            $output .= html_writer::start_tag('ul', ['class' => 'tematic-tags']);
            foreach ($tags as $tag) {
                $output .= html_writer::start_tag('li', ['class' => 'tematic-tag']);
                if ($tag->description) {
                    $output .= file_rewrite_pluginfile_urls($tag->description, 'pluginfile.php', context_system::instance()->id, 'tag', 'description', $tag->id);
                }
                $name = html_writer::tag('h4', $tag->rawname);
                $params['id'] = $tag->id;
                if ($this->course) {
                    $params['courseid'] = $this->course->id;
                }
                $output .= html_writer::link(new moodle_url('/local/tematica/index.php', $params), $name);
                $output .= html_writer::end_tag('li');
            }
            $output .= html_writer::end_tag('ul');
        }
        $output .= html_writer::end_div();
        return $output;
    }

    function list_resources()
    {
        global $OUTPUT;

        $output = '';
        $output .= html_writer::start_div('tematic-list-resources');
        $result = get_tag_resources($this->tag, $this->course);
        if (empty($result)) {
            $output .= html_writer::tag('p', get_string('noresource', 'local_tematica'));
        } else {
            if ($this->course) {
                foreach ($result as $key => $cms) {
                    $sectionname = get_sectionname($this->course, $key);
                    $output .= html_writer::tag('h4', $sectionname, ['class' => 'tag_feed media-list']);
                    $output .= html_writer::start_tag('ul', ['class' => 'tag_feed media-list']);
                    foreach ($cms as $cm) {
                        $output .= html_writer::start_tag('li', ['class' => 'media']);
                        $output .= html_writer::start_div('itemimage');
                        $output .= html_writer::empty_tag('img', array('src' => $cm->get_icon_url()));
                        $output .= html_writer::end_div();
                        $output .= html_writer::start_div('media-body');
                        $link = html_writer::link($cm->url, $cm->name);
                        $output .= html_writer::div($link, 'media-heading');
                        $output .= html_writer::div('&nbsp;', 'muted');
                        $output .= html_writer::end_div();
                        $output .= html_writer::end_tag('li');
                    }
                    $output .= html_writer::end_tag('ul');
                }
            } else {
                $output .= $result->content;
            }
        }

        $params = array();
        if ($this->course) {
            $params['courseid'] = $this->course->id;
        }
        $output .= html_writer::link(new moodle_url('/local/tematica/index.php', $params), get_string('back'), ['class' => 'btn btn-primary']);
        $output .= html_writer::end_div();
        return $output;
    }
}
