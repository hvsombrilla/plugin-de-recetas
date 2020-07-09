<?php
namespace SombrillaWP\Resources;

use SombrillaWP\Utility\Sanitize;

class MetaBox
{
    private $label = null;
    private $callback = null;
    private $context = null;
    private $priority = null;
    private $screens = [];


    public function __construct($name, $screen = null, array $settings = [])
    {
        $this->label = $this->id = $name;
        $this->id    = Sanitize::underscore($this->id);

        if (!empty($screen)) {
            $screen        = (array) $screen;
            $this->screens = array_merge($this->screens, $screen);
        }

        if (!empty($settings['callback'])) {
            $this->callback = $settings['callback'];
        }
        if (!empty($settings['label'])) {
            $this->label = $settings['label'];
        }

        unset($settings['label']);

        $defaults = [
            'context'  => 'normal', // 'normal', 'advanced', or 'side'
            'priority' => 'high', // 'high', 'core', 'default' or 'low'
            'args'     => [],
        ]; // arguments to pass into your callback function.

        $settings = array_merge($defaults, $settings);

        $this->context  = $settings['context'];
        $this->priority = $settings['priority'];
        $this->args     = $settings['args'];

        add_action('add_meta_boxes', function(){
            $this->register();
        });
    }

    public function addScreen( $screen )
    {
        $this->screens = array_merge( $this->screens, (array) $screen );

        return $this;
    }

    public function setCallback( $callback )
    {

        if (is_callable( $callback )) {
            $this->callback = $callback;
        } else {
            $this->callback = null;
        }

        return $this;
    }

    public function register(){
                add_meta_box(
                    $this->id,
                    $this->label,
                    $this->$callback,
                    $this->$screen,
                    $this->context,
                    $this->priority
                );
    }
}
