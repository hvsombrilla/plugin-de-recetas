<?php
namespace SombrillaWP\Forms\Fields;

use SombrillaWP\Html;

class File extends Field implements ScriptField
{
    /**
     * Run on construction
     */
    protected function init()
    {
        $this->setType( 'file' );
    }

    /**
     * Get the scripts
     */
    public function enqueueScripts() {
        wp_enqueue_media();
    }

    /**
     * Covert File to HTML string
     */
    function getString()
    {
        // $this->attr['class'] = 'file-picker';
        $name = $this->getNameAttributeString();
        $this->appendStringToAttribute( 'class', ' file-picker' );
        $value = (int) $this->getValue() !== 0 ? $this->getValue() : null;
        $this->removeAttribute( 'name' );
        $generator = new Html\Generator();

        if ( ! $this->getSetting( 'button' )) {
            $this->setSetting( 'button', __('Insert File') );
        }

        if ( ! $this->getSetting( 'clear' )) {
            $this->setSetting( 'clear', 'Clear' );
        }

        if ($value != "") {
            $url  = wp_get_attachment_url( $value );
            $metadata = wp_get_attachment_metadata($value); 
            $file = '<div class="sombrillawp-field-file-placeholder"><img src="/wp-includes/images/media/default.png"><a target="_blank" href="' . $url . '">'. basename($metadata['file']).'</a> <span>'. $metadata['width'] . ' x ' . $metadata['height'] .'</span>';
        } else {
            $file = '';
        }

            


        $html = $generator->newInput( 'hidden', $name, $value, $this->getAttributes() )->getString();
        $html .= '<div class="button-group">';
        $html .= $generator->newElement( 'input', [
            'type'  => 'button',
            'class' => 'file-picker-button button',
            'value' => $this->getSetting( 'button' )
        ])->getString();
        $html .= $generator->newElement( 'input', [
            'type'  => 'button',
            'class' => 'file-picker-clear button',
            'value' => $this->getSetting( 'clear' )
        ])->getString();
        $html .= '</div>';
        $html .= $generator->newElement( 'div', [
            'class' => 'file-picker-placeholder'
        ], $file )->getString();

        return $html;
    }

}