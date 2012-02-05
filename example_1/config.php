<?php
$config = array(
  'page' => array(
    'layout'  => 'P',
    'coords'  => 'mm',
    'size'    => 'A4',
    'size_ln' => '210x297', // mm
    'fields'  => '7', // mm
    'grid_x'  => false,
    'grid_y'  => true,
  ),
  'fonts' => array(
    array(
      'name'  => 'GLOfficina',
      'file'  => 'glofficina.php',
      'style' => '',
    )
  ),
  'element' => array(
    'size_ln' => '190x54', // mm
  ),
  'areas' => array(
    array(
      // Font information
      'font' => 'GLOfficina', 'font_size' => 11,
      // Font color
      'color' => array(0, 0, 0),
      // Offset information
      'left' => 0, 'top' => 21, 'width' => 28, 'height' => 4.5,
      // Text
      'lines' => array( // Array of lines
        array('text' => '@1', 'explode' => ' - '),
        array('text' => '@2', 'format' => 'Ряд №%s'),
        array('text' => '@3', 'format' => 'Место №%s'),
        array('text' => '@4', 'format' => 'Цена: %s'),
      ),
    ),
    array(
      'font' => 'GLOfficina', 'font_size' => 8,
      'color' => array(157, 158, 158),
      'width' => 28, 'height' => 4.5,
      'lines' => array(
        array('text' => ' ', 'height' => 2),
        array('text' => 'Корешок билета'),
        array('text' => '@0', 'format' => 'серия АБ №%s'),
      ),
    ),
    array(
      'font' => 'GLOfficina', 'font_size' => 11,
      'color' => array(0, 0, 0),
      'left' => 37, 'top' => 29,
      'width' => 25, 'height' => 7,
      'lines' => array(
        array('text' => '@1', 'width' => 55),
        array('text' => '@2', 'format' => 'Ряд №%s', 'line' => 'this'),  // Continuing this line
        array('text' => '@3', 'format' => 'Место №%s'),
      ),
    ),
    array(
      'font' => 'GLOfficina', 'font_size' => 11,
      'color' => array(0, 0, 0),
      'left' => 37, 'top' => 43,
      'width' => 55, 'height' => 7,
      'lines' => array(
        array('text' => '@4', 'format' => 'Цена: %s'),
      ),
    ),
    array(
      'font' => 'GLOfficina', 'font_size' => 11,
      'color' => array(0, 0, 0),
      'left' => 138.5, 'top' => 29,
      'width' => 28, 'height' => 7,
      'lines' => array(
        array('text' => '@0', 'format' => 'серия АБ №%s'),
      ),
    ),
  ),
);