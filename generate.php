<?php
require_once('./fpdf/fpdf.php');

echo "  >>  nekoTickets 1.0rc1 by druidvav  << \n";
echo "\n";

$opts = getopt('', array('directory:', 'test'));

if(empty($opts['directory']))
{
  echo "Usage: php generate.php --directory=dir\n\n";
  exit;
}
elseif(!is_file($opts['directory'] . '/config.php'))
{
  echo "Invalid directory\n\n";
  exit;
}

require_once($opts['directory'] . '/config.php');

$pdf = new FPDF($config['page']['layout'], $config['page']['coords'], $config['page']['size']);
foreach($config['fonts'] as $font)
{
  $pdf->AddFont($font['name'], @$font['style'], $font['file']);
}

// Counting page layout
$page    = explode('x', $config['page']['size_ln']);
$element = explode('x', $config['element']['size_ln']);
$field_x = $config['page']['fields'];
$field_y = $config['page']['fields'];

$layout = array();
for($x = $field_x; $x <= $page[0] - $field_x - $element[0]; $x += $element[0])
{
  for($y = $field_y; $y <= $page[1] - $field_y - $element[1]; $y += $element[1])
  {
    $layout[] = array(
      'x' => $x,
      'y' => $y,
      'w' => $element[0],
      'h' => $element[1],
    );
  }
}

// Reading database
$count = 0;
$fp = fopen($opts['directory'] . '/database.csv', 'r');
while($string = fgets($fp))
{
  $row = explode(';', str_replace(array("\r", "\n"), '', $string));
  $position = $count % sizeof($layout);

  if($position == 0)
  {
    $pdf->AddPage();
  }

  $left = $layout[$position]['x'];
  $top = $layout[$position]['y'];

  if(empty($config['element']['background']))
  {
    $file = 'template.png';
  }
  elseif($config['element']['background']{0} == '@')
  {
    $file = $row[substr($config['element']['background'], 1)];
  }
  else
  {
    $file = $config['element']['background'];
  }

  if(is_file($opts['directory'] . '/' . $file))
  {
    $pdf->Image($opts['directory'] . '/' . $file, $left, $top, $layout[$position]['w']);
  }

  foreach($config['areas'] as $area)
  {
    if(!empty($area['font']))
    {
      $pdf->SetFont($area['font'], '', $area['font_size']);
    }

    if(!empty($area['color']))
    {
      $pdf->SetTextColor($area['color'][0], $area['color'][1], $area['color'][2]);
    }

    if(isset($area['left']))
    {
      $pdf->SetXY($left + $area['left'], $top + $area['top']);
    }

    // Preparing lines
    $lines = array();
    foreach($area['lines'] as $line)
    {
      if(empty($line['text']))
      {
        continue;
      }

      if($line['text']{0} == '@')
      {
        $line['text'] = $row[substr($line['text'], 1)];
      }

      if(!empty($line['format']))
      {
        $line['text'] = sprintf($line['format'], $line['text']);
      }

      $line['text'] = iconv('utf-8', 'windows-1251', $line['text']);

      if(!empty($line['explode']))
      {
        foreach(explode($line['explode'], $line['text']) as $text)
        {
          $line['text'] = $text;
          $lines[] = $line;
        }
      }
      else
      {
        $lines[] = $line;
      }
    }

    // Writing lines
    foreach($lines as $line)
    {
      $pdf->Cell(
        @$line['width'] ? $line['width'] : $area['width'],
        @$line['height'] ? $line['height'] : $area['height'],
        $line['text'],
        0, // TODO border
        (@$line['line'] == 'this' ? 0 : 2),
        'L' // TODO align
      );
    }

    $area = $layout[$position];

    $pdf->SetLineWidth(0.2);
    $pdf->SetDrawColor(200);
    if(!empty($config['page']['grid_y']))
    {
      $pdf->Line(0, $area['y'] - 0.1, 500, $area['y'] - 0.1);
      $pdf->Line(0, $area['y'] + $area['h'] - 0.1, 500, $area['y'] + $area['h'] - 0.1);
    }

    if(!empty($config['page']['grid_x']))
    {
      $pdf->Line($area['x'] - 0.1, 0, $area['x'] - 0.1, 500);
      $pdf->Line($area['x'] + $area['w'] - 0.1, 0, $area['x'] + $area['w'] - 0.1, 500);
    }
  }

  $count++;
}
fclose($fp);

$file = $opts['directory'] . '/output' . (isset($opts['test']) ? '.test' : '') . '.pdf';

@unlink($file);
$pdf->Output($file, 'F');

echo "File: $file\n";
echo "Complete!\n";