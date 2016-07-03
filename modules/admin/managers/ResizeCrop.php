<?php

namespace app\modules\admin\managers;

Class ResizeCrop {

    function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
        list($w_i, $h_i, $type) = getimagesize($file_input);
        if (!$w_i || !$h_i) {
            echo '���������� �������� ����� � ������ �����������';
            return;
        }
        $types = array('', 'gif', 'jpeg', 'png');
        $ext = $types[$type];
        if ($ext) {
            $func = 'imagecreatefrom' . $ext;
            $img = $func($file_input);
        } else {
            echo '������������ ������ �����';
            return;
        }
        if ($percent) {
            $w_o *= $w_i / 100;
            $h_o *= $h_i / 100;
        }
        if (!$h_o)
            $h_o = round($w_o / ($w_i / $h_i));
        if (!$w_o)
            $w_o = round($h_o / ($h_i / $w_i));
        if ($type == 3) {
            $img_o = imagecreatetruecolor($w_o, $h_o);
            $white = imagecolorallocate($img_o, 255, 255, 255);
            imagefilledrectangle($img_o, 0, 0, imagesx($img_o), imagesy($img_o), $white);
            for ($i = 0; $i < 256; $i = $i + 10) {
                $col = imagecolorallocatealpha($img_o, $i, $i, $i, ceil(rand(0, 127)));
            }
                imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
        } else {
            $img_o = imagecreatetruecolor($w_o, $h_o);
            $white = imagecolorallocate($img_o, 255, 255, 255);
           imagefilledrectangle($img_o, 0, 0, imagesx($img_o), imagesy($img_o), $white);
            for ($i = 0; $i < 256; $i = $i + 10) {
                $col = imagecolorallocatealpha($img_o, $i, $i, $i, ceil(rand(0, 127)));
            }
            imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
        }
             header("content-type: image/".$ext);
            if ($type == 2) {
                return imagejpeg($img_o, $file_output, 100);
            } else {
                $func = 'image' . $ext;
                return $func($img_o, $file_output);
            }
  
    }

    function crop($file_input, $file_output, $crop = 'square', $percent = false) {
        list($w_i, $h_i, $type) = getimagesize($file_input);
        if (!$w_i || !$h_i) {
            echo '���������� �������� ����� � ������ �����������';
            return;
        }
        $types = array('', 'gif', 'jpeg', 'png');
        $ext = $types[$type];
        if ($ext) {
            $func = 'imagecreatefrom' . $ext;
            $img = $func($file_input);
        } else {
            echo '������������ ������ �����';
            return;
        }
        if ($crop == 'square') {
            $min = $w_i;
            if ($w_i > $h_i)
                $min = $h_i;
            $w_o = $h_o = $min;
        } else {
            list($x_o, $y_o, $w_o, $h_o) = $crop;
            if ($percent) {
                $w_o *= $w_i / 100;
                $h_o *= $h_i / 100;
                $x_o *= $w_i / 100;
                $y_o *= $h_i / 100;
            }
            if ($w_o < 0)
                $w_o += $w_i;
            $w_o -= $x_o;
            if ($h_o < 0)
                $h_o += $h_i;
            $h_o -= $y_o;
        }
        $img_o = imagecreatetruecolor($w_o, $h_o);
        imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
        if ($type == 2) {
            return imagejpeg($img_o, $file_output, 100);
        } else {
            $func = 'image' . $ext;
            return $func($img_o, $file_output);
        }
    }

}

?>
