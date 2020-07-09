<?php
namespace SombrillaWP\Forms\Fields;

use SombrillaWP\Forms\Traits\DefaultSetting;
use SombrillaWP\Forms\Traits\OptionsTrait;
use SombrillaWP\Html\Generator;


class Checkbox extends Field
{
    use OptionsTrait, DefaultSetting;

    /**
     * Run on construction
     */
    protected function init()
    {
        $this->setType( 'checkbox' );
    }

    /**
     * Covert Checkbox to HTML string
     */
    public function getString()
    {
        $name   = $this->getNameAttributeString();
        $this->removeAttribute( 'name' );
        $default = 0;

        if( $this->getAttribute('multiple') ) {
            $name = $name . '[]';
        }

        $option = $this->getValue();
        $checkbox = new Generator();
        $field = new Generator();

        if ($option == '1') { // || ! is_null($option) && $option == $this->getAttribute('value')
            $this->setAttribute( 'checked', 'checked' );
        } elseif($default === true && is_null($option)) {
            $this->setAttribute( 'checked', 'checked' );
        }

        $isassoc = (array_values($this->options) === $this->options) ? false : true;

        $html = '';
        foreach($this->options as $key => $value) {

            $valor = ($isassoc) ? $key : $value;
            $checkbox->newInput( 'checkbox', $name, $valor, $this->getAttributes() );

            $field->newElement( 'label' )
            ->appendInside( $checkbox )
            ->appendInside( 'span', [], $value );
            $html .= $field->getString();

        }

        return $html;
    }

    /**
     * Add text description next to checkbox
     *
     * @param string $text
     *
     * @return $this
     */
    public function setText( $text = '' ) {
        $this->setSetting('text', $text);

        return $this;
    }

    public function multiple()
    {
        return $this->setAttribute('multiple', 'multiple');
    }

}