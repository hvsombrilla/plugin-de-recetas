<?php
namespace SombrillaWP\Forms\Fields;

use SombrillaWP\Forms\Traits\DefaultSetting;
use SombrillaWP\Html\Generator;
use SombrillaWP\Forms\Traits\MaxlengthTrait;

class Button extends Field
{
    use MaxlengthTrait, DefaultSetting;

    /**
     * Run on construction
     */
    protected function init()
    {
      //  $this->setType( 'textarea' );
    }

    /**
     * Get the scripts
     */
    public function enqueueScripts()
    {
        wp_enqueue_code_editor( array( 'type' => 'application/x-httpd-php' ) );
       // wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '/code-editor.js', array( 'jquery' ), '', true );
    }

    /**
     * Covert Textarea to HTML string
     */
    public function getString()
    {
        $generator = new Generator();
        $this->setAttribute('name', $this->getNameAttributeString());
        //$this->setLabel('');

        return $generator->newElement( 'button', $this->getAttributes(), $this->getLabel() )->getString();
    }

}