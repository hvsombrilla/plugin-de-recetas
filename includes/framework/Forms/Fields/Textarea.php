<?php
namespace SombrillaWP\Forms\Fields;

use SombrillaWP\Forms\Traits\DefaultSetting;
use SombrillaWP\Html\Generator;
use SombrillaWP\Forms\Traits\MaxlengthTrait;

class Textarea extends Field implements ScriptField
{
    use MaxlengthTrait, DefaultSetting;

    /**
     * Run on construction
     */
    protected function init()
    {
        $this->setType( 'textarea' );
    }

    /**
     * Get the scripts
     */
    public function enqueueScripts()
    {
       // wp_enqueue_code_editor( array( 'type' => 'application/x-httpd-php' ) );
       // wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/code-editor.js', array( 'jquery' ), '', true );
    }

    /**
     * Covert Textarea to HTML string
     */
    public function getString()
    {
        $generator = new Generator();
        $this->setAttribute('name', $this->getNameAttributeString());
        //$this->setAttribute('class', 'code_editor');
        $value = $this->getValue();
        $default = $this->getDefault();
        $value = !empty($value) ? $value : $default;
        $value = $this->sanitize($value, 'textarea');
        $max = $this->getMaxlength( $value,  $this->getAttribute('maxlength'));

        return $generator->newElement( 'textarea', $this->getAttributes(), $value )->getString() . $max;
    }

}