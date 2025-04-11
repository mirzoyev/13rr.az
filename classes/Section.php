<?php

class Section
{
    protected $name = '';

    public $title = '';
    public $description = '';

    public $text = true;
    public $container = true;
    public $space_top = true;
    public $space_bottom = true;
    public $space_left = false;
    public $space_right = false;

    //css class for single page padding
    public $single = false;

    public $anchor = false;
    public $image = false;
    public $light = false;

    public function __construct($name = '', $title = '', $description = '')
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
    }

    public function create_section($content = '')
    {
        $content = str_replace('<p><br></p>', '<hr>', $content);

        $section_classes = [$this->name];
        $section_classes[] = 'section';

        $section_classes[] = 'background';
        if ($this->name) {
            $section_classes[] = 'background-' . $this->name;
        }
        if ($this->text) {
            $section_classes[] = 'text';
        }

        if ($this->single) {
            $section_classes[] = 'section-single';
        }

        $space_classes = ['space'];
        if ($this->space_top) {
            $space_classes[] = 'space-top';
        }
        if ($this->space_bottom) {
            $space_classes[] = 'space-bottom';
        }
        if ($this->space_left) {
            $space_classes[] = 'space-left';
        }
        if ($this->space_right) {
            $space_classes[] = 'space-right';
        }

        $container_class = 'container_';
        if ($this->container) {
            $container_class = 'container';
        }


        $html = '';

        $html .= '<div';
        if ($this->name) {
            $html .= ' id="' . $this->name . '"';
        }
        $html .= ' class="' . implode(' ', $section_classes) . '">';

        $html .= '<div class="' . $container_class . '">';

        if ($this->image) {
            $html .= '<div class="headline">';
            $html .= '<div class="image" style="background-image: url(' . $this->image . ')"></div>';
            $html .= '</div>';
        }

        $html .= '<div class="' . implode(' ', $space_classes) . '">';

        if ($this->title || $content) {
            if ($this->title) {
                $html .= '<div class="align-center_">';

                $html .= '<h2 class="title">' . $this->title . '</h2>';

                $html .= '<div class="line"></div>';
                $html .= '<div class="gap gap-2"></div>';
                $html .= '<div class="gap gap-2"></div>';

                if ($this->description) {
                    $html .= '<div class="description">' . $this->description . '</div>';
                }

                $html .= '</div>';
            }

            $html .= $content;
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
