<?php
namespace SombrillaWP\Forms\Fields;

use SombrillaWP\Forms\Traits\DefaultSetting;
use SombrillaWP\Html\Generator;

class Date extends Field implements ScriptField
{
    use DefaultSetting;

    /**
     * Run on construction
     */
    protected function init()
    {
        $this->setType( 'date' );
    }

    /**
     * Get the scripts
     */
    public function enqueueScripts() {
       // wp_enqueue_script( 'jquery-ui-datepicker', ['jquery'], '1.0', true );
    }

    /**
     * Covert Date to HTML string
     */
    public function getString()
    {
        $name  = $this->getNameAttributeString();
        $this->removeAttribute( 'name' );
        $value = $this->getValue();
        $default = $this->getDefault();
        $value = !empty($value) ? date('Y-m-d', $value) : $default;

        $value = esc_attr( $this->sanitize($value, 'raw') );

        //$this->appendStringToAttribute( 'class', ' date-picker' );
        $input = new Generator();

        return $input->newInput( 'date', $name, $value, $this->getAttributes() )->getString();
    }

}
