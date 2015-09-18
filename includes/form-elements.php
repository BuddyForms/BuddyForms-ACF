<?php

function buddyforms_acf_admin_settings_sidebar_metabox($form, $selected_form_slug){

    $form->addElement(new Element_HTML('
		<div class="accordion-group postbox">
			<div class="accordion-heading"><p class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_'.$selected_form_slug.'" href="#accordion_'.$selected_form_slug.'_acf_options">Advanced Custom Fields</p></div>
		    <div id="accordion_'.$selected_form_slug.'_acf_options" class="accordion-body collapse">
				<div class="accordion-inner">'));


    $form->addElement(new Element_HTML('<p><a href="ACF/'.$selected_form_slug.'" class="action">ACF Group</a></p>'));
    //$form->addElement(new Element_HTML('<p><a href="ACF-Field/'.$selected_form_slug.'" class="action">ACF Field</a></p>'));



$group_ID = 92;

$fields = array();
$fields = apply_filters('acf/field_group/get_fields', $fields, $group_ID);

    echo '<pre>';
    print_r($fields);
    echo '</pre>';

//if( $fields )
//{
//    foreach( $fields as $field )
//    {
//        $value = get_field( $field['name'] );
//
//        echo '<dl>';
//        echo '<dt>' . $field['label'] . '</dt>';
//        echo '<dd>' .$value . '</dd>';
//        echo '</dl>';
//    }
//}




    $form->addElement(new Element_HTML('
				</div>
			</div>
		</div>'));

    return $form;
}
add_filter('buddyforms_admin_settings_sidebar_metabox','buddyforms_acf_admin_settings_sidebar_metabox',1,2);

/*
 * Create the new Form Builder Form Element
 *
 */
function bf_acf_create_new_form_builder_form_element($form_fields, $form_slug, $field_type, $field_id){
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


            $acf_group = 'false';
            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_group']))
                $acf_group = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['acf_group'];
            $form_fields['advanced']['acf_group']            = new Element_Checkbox('', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][acf_group]", $acf_groups, array('value' => $acf_group));




            if (isset($buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['name']))
                $name = $buddyforms_options['buddyforms'][$form_slug]['form_fields'][$field_id]['name'];
            $form_fields['left']['name']        = new Element_Textbox('<b>' . __('Name', 'buddyforms') . '</b>', "buddyforms_options[buddyforms][" . $form_slug . "][form_fields][" . $field_id . "][name]", array('value' => $name));

            $form_fields['right']['slug']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][slug]", 'hierarchical');

            $form_fields['right']['type']	    = new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][type]", $field_type);
            $form_fields['right']['order']		= new Element_Hidden("buddyforms_options[buddyforms][".$form_slug."][form_fields][".$field_id."][order]", $field_position, array('id' => 'buddyforms/' . $form_slug .'/form_fields/'. $field_id .'/order'));
            break;

    }

    return $form_fields;
}
add_filter('buddyforms_form_element_add_field','bf_acf_create_new_form_builder_form_element',1,5);

/*
 * Display the new Form Element in the Frontend Form
 *
 */
function bf_acf_create_frontend_form_element($form, $form_args){
    global $buddyforms;

    extract($form_args);

   // print_r($form_args);

    $post_type = $buddyforms['buddyforms'][$form_slug]['post_type'];

    if(!$post_type)
        return $form;

    if(!isset($customfield['type']))
        return $form;

    switch ($customfield['type']) {
        case 'ACF':

            $post_id = $post_id == 0 ? 'new_post': $post_id;
            $new_post = array(
                'post_id'        => $post_id, // Create a new post
                // PUT IN YOUR OWN FIELD GROUP ID(s)
                'field_groups'       => array($customfield['acf_group'][0]), // Create post field group ID(s)
                'form'               => false,
            );


            // load fields
            $fields = apply_filters('acf/field_group/get_fields', array(),  $customfield['acf_group'][0]);
//          do_action('acf/create_fields', $fields, $new_post['post_id']);
            $form->addElement(new Element_HTML('<div id="poststuff">'));
            $form->addElement(new Element_HTML( '<input type="hidden" name="acf_nonce" value="' . wp_create_nonce( 'input' ) . '" />'));


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


//                echo '<pre>';
//                print_r($field);
//                echo '</pre>';
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
add_filter('buddyforms_create_edit_form_display_element','bf_acf_create_frontend_form_element',1,2);

add_action('buddyforms_update_post_meta','buddyforms_acf_update_post_meta', 10, 2);

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
}

