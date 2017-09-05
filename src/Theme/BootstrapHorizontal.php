<?php

namespace Rutorika\Html\Theme;

use Illuminate\Support\Collection;
use Rutorika\Html\FormBuilder;

class BootstrapHorizontal extends BootstrapAbstract implements Themable
{
    /**
     * @var FormBuilder
     */
    protected $builder;

    protected $reserved = ['label-width', 'control-width'];

    protected $labelWidth;
    protected $controlWidth;

    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function updateOptions($options = [])
    {
        $this->labelWidth = array_get($options, 'label-width', 3);
        $this->controlWidth = array_get($options, 'label-width', 12 - $this->labelWidth);

        $currentClass = array_get($options, 'class', '');
        $options['class'] = trim($currentClass . ' form-horizontal');

        return array_except($options, $this->reserved);
    }

    /**
     * @inheritdoc
     */
    public function field($title, $name, $control = '', $errors = null, $help = '')
    {
        $template = '
            <div class="form-group %s">
              %s
              <div class="%s">
                %s
                %s
                %s
              </div>
            </div>
        ';

        $formClass = !empty($errors) && $errors->has($name) ? 'has-error' : '';
        $labelClass = "col-md-{$this->labelWidth} control-label";

        if (!is_null($title)) {
            $label = $this->builder->label($name, $title);
        } else {
            $label = '<div class="' . $labelClass . '"></div>';
        }

        $controlClass = "";
        $error = empty($errors) ? '' : $errors->first($name, '<p class="help-block">:message</p>');
        $help = empty($help) ? '' : '<p class="help-block">' . $help . '</p>';

        return sprintf($template, $formClass, $label, $controlClass, $control, $error, $help);
    }
}
