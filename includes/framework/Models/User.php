<?php
namespace SombrillaWP\Models;

class User extends Model
{

    protected $idColumn = 'option_id';
    protected $resource = 'options';

    public function init(){

        if (isset($_REQUEST['swp'])) {
            $this->update($_REQUEST['swp']);
        }
        return $this;
    }

    /**
     * Do nothing since options are not true resources
     *
     * @param $id
     *
     * @return $this
     */
    public function findById( $id ) {
        return $this;
    }



    /**
     * Create options from TypeRocket fields
     *
     * @param array|\TypeRocket\Http\Fields $fields
     *
     * @return $this
     */
    public function create( $fields = [] )
    {
        $fields = $this->provisionFields( $fields );
        $this->saveOptions( $fields );

        return $this;
    }

    /**
     * Update options from TypeRocket fields
     *
     * @param array|\TypeRocket\Http\Fields $fields
     *
     * @return $this
     */
    public function update( $fields = [] )
    {


        $fields = $this->provisionFields( $fields );
        $this->saveUserMeta( $fields );

        return $this;
    }

    /**
     * Save options' fields from TypeRocket fields
     *
     * @param array|\ArrayObject $fields
     *
     * @return $this
     */
    private function saveUserMeta( $fields )
    {
        if ( ! empty( $fields )) {

            $term_id = $this->getID();
            foreach ($fields as $key => $value) :

                if (is_string( $value )) {
                    $value = trim( $value );
                }

                $current_meta = get_term_meta($term_id, $key, true);

                if (( isset( $value ) && $value !== "" ) && $current_meta !== $value) :
                    update_user_meta($term_id, $key, $value, $current_meta);
                elseif ( ! isset( $value ) || $value === "" && ( isset( $current_meta ) || $current_meta=== "" )) :
                    delete_user_meta($term_id, $key, $value, $current_meta);
                endif;

            endforeach;
        }

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
        $data = get_user_meta( $this->getID(), $field_name, true );
        return $this->getValueOrNull($data);
    }

    /**
     * Get ID as TRUE
     *
     * Always get the ID as true since wp_options is more
     * of a central store
     *
     * @return int
     */
    public function getID() {
        return $_GET['user_id'];
    }
}