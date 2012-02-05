<?php
$config = array(
  'page' => array(
    'layout'  => 'P',
    'coords'  => 'mm',
    'size'    => 'A4',
    'size_ln' => '210x297', // mm
    'fields'  => '7', // mm
    'grid_x'  => true,
    'grid_y'  => true,
  ),
  'fonts' => array(
    array(
      'name'  => 'GLVerdana',
      'file'  => 'glverdana.php',
      'style' => '',
    )
  ),
  'element' => array(
    'size_ln' => '95x68', // mm
    'background' => '@2',
  ),
  'areas' => array(
    array(
      'font' => 'GLVerdana', 'font_size' => 24,
      'color' => array(0, 0, 0),
      'left' => 4, 'top' => 6,
      'width' => 60, 'height' => 8,
      'lines' => array( // Array of lines
        array('text' => '@0', 'explode' => '\\'),
      ),
    ),
    array(
      'font' => 'GLVerdana', 'font_size' => 20,
      'color' => array(255, 255, 255),
      'left' => 5, 'top' => 23,
      'width' => 60, 'height' => 7,
      'lines' => array( // Array of lines
        array('text' => '@1'),
      ),
    ),
  ),
);