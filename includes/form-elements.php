<?php



/*
 * Create the new Form Builder Sidebar MetaBox with links to add acf field elements
 *
 */
function buddyforms_acf_admin_settings_sidebar_metabox($form, $selected_form_slug){

    $form->addElement(new Element_HTML( bf_form_ellement_accordion_start($selected_form_slug, __('Advanced Custom Fields','buddyforms')) ));

    $form->addElement(new Element_HTML('<b>Add ACF Field Group</b><p><a href="ACF/'.$selected_form_slug.'" class="action">ACF Group</a></p>'));
    $form->addElement(new Element_HTML('<b>Add ACF Field</b><p><a href="ACF-Field/'.$selected_form_slug.'" class="action">ACF Field</a></p>'));

    $form->addElement(new Element_HTML( bf_form_ellement_accordion_end() ));

    return $form;
}
add_filter('buddyforms_admin_settings_sidebar_metabox','buddyforms_acf_admin_settings_sidebar_metabox',1,2);

/*
 * Create the new Form Builder Form Element for teh ACF Field Groups
 *
 */
function bf_acf_group_create_new_form_builder_form_element($form_fields, $form_slug, $field_type, $field_id){
    global $field_position;
    $buddyforms_options = get_option('buddyforms_options');

    switch ($field_type) {

        case 'ACF':
            unset($form_fields);
            $name = 'ACF';

            // get acf's
            $posts = get_posts(array(
                'numberposts' 	=> -1,
                'post_type' 	=> 'acf',
                'orderby' 		=> 'menu_order title',
                'order' 		=> 'asc',
                'suppress_filters' => false,
            ));

            $acf_groups = Array();

            if( $posts ){ foreach( $posts as $post ){

                $acf_groups[$post->ID] = $post->post_title;

            }}

            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['name']))
                $name = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['name'];
            $form_fields['left']['name']        = new Element_Textbox('<b>' . __('Name', 'buddyforms') . '</b>', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][name]", array('value' => $name));

            $acf_group = 'false';
            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_group']))
                $acf_group = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_group'];
            $form_fields['left']['acf_group']            = new Element_Select('', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][acf_group]", $acf_groups, array('value' => $acf_group));

            $form_fields['right']['slug']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][slug]", 'acf-fields-group');

            $form_fields['right']['type']	    = new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][type]", $field_type);
            $form_fields['right']['order']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][order]", $field_position, array('id' => 'buddyforms/' . $form_slug .'/form_fields/'. $field_id .'/order'));
            break;

    }

    return $form_fields;
}
add_filter('buddyforms_form_element_add_field','bf_acf_group_create_new_form_builder_form_element',1,5);

/*
 * Create the new Form Builder Form Element for the ACF Field
 *
 */
function bf_acf_field_create_new_form_builder_form_element($form_fields, $form_slug, $field_type, $field_id){
    global $field_position;
    $buddyforms_options = get_option('buddyforms_options');

    switch ($field_type) {

        case 'ACF-Field':
            unset($form_fields);

            // get acf's
            $posts = get_posts(array(
                'numberposts' 	=> -1,
                'post_type' 	=> 'acf',
                'orderby' 		=> 'menu_order title',
                'order' 		=> 'asc',
                'suppress_filters' => false,
            ));

            $acf_groups = Array();

            if( $posts ){ foreach( $posts as $post ){

                $acf_groups[$post->ID] = $post->post_title;

            }}
            $name = 'ACF-Field';
            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['name']))
                $name = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['name'];
            $form_fields['left']['name']        = new Element_Textbox('<b>' . __('Name', 'buddyforms') . '</b>', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][name]", array('value' => $name));

            $acf_group = 'false';
            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_group']))
                $acf_group = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_group'];
            $form_fields['left']['acf_group']            = new Element_Select('', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][acf_group]", $acf_groups, array('value' => $acf_group));


            // load fields
            if($acf_group)
                $fields = apply_filters('acf/field_group/get_fields', array(),  $acf_group);

            $field_select = Array();

            foreach( $fields as $field ){

                if($field['name'])
                    $field_select[$field['key']] = $field['label'];
            }

            $acf_field = 'false';
            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_field']))
                $acf_field = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_field'];
            $form_fields['left']['acf_field']            = new Element_Select('', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][acf_field]", $field_select, array('value' => $acf_field));


            $form_fields['right']['slug']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][slug]", 'acf_field_key');

            $form_fields['right']['type']	    = new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][type]", $field_type);
            $form_fields['right']['order']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][order]", $field_position, array('id' => 'buddyforms/' . $form_slug .'/form_fields/'. $field_id .'/order'));
            break;

    }

    return $form_fields;
}
add_filter('buddyforms_form_element_add_field','bf_acf_field_create_new_form_builder_form_element',1,5);

/*
 * Display the new ACF Field Groups Form Element in the Frontend Form
 *
 */
function bf_acf_fields_group_create_frontend_form_element($form, $form_args){
    global $buddyforms, $nonce;

    extract($form_args);

    $post_type = $buddyforms['buddyforms'][$form_slug]['post_type'];

    if(!$post_type)
        return $form;

    if(!isset($customfield['type']))
        return $form;

    switch ($customfield['type']) {
        case 'ACF':

            $post_id = $post_id == 0 ? 'new_post': $post_id;

            // load fields
            $fields = apply_filters('acf/field_group/get_fields', array(),  $customfield['acf_group']);

            $form->addElement(new Element_HTML('<div id="poststuff">'));

            if(!$nonce){
                $form->addElement(new Element_HTML( '<input type="hidden" name="acf_nonce" value="' . wp_create_nonce( 'input' ) . '" />'));
                $nonce = 'nonce';
            }

            foreach( $fields as $field ){

                // set value
                if( !isset($field['value']) )
                {
                    $field['value'] = apply_filters('acf/load_value', false, $post_id, $field);
                    $field['value'] = apply_filters('acf/format_value', $field['value'], $post_id, $field);
                }

                $field['name'] = 'fields[' . $field['key'] . ']';
                ob_start();
                do_action('acf/create_field', $field, $post_id);
                $acf_form_field = ob_get_clean();


                // Create the BuddyForms Form Element Structure
                $form->addElement(new Element_HTML( '
                        <div id="acf-' . $field['name'] . '" class="bf_field_group field field_type-' . $field['type'] . ' field_key-' . $field['key'] . $required_class . '" data-field_name="' . $field['name'] . '" data-field_key="' . $field['key'] . '" data-field_type="' . $field['type'] . '">
                            <label for="'.$field['name'].'">'));

                if($field['required']){
                    $form->addElement(new Element_HTML( '<span class="required" aria-required="true">* </span>' ));
                    $acf_form_field = str_replace('type=', 'required type=', $acf_form_field);
                }
                $acf_form_field = str_replace('acf-input-wrap', '', $acf_form_field);


                $form->addElement(new Element_HTML( $field['label'].'</label>'));

                if($field['instructions'])
                    $form->addElement(new Element_HTML( '<smal>' . $field['instructions'] . '</smal>'));

                $form->addElement(new Element_HTML( '<div class="bf_inputs"> '.$acf_form_field.'</div> '));
                $form->addElement(new Element_HTML( '</div>' ));
            }
            $form->addElement(new Element_HTML('<div>'));
            //acf_form($new_post);
            break;
    }

    return $form;
}
add_filter('buddyforms_create_edit_form_display_element','bf_acf_fields_group_create_frontend_form_element',1,2);


/*
 * Display the new ACF Field Groups Form Element in the Frontend Form
 *
 */
function bf_acf_field_create_frontend_form_element($form, $form_args){
    global $buddyforms, $nonce;

    extract($form_args);

    $post_type = $buddyforms['buddyforms'][$form_slug]['post_type'];

    if(!$post_type)
        return $form;

    if(!isset($customfield['type']))
        return $form;

    switch ($customfield['type']) {
        case 'ACF-Field':
            $post_id = $post_id == 0 ? 'new_post': $post_id;

            $form->addElement(new Element_HTML('<div id="poststuff">'));

            if(!$nonce){
                $form->addElement(new Element_HTML( '<input type="hidden" name="acf_nonce" value="' . wp_create_nonce( 'input' ) . '" />'));
                $nonce = 'nonce';
            }


            $field =  get_field_object($customfield['acf_field'], $post_id);


                $field['name'] = 'fields[' . $field['key'] . ']';
                ob_start();
                do_action('acf/create_field', $field, $post_id);
                $acf_form_field = ob_get_clean();


                // Create the BuddyForms Form Element Structure
                $form->addElement(new Element_HTML( '
                        <div id="acf-' . $field['name'] . '" class="bf_field_group field field_type-' . $field['type'] . ' field_key-' . $field['key'] . $required_class . '" data-field_name="' . $field['name'] . '" data-field_key="' . $field['key'] . '" data-field_type="' . $field['type'] . '">
                            <label for="'.$field['name'].'">'));

                if($field['required']){
                    $form->addElement(new Element_HTML( '<span class="required" aria-required="true">* </span>' ));
                    $acf_form_field = str_replace('type=', 'required type=', $acf_form_field);
                }
                $acf_form_field = str_replace('acf-input-wrap', '', $acf_form_field);


                $form->addElement(new Element_HTML( $field['label'].'</label>'));

                if($field['instructions'])
                    $form->addElement(new Element_HTML( '<smal>' . $field['instructions'] . '</smal>'));

                $form->addElement(new Element_HTML( '<div class="bf_inputs"> '.$acf_form_field.'</div> '));
                $form->addElement(new Element_HTML( '</div>' ));

            $form->addElement(new Element_HTML('<div>'));
            //acf_form($new_post);
            break;
    }

    return $form;
}
add_filter('buddyforms_create_edit_form_display_element','bf_acf_field_create_frontend_form_element',1,2);



/*
 * Save ACF Fields
 *
 */
function buddyforms_acf_update_post_meta($customfield, $post_id){
    if( $customfield['type'] == 'ACF' ){

        $group_ID = $customfield['acf_group'];

        $fields = array();
        $fields = apply_filters('acf/field_group/get_fields', $fields, $group_ID);

        $fields_values = $_POST[ 'fields' ];

        if( $fields ) {
            foreach( $fields as $field ) {

                if(isset($fields_values[$field['key']]))
                    update_field( $field['key'], $fields_values[$field['key']], $post_id );
            }
        }
    }

    if( $customfield['type'] == 'ACF-Field' ){

        $fields_values = $_POST[ 'fields' ];

        if(isset($fields_values[$customfield['acf_field']]))
            update_field( $customfield['acf_field'], $fields_values[$customfield['acf_field']], $post_id );

    }
}
add_action('buddyforms_update_post_meta','buddyforms_acf_update_post_meta', 10, 2);
