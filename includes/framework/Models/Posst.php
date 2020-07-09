<?php
namespace SombrillaWP\Models;
use SombrillaWP\DB\Query;
use SombrillaWP\Exceptions\ModelException;
use SombrillaWP\Models\Meta\WPPostMeta;

class Post extends Model
{
    protected $idColumn = 'ID';
    protected $resource = 'posts';
    protected $postType = 'post';

    protected $builtin = [
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
        'post_password',
        'id'
    ];

    protected $guard = [
        'post_type',
        'id'
    ];

    

    /**
     * Posts Meta Fields
     *
     * @param bool $withPrivate
     *
     * @return null|\TypeRocket\Models\Model
     */
    public function meta( $withPrivate = false )
    {
        $meta = $this->hasMany( WPPostMeta::class, 'post_id' );

        if( ! $withPrivate ) {
            $meta->where('meta_key', 'NOT LIKE', '\_%');
        }

        return $meta;
    }

    /**
     * Author
     *
     * @return $this|null
     */
    public function author() {
        //return $this->belongsTo( get_current_user(), 'post_author' );
        return $this;
    }

    /**
     * Published
     *
     * @return $this
     */
    public function published()
    {
        return $this->where('post_status', 'publish');
    }

    /**
     * Status
     *
     * @param string $type
     *
     * @return $this
     */
    public function status($type)
    {
        return $this->where('post_status', $type);
    }

    /**
     * Get Post Type
     *
     * @return string
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * Return table name in constructor
     *
     * @param \wpdb $wpdb
     *
     * @return string
     */
    public function initTable( $wpdb )
    {
        return $wpdb->prefix . 'posts';
    }

    /**
     * Init Post Type
     *
     * @param Query $query
     *
     * @return Query
     */
    protected function initQuery( Query $query )
    {
        return $query->where('post_type', $this->getPostType());
    }

    /**
     * Find post by ID
     *
     * @param $id
     *
     * @return $this
     */
    public function findById($id) {
        
        $this->fetchResult(get_post( $id, ARRAY_A ));
        return $this;
    }

    /**
     * Create post from TypeRocket fields
     *
     * Set the post type property on extended model so they
     * are saved to the correct type. See the PagesModel
     * as example.
     *
     * @param array|\TypeRocket\Http\Fields $fields
     *
     * @return $this
     * @throws \TypeRocket\Exceptions\ModelException
     */
    public function create( $fields = [])
    {
        $fields = $this->provisionFields($fields);
        $builtin = $this->getFilteredBuiltinFields($fields);

        if ( ! empty( $builtin )) {
            $builtin = $this->slashBuiltinFields($builtin);
            remove_action('save_post', 'TypeRocket\Http\Responders\Hook::posts');

            if(!empty($this->postType)) {
                $builtin['post_type'] = $this->postType;
            }

            if( empty($builtin['post_title']) || empty($builtin['post_content']) ) {
                $error = 'WPPost not created: post_title and post_content are required';
                throw new ModelException( $error );
            }

            $post      = wp_insert_post( $builtin );
            add_action('save_post', 'TypeRocket\Http\Responders\Hook::posts');

            if ( $post instanceof \WP_Error || $post === 0 ) {
                $error = 'WPPost not created: An error accrued during wp_insert_post.';
                throw new ModelException( $error );
            } else {
                $this->findById($post);
            }
        }

        $this->saveMeta( $fields );

        return $this;
    }



    /**
     * Update post from TypeRocket fields
     *
     * @param array|\TypeRocket\Http\Fields $fields
     *
     * @return $this
     * @throws \TypeRocket\Exceptions\ModelException
     */
    public function update( $fields = [] )
    {



        $id = $this->getID();
        if( $id != null && ! wp_is_post_revision( $id ) ) {
            $fields = $this->provisionFields( $fields );
            $builtin = $this->getFilteredBuiltinFields($fields);

            if ( ! empty( $builtin ) ) {
                $builtin = $this->slashBuiltinFields($builtin);
                remove_action('save_post', 'TypeRocket\Http\Responders\Hook::posts');
                $builtin['ID'] = $id;
                $builtin['post_type'] = $this->properties['post_type'];
                $updated = wp_update_post( $builtin );
                add_action('save_post', 'TypeRocket\Http\Responders\Hook::posts');

                if ( $updated instanceof \WP_Error || $updated === 0 ) {
                    $error = 'WPPost not updated: post_name (slug), post_title and post_content are required';
                    throw new ModelException( $error );
                } else {
                    $this->findById($id);
                }

            }



            $this->saveMeta( $fields );

        } else {
            $this->errors = ['No item to update'];
        }

        return $this;
    }

    /**
     * Save post meta fields from TypeRocket fields
     *
     * @param array|\ArrayObject $fields
     *
     * @return $this
     */
    private function saveMeta( $fields )
    {


        $fields = $this->getFilteredMetaFields($fields);
        $id = $this->getID();
        if ( ! empty($fields) && ! empty( $id )) :
            if ($parent_id = wp_is_post_revision( $id )) {
                $id = $parent_id;
            }

            foreach ($fields as $key => $value) :
                if (is_string( $value )) {
                    $value = trim( $value );
                }

                $current_value = get_post_meta( $id, $key, true );

                if (( isset( $value ) && $value !== "" ) && $value !== $current_value) :
                    update_post_meta( $id, $key, wp_slash($value) );
                elseif ( ! isset( $value ) || $value === "" && ( isset( $current_value ) || $current_value === "" )) :
                    delete_post_meta( $id, $key );
                endif;

            endforeach;
        endif;

        return $this;
    }

    /**
     * Get base field value
     *
     * Some fields need to be saved as serialized arrays. Getting
     * the field by the base value is used by Fields to populate
     * their values.
     *
     * @param $field_name
     *
     * @return null
     */
    public function getBaseFieldValue( $field_name )
    {
        $id = $this->getID();
        if(in_array($field_name, $this->builtin)) {
            switch ($field_name) {
                case 'post_password' :
                    $data = '';
                    break;
                case 'id' :
                    $data = get_post_field( 'ID', $id, 'raw' );
                    break;
                default :
                    $data = get_post_field( $field_name, $id, 'raw' );
                    break;
            }
        } else {
            $data = get_metadata( 'post', $id, $field_name, true );
        }

        return $this->getValueOrNull($data);
    }
    
    private function getDotKeys( $str )
    {
        $matches = explode('.', $str);

        return $matches;
    }


        /**
     * Get value from database from typeRocket bracket syntax
     *
     * @param $field
     *
     * @return array|mixed|null|string
     */
    public function getFieldValue( $field )
    {

        $field = $field->getDots();



        if ($this->getID() == null && ! $this->old && empty($this->dataOverride) ) {
            return null;
        }



        $return = $this->getBaseFieldValue( $field );
       //$keys = $this->getDotKeys( $field );
       //

        return $return;

        // if( $this->old ) {
        //     if( ! empty($this->old[$keys[0]]) ) {
        //         $data = wp_unslash( $this->old[$keys[0]] );
        //     } else {
        //         $data = null;
        //     }
        // } elseif( !empty($this->dataOverride[$keys[0]]) ) {
        //     $data = $this->dataOverride[$keys[0]];
        // } elseif( !$this->onlyOld ) {

        //     $data = $this->getBaseFieldValue( $keys[0] );
        // } else {
        //     return null;
        // }

        // return $this->parseValueData( $data, $keys );

    }

    public function getBuiltinFields() {
        return $this->builtin;
    }

    public function slashBuiltinFields( $builtin ) {

        $fields = [
            'post_content',
            'post_excerpt',
            'post_title',
        ];

        foreach ($fields as $field) {
            if(!empty($builtin[$field])) {
                $builtin[$field] = wp_slash( $builtin[$field] );
            }
        }

        return $builtin;
    }
}
