<?php

function buddyforms_acf_elements_to_select( $elements_select_options ) {
	global $post;

	if ( $post->post_type != 'buddyforms' ) {
		return;
	}
	$elements_select_options['acf']['label'] = 'ACF';
	$elements_select_options['acf']['fields']['acf-field'] = array(
		'label'     => __( 'ACF Field', 'buddyforms' ),
		'unique'    => 'unique'
	);

	$elements_select_options['acf']['fields']['acf-group'] = array(
		'label'     => __( 'ACF Group', 'buddyforms' ),
		'unique'    => 'unique'
	);

	return $elements_select_options;
}

add_filter( 'buddyforms_add_form_element_to_select', 'buddyforms_acf_elements_to_select', 1, 2 );


/*
 * Create the new Form Builder Form Element for teh ACF Field Groups
 *
 */
function bf_acf_group_create_new_form_builder_form_element( $form_fields, $form_slug, $field_type, $field_id ) {
	global $field_position, $buddyforms;
	$buddyforms_options = $buddyforms;

	$post_type = 'acf';
	if ( post_type_exists( 'acf-field-group' ) ) {
		$post_type = 'acf-field-group';
	}

	switch ( $field_type ) {

		case 'acf-group':
			unset( $form_fields );

			// get acf's
			$posts = get_posts( array(
				'numberposts'      => - 1,
				'post_type'        => $post_type,
				'orderby'          => 'menu_order title',
				'order'            => 'asc',
				'suppress_filters' => false,
			) );

			$acf_groups = Array();
			if ( $posts ) {
				foreach ( $posts as $post ) {
					$acf_groups[ $post->ID ] = $post->post_title;
				}
			}

			$acf_group = 'false';
			if ( isset( $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['acf_group'] ) ) {
				$acf_group = $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['acf_group'];
			}
			$form_fields['general']['acf_group'] = new Element_Select( '', "buddyforms_options[form_fields][" . $field_id . "][acf_group]", $acf_groups, array( 'value' => $acf_group ) );

			$name = 'ACF-Group';
			if ( $acf_group != 'false' ) {
				$name = ' ACF Field Group: ' . $acf_group;
			}
			$form_fields['general']['name'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][name]", $name );

			$form_fields['advanced']['slug']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][slug]", 'acf-fields-group' );
			$form_fields['general']['type']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][type]", $field_type );
			$form_fields['general']['order'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][order]", $field_position, array( 'id' => 'buddyforms/' . $form_slug . '/form_fields/' . $field_id . '/order' ) );
			break;

	}

	return $form_fields;
}

add_filter( 'buddyforms_form_element_add_field', 'bf_acf_group_create_new_form_builder_form_element', 1, 5 );

/*
 * Create the new Form Builder Form Element for the ACF Field
 *
 */
function bf_acf_field_create_new_form_builder_form_element( $form_fields, $form_slug, $field_type, $field_id ) {
	global $field_position, $buddyforms;

	$buddyforms_options = $buddyforms;

	switch ( $field_type ) {

		case 'acf-field':
			unset( $form_fields );

			$post_type = 'acf';
			if ( post_type_exists( 'acf-field-group' ) ) {
				$post_type = 'acf-field-group';
			}

			// get acf's
			$posts = get_posts( array(
				'numberposts'      => - 1,
				'post_type'        => $post_type,
				'orderby'          => 'menu_order title',
				'order'            => 'asc',
				'suppress_filters' => false,
			) );

			$acf_groups['none'] = 'Select Group';

			if ( $posts ) {
				foreach ( $posts as $post ) {
					$acf_groups[ $post->ID ] = $post->post_title;
				}
			}

			$acf_group = 'false';
			if ( isset( $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['acf_group'] ) ) {
				$acf_group = $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['acf_group'];
			}
			$form_fields['general']['acf_group'] = new Element_Select( '', "buddyforms_options[form_fields][" . $field_id . "][acf_group]", $acf_groups, array(
				'value' => $acf_group,
				'class' => 'bf_acf_field_group_select'
			) );

			// load fields
			if ( post_type_exists( 'acf-field-group' ) ) {
				if ( $acf_group ) {
					$fields = acf_get_fields( $acf_group );
				}
			} else {
				if ( $acf_group ) {
					$fields = apply_filters( 'acf/field_group/get_fields', array(), $acf_group );
				}
			}

			$field_select = Array();

			if ( $fields ) {
				foreach ( $fields as $field ) {

					if ( $field['name'] ) {
						$field_select[ $field['key'] ] = $field['label'];
					}
				}
			}

			$acf_field = 'false';
			if ( isset( $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['acf_field'] ) ) {
				$acf_field = $buddyforms_options[ $form_slug ]['form_fields'][ $field_id ]['acf_field'];
			}
			$form_fields['general']['acf_field'] = new Element_Select( '', "buddyforms_options[form_fields][" . $field_id . "][acf_field]", $field_select, array(
				'value' => $acf_field,
				'class' => 'bf_acf_fields_select'
			) );

			$name = 'ACF-Field';
			if ( $acf_field && $acf_field != 'false' ) {
				$name = $field_select[ $acf_field ] . ' - Group: ' . $acf_groups[ $acf_group ];
			}
			$form_fields['general']['name'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][name]", $name );

			$form_fields['advanced']['slug']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][slug]", 'acf_field_key' );
			$form_fields['general']['type']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][type]", $field_type );
			$form_fields['general']['order'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][order]", $field_position, array( 'id' => 'buddyforms/' . $form_slug . '/form_fields/' . $field_id . '/order' ) );
			break;

	}

	return $form_fields;
}

add_filter( 'buddyforms_form_element_add_field', 'bf_acf_field_create_new_form_builder_form_element', 1, 5 );

/*
 * Display the new ACF Field Groups Form Element in the Frontend Form
 *
 */
function bf_acf_fields_group_create_frontend_form_element( $form, $form_args ) {
	global $buddyforms, $nonce;

	extract( $form_args );

	$post_type = $buddyforms[ $form_slug ]['post_type'];

	if ( ! $post_type ) {
		return $form;
	}

	if ( ! isset( $customfield['type'] ) ) {
		return $form;
	}

	switch ( $customfield['type'] ) {
		case 'acf':

			$post_id = $post_id == 0 ? 'new_post' : $post_id;

			// load fields
			if ( post_type_exists( 'acf-field-group' ) ) {
				$fields = acf_get_fields( $customfield['acf_group'] );
			} else {
				$fields = apply_filters( 'acf/field_group/get_fields', array(), $customfield['acf_group'] );
			}

			$form->addElement( new Element_HTML( '<div id="poststuff">' ) );

			if ( ! $nonce ) {
				$form->addElement( new Element_HTML( '<input type="hidden" name="acf_nonce" value="' . wp_create_nonce( 'input' ) . '" />' ) );
				$nonce = 'nonce';
			}

			foreach ( $fields as $field ) {
				// set value
				if ( ! isset( $field['value'] ) ) {
					if ( post_type_exists( 'acf-field-group' ) ) {
						$field['value'] = get_field( $field['name'], $post_id, false );
					} else {
						$field['value'] = apply_filters( 'acf/load_value', false, $post_id, $field );
						$field['value'] = apply_filters( 'acf/format_value', $field['value'], $post_id, $field );
					}
				}

				//$field['name'] = 'fields[' . $field['key'] . ']';
				$field['key'] = 'fields[' . $field['key'] . ']';
				ob_start();
				if ( post_type_exists( 'acf-field-group' ) ) {
					create_field( $field, $post_id );
				} else {
					do_action( 'acf/create_field', $field, $post_id );
					// create field specific html
					do_action( "acf/render_field", $field );
					do_action( "acf/render_field/type={$field['type']}", $field );
				}
				$acf_form_field = ob_get_clean();
				$required_class = '';

				if ( post_type_exists( 'acf-field-group' ) ) {
					// Create the BuddyForms Form Element Structure
					$form->addElement( new Element_HTML( '
                          <div id="acf-' . $field['name'] . '" class="bf_field_group acf-field acf-field-' . $field['type'] . ' acf-field' . $field['key'] . $required_class . '" data-name="' . $field['name'] . '" data-key="' . $field['key'] . '" data-type="' . $field['type'] . '"><label for="' . $field['name'] . '">' ) );
				} else {
					// Create the BuddyForms Form Element Structure
					$form->addElement( new Element_HTML( '
                          <div id="acf-' . $field['name'] . '" class="bf_field_group field field_type-' . $field['type'] . ' field_key-' . $field['key'] . $required_class . '" data-field_name="' . $field['name'] . '" data-field_key="' . $field['key'] . '" data-field_type="' . $field['type'] . '"><label for="' . $field['name'] . '">' ) );
				}

				if ( $field['required'] ) {
					$form->addElement( new Element_HTML( '<span class="required" aria-required="true">* </span>' ) );
					$acf_form_field = str_replace( 'type=', 'required type=', $acf_form_field );
				}
				$acf_form_field = str_replace( 'acf-input-wrap', '', $acf_form_field );

				$form->addElement( new Element_HTML( $field['label'] . '</label>' ) );

				if ( $field['instructions'] ) {
					$form->addElement( new Element_HTML( '<smal>' . $field['instructions'] . '</smal>' ) );
				}

				$form->addElement( new Element_HTML( '<div class="bf_inputs"> ' . $acf_form_field . '</div> ' ) );
				$form->addElement( new Element_HTML( '</div>' ) );
			}
			$form->addElement( new Element_HTML( '</div>' ) );
			break;
	}

	return $form;
}

add_filter( 'buddyforms_create_edit_form_display_element', 'bf_acf_fields_group_create_frontend_form_element', 1, 2 );


/*
 * Display the new ACF Field Groups Form Element in the Frontend Form
 *
 */
function bf_acf_field_create_frontend_form_element( $form, $form_args ) {
	global $buddyforms, $nonce;

	extract( $form_args );

	$post_type = $buddyforms[ $form_slug ]['post_type'];

	if ( ! $post_type ) {
		return $form;
	}

	if ( ! isset( $customfield['type'] ) ) {
		return $form;
	}

	switch ( $customfield['type'] ) {
		case 'acf-field':
			$post_id = $post_id == 0 ? 'new_post' : $post_id;

			$form->addElement( new Element_HTML( '<div id="poststuff">' ) );

			if ( ! $nonce ) {
				$form->addElement( new Element_HTML( '<input type="hidden" name="acf_nonce" value="' . wp_create_nonce( 'input' ) . '" />' ) );
				$nonce = 'nonce';
			}

			$field = get_field_object( $customfield['acf_field'], $post_id );

			$field['name'] = 'fields[' . $field['key'] . ']';
			ob_start();

			if ( post_type_exists( 'acf-field-group' ) ) {
				create_field( $field, $post_id );
			} else {
				do_action( 'acf/create_field', $field, $post_id );
			}
			$acf_form_field = ob_get_clean();

			// Create the BuddyForms Form Element Structure
			if ( post_type_exists( 'acf-field-group' ) ) {
				// Create the BuddyForms Form Element Structure
				$form->addElement( new Element_HTML( '
                          <div id="acf-' . $field['name'] . '" class="bf_field_group acf-field acf-field-' . $field['type'] . ' acf-field' . $field['key'] . $required_class . '" data-name="' . $field['name'] . '" data-key="' . $field['key'] . '" data-type="' . $field['type'] . '"><label for="' . $field['name'] . '">' ) );
			} else {
				// Create the BuddyForms Form Element Structure
				$form->addElement( new Element_HTML( '
                          <div id="acf-' . $field['name'] . '" class="bf_field_group field field_type-' . $field['type'] . ' field_key-' . $field['key'] . $required_class . '" data-field_name="' . $field['name'] . '" data-field_key="' . $field['key'] . '" data-field_type="' . $field['type'] . '"><label for="' . $field['name'] . '">' ) );
			}

			if ( $field['required'] ) {
				$form->addElement( new Element_HTML( '<span class="required" aria-required="true">* </span>' ) );
				$acf_form_field = str_replace( 'type=', 'required type=', $acf_form_field );
			}
			$acf_form_field = str_replace( 'acf-input-wrap', '', $acf_form_field );

			$form->addElement( new Element_HTML( $field['label'] . '</label>' ) );

			if ( $field['instructions'] ) {
				$form->addElement( new Element_HTML( '<smal>' . $field['instructions'] . '</smal>' ) );
			}

			$form->addElement( new Element_HTML( '<div class="bf_inputs"> ' . $acf_form_field . '</div> ' ) );
			$form->addElement( new Element_HTML( '</div>' ) );

			$form->addElement( new Element_HTML( '</div>' ) );
			//acf_form($new_post);
			break;
	}

	return $form;
}

add_filter( 'buddyforms_create_edit_form_display_element', 'bf_acf_field_create_frontend_form_element', 1, 2 );

/*
 * Save ACF Fields
 *
 */
function buddyforms_acf_update_post_meta( $customfield, $post_id ) {
	if ( $customfield['type'] == 'acf' ) {

		$group_ID = $customfield['acf_group'];

		$fields = array();

		// load fields
		if ( post_type_exists( 'acf-field-group' ) ) {
			$fields = acf_get_fields( $group_ID );
		} else {
			$fields = apply_filters( 'acf/field_group/get_fields', $fields, $group_ID );
		}

		$fields_values = $_POST['fields'];

		if ( $fields ) {
			foreach ( $fields as $field ) {

				if ( isset( $fields_values[ $field['key'] ] ) ) {
					update_field( $field['key'], $fields_values[ $field['key'] ], $post_id );
				}

			}
		}
	}

	if ( $customfield['type'] == 'acf-field' ) {

		if ( isset( $_POST[ $customfield['acf_field'] ] ) ) {
			update_field( $customfield['acf_field'], $_POST[ $customfield['acf_field'] ], $post_id );
		}
	}

}

add_action( 'buddyforms_update_post_meta', 'buddyforms_acf_update_post_meta', 10, 2 );

function buddyforms_acf_get_fields() {

	// load fields
	if ( post_type_exists( 'acf-field-group' ) ) {
		if ( $_POST['fields_group_id'] ) {
			$fields = acf_get_fields( $_POST['fields_group_id'] );
		}
	} else {
		if ( $_POST['fields_group_id'] ) {
			$fields = apply_filters( 'acf/field_group/get_fields', array(), $_POST['fields_group_id'] );
		}
	}

	$field_select = Array();

	foreach ( $fields as $field ) {

		if ( $field['name'] ) {
			$field_select[ $field['key'] ] = $field['label'];
		}
	}

	echo json_encode( $field_select );

	die();
}

add_action( 'wp_ajax_buddyforms_acf_get_fields', 'buddyforms_acf_get_fields' );
