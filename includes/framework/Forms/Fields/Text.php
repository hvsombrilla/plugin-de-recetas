<?php
namespace SombrillaWP\Forms\Fields;

use SombrillaWP\Forms\Traits\DefaultSetting;
use SombrillaWP\Html\Generator;
use SombrillaWP\Forms\Traits\MaxlengthTrait;

class Text extends Field
{
    use MaxlengthTrait, DefaultSetting;

    /**
     * Run on construction
     */
    protected function init()
    {
        $this->setType( 'text' );
    }

    /**
     * Covert Test to HTML string
     */
    public function getString()
    {
        $input = new Generator();
        $name = $this->getNameAttributeString();
        $value = $this->getValue();
        $default = $this->getDefault();
        $value = !empty($value) ? $value : $default;
        $value = $this->sanitize($value, 'raw');
        $max = $this->getMaxlength( $value, $this->getAttribute('maxlength'));

        return $input->newInput($this->getType(), $name, esc_attr($value), $this->getAttributes() )->getString() . $max;
    }

}