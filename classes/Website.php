<?php
class Website
{
    public $default_language;
    public $language;
    public $entity;
    public $name;
    public $page;
    public $id;

    public $phrases;
    public $phrases_menu;
    public $meta;
    public $share;
    public $breadcrumbs;

    public $domain;

    public function __construct()
    {
        $this->default_language = 'az';

        $this->language = $this->default_language;
        if (isset($_GET['language'])) {
            $this->language = $_GET['language'];
        }

        $default_entity = 'home';
        $this->entity = $default_entity;
        if (isset($_GET['entity'])) {
            $this->entity = $_GET['entity'];
        }

        $default_page = 1;
        $this->page = $default_page;
        if (isset($_GET['page'])) {
            $this->page = (int)$_GET['page'];
        }

        $default_id = 1;
        $this->id = $default_id;
        if (isset($_GET['id'])) {
            $this->id = (int)$_GET['id'];
        }

        $this->domain = str_replace('www.', '', $_SERVER['SERVER_NAME']);

        $this->meta = [
            'title' => 'R-Keeper data',
            'description' => '',
            'url' => '/',
            'date' => time(),
            'author' => '',
            'image' => [
                'url' => '/logo.png',
                'type' => 'image/png',
                'width' => '64',
                'height' => '64'
            ],
            'video' => [],
            'embed' => false,
            'previous' => false,
            'next' => false
        ];

        $this->share = [
            'title' => 'Default website',
            'description' => '',
            'image' => '/logo.png',
        ];

        $this->breadcrumbs = [];

        $this->phrases = [];
    }

    public function set_phrases($rows)
    {
        foreach ($rows as $row) {
            $title = $row['title_' . $this->language];
            if (!$title) {
                $title = '';
            }
            $this->phrases[$row['name']] = $title;
        }
    }

    public function create_languages()
    {
        $languages = [
            'az' => 'Az',
            'en' => 'En',
            'ru' => 'Ru',
            //'tr' => 'Tr',
        ];


        $html = '';

        $html .= '<ul>';
        foreach ($languages as $language_key => $language_value) {
            if ($language_key != $this->language || 0) {
                $link = '/';
                if ($language_key != $this->default_language) {
                    $link = '/' . $language_key . '';
                }
                if ($_SERVER['REQUEST_URI'] !== '/') {
                    $link = str_replace('/' . $this->language . '', '/' . $language_key . '', $_SERVER['REQUEST_URI']);
                }

                $html .= '<li>';
                if ($language_key != 'none') {
                    $html .= '<a href="' . $link . '">';
                }
                $html .= '<div class="box">';
                //$html .= '<i class="flag flag-' . $language_key . '"></i>';
                //$html .= '<span class="flag-text">' . $language_value . '</span>';
                $html .= '<span>' . $language_value . '</span>';
                $html .= '</div>';
                if ($language_key != 'none') {
                    $html .= '</a>';
                }
                $html .= '</li>';
            }
        }
        $html .= '</ul>';

        return $html;
    }

    public function create_menu($parent_id, $menu)
    {
        $html = '';

        return $html;
    }
}
