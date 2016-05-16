<?php
/**
 * Created by PhpStorm.
 * User: Dan Verständig
 * Date: 28.11.2015
 * Time: 19:19
 */

namespace Helpers;

class MyFormElements extends Form
{

    public static function drawWrapper($params = array(), $type = 'input', $width = 8)
    {
        $error = '';
        if (isset($params['error']) && $params['error'] == true) {
            $error = 'has-error';
        } elseif ((isset($_POST) && sizeof($_POST) > 0) && (isset($params['error']) && $params['error'] == false)) {
            $error = 'has-success';
        }

        $o = "\n" . '<div class="form-group ' . $error . '">';
        $o .= "\n\t" . '<label for="' . $params['id'] . '" class="col-sm-2 control-label">' . $params['title'] . '</label>';

        $o .= "\n\t" . '<div class="col-sm-' . $width . '">' . "\n";


        if (isset($params['class'])) {
            $params['class'] .= ' form-control';
        } else {
            $params['class'] = 'form-control';
        }

        switch ($type) {
            case 'input':
                $o .= "\t\t" . Form::input($params);
                break;
            case 'select':
                $o .= "\t\t" . Form::select($params);
                break;
            case 'checkbox':
                $o .= "\t\t" . Form::checkbox($params);
                break;
            case 'textarea':
                $o .= "\t\t" . Form::textBox($params);
                break;
        }
        $o .= "\t" . '</div>';
        $o .= "\n" . '</div>';
        return $o;
    }
}