<?php
$files = [
    //'date' => [''],
    'data' => [''],
    'tables' => ['']
];

foreach ($files as $file => $options) {
    $filename = $file;
    //$filename = $filename . '_' . $website->language;

    ob_start();
    /** @noinspection PhpIncludeInspection */
    include 'templates/articles/' . $filename . '.html';
    $template = ob_get_clean();

    if ($options) {
        $section = new Section($file);
        foreach ($options as $option_key => $option_value) {
            $section->$option_key = $option_value;
            $section->text = false;
            //$section->single = true;
        }
        $sections[$file] = $section->create_section($template);
    } else {
        $sections[$file] = $template;
    }
}

//$html['main'] .= $sections['date'];
$html['main'] .= $sections['data'];
$html['main'] .= $sections['tables'];
