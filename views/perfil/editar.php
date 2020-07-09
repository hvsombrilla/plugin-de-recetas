<?php
            if (is_user_logged_in()) {

                global $current_user, $wp_roles;

                //get_currentuserinfo(); //deprecated since 3.1

                /* Load the registration file. */
                //require_once( ABSPATH . WPINC . '/registration.php' ); //deprecated since 3.1
                $error = array();
                /* If profile was saved, update profile. */
                if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'update-user') {

                    /* Update user password. */
                    if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {

                        $user = get_user_by('id', get_current_user_id());
                        if ($user && wp_check_password($_POST['oldpass'], $user->data->user_pass, $user->ID)) {
                            if ($_POST['pass1'] == $_POST['pass2']) {
                                wp_update_user(array('ID' => get_current_user_id(), 'user_pass' => esc_attr($_POST['pass1'])));
                            } else {
                                $error[] = __('Las contrase&ntilde;as introducidas no coinciden. La contraseña no ha sido actualizada.');
                            }
                        } else {
                            $error[] = __('Las contrase&ntilde;as introducida como "Contraseña actual" es incorrecta. La contraseña no ha sido actualizada.');
                        }

                    }

                    /* Update user information. */
                    if (!empty($_POST['url'])) {
                        wp_update_user(array('ID' => get_current_user_id(), 'user_url' => esc_url($_POST['url'])));
                    }

                    // if (!empty($_POST['email'])) {
                    //     if (!is_email(esc_attr($_POST['email']))) {
                    //         $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
                    //     } elseif (email_exists(esc_attr($_POST['email'])) != false and email_exists(esc_attr($_POST['email'])) != get_current_user_id()) {
                    //         $error[] = __('This email is already used sby another user. Try a different one.', 'profile');
                    //     } else {
                    //         wp_update_user(array('ID' => get_current_user_id(), 'user_email' => esc_attr($_POST['email'])));
                    //     }
                    // }

                    if (!function_exists('wp_handle_upload')) {
                        require_once ABSPATH . 'wp-admin/includes/file.php';
                    }

                    if (!empty($_FILES['centro-image']['name'])) {
                        $upload = wp_handle_upload($_FILES['centro-image'], array('test_form' => false));

                        update_user_meta(get_current_user_id(), 'centro-image', $upload['url']);
                    }

                    if (!empty($_FILES['doctor-firma-image']['name'])) {
                        $upload = wp_handle_upload($_FILES['doctor-firma-image'], array('test_form' => false));

                        update_user_meta(get_current_user_id(), 'doctor-firma-image', $upload['url']);
                    }



                    // update_user_meta(get_current_user_id(), 'linkedin', $_POST['linkedin']);

                    if (!empty($_POST['first-name'])) {
                        update_user_meta(get_current_user_id(), 'first_name', esc_attr($_POST['first-name']));
                    }

  

                    if (!empty($_POST['last-name'])) {
                        update_user_meta(get_current_user_id(), 'last_name', esc_attr($_POST['last-name']));
                    }

                    if (!empty($_POST['centro-name'])) {
                        update_user_meta(get_current_user_id(), 'centro_name', esc_attr($_POST['centro-name']));
                    }

                    if (!empty($_POST['centro-phone'])) {
                        update_user_meta(get_current_user_id(), 'centro_phone', esc_attr($_POST['centro-phone']));
                    }


                     if (!empty($_POST['centro-address'])) {
                        update_user_meta(get_current_user_id(), 'centro_address', esc_attr($_POST['centro-address']));
                    }

                    if (!empty($_POST['email'])) {
                        update_user_meta(get_current_user_id(), 'user_email', esc_attr($_POST['email']));
                    }

                    if (!empty($_POST['description'])) {
                        update_user_meta(get_current_user_id(), 'description', esc_attr($_POST['description']));
                    }

                    if (!empty($_POST['wallet'])) {
                        update_user_meta(get_current_user_id(), 'wallet', esc_attr($_POST['wallet']));
                    }

                    /* Redirect so the page will show updated info.*/
                    /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
                    if (count($error) == 0) {
                        do_action('edit_user_profile_update', get_current_user_id());
                    }
                }

                $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

                // sombrilla_lc_show_error_messages(); ?>

<?php if (!is_user_logged_in()){ ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'sombrilla-leadcatcher');?>
                    </p><!-- .warning -->
            <?php }else{ ?>
                <?php if (count($error) > 0) { ?>
                    <div class="alert alert-danger" role="alert">
  <?php echo implode("<br />", $error) ; ?>
</div>
                  
               <?php }else{ ?>
                <?php if (!empty($_POST)): ?>
             <div class="alert alert-success" role="alert">
  Actualizado correctamente.
</div>        
                <?php endif ?>

              <?php } ?>

                <?php
$userdata = get_userdata(get_current_user_id());
                $usermeta = get_user_meta(get_current_user_id());

                ?>
<style>
    img.cento-logo {
    max-width: 100%;
    max-height: 50px;
}
</style>

                <form method="post" enctype="multipart/form-data" id="adduser" action="<?php the_permalink();?>">

<h3>Información del Médico</h3>

                    <div class="row">




                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username"><?php _e('Usuario:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="username" type="text" id="username" value="<?php echo $userdata->user_login; ?>" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname"><?php _e('Nombre:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="first-name" type="text" id="first-name" value="<?php echo $userdata->first_name; ?>"  />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last-name"><?php _e('Apellido:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="last-name" type="text" id="last-name" value="<?php echo $userdata->last_name; ?>"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><?php _e('E-mail:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="email" type="text" id="email" value="<?php echo $userdata->user_email; ?>"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo-centro"><?php _e('Firma del Doctor:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" id="logo-centro" name="doctor-firma-image" type="file" value=""  />
                            </div>

                                <?php if (!empty($usermeta['doctor-firma-image'][0])): ?>
        <img src="<?php echo $usermeta['doctor-firma-image'][0]; ?>" alt="" class="cento-logo">
    <?php endif ?>


                        </div>



                    </div>


<h3>Cambiar Contraseña</h3>
<p>Solo llene estos campos si desea cambiar su contraseña.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass1"><?php _e('Password:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="pass1" type="password" id="pass1"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass2"><?php _e('Confirme el Password:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="pass2" type="password" id="pass2"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass2"><?php _e('Password anterior:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="oldpass" type="password" id="pass2"/>
                            </div>
                        </div>


                    </div>


                    <h3>Información del Centro</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last-name"><?php _e('Nombre del Centro:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="centro-name" type="text" value="<?php echo (isset($usermeta['centro_name'])) ? $usermeta['centro_name'][0]:''; ?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last-name"><?php _e('Telefono del Centro:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="centro-phone" type="text" value="<?php echo (isset($usermeta['centro_phone'])) ? $usermeta['centro_phone'][0]:''; ?>" />
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last-name"><?php _e('Dirección del Centro:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" name="centro-address" type="text" value="<?php echo (isset($usermeta['centro_address'])) ? $usermeta['centro_address'][0]:''; ?>" />
                            </div>
                        </div>


 						<div class="col-md-6">
                            <div class="form-group">
                                <label for="logo-centro"><?php _e('Logo del Centro:', 'sombrilla-leadcatcher');?></label>
                                <input class="text-input form-control" id="logo-centro" name="centro-image" type="file" />
                            </div>
    <?php if (!empty($usermeta['centro-image'][0])): ?>
        <img src="<?php echo $usermeta['centro-image'][0]; ?>" alt="" class="cento-logo">
    <?php endif ?>
                          
                        </div>






                    </div>

                    <?php
//action hook for plugin and extra fields
              //  do_action('edit_user_profile', $current_user);
                ?>
                    <p class="form-submit">

                        <input name="updateuser" type="submit" id="updateuser" class="btn btn-primary submit et_pb_button" value="<?php _e('Actualizar', 'sombrilla-leadcatcher');?>" />
                        <?php wp_nonce_field('update-user')?>
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </p><!-- .form-submit -->
                </form><!-- #adduser -->


    <?php

            }
        }