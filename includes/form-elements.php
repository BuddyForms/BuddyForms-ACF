<?php

/*
 * Add ACF form elementrs in the form elements select box
 */
function buddyforms_acf_elements_to_select( $elements_select_options ) {
	global $post;

	if ( $post->post_type != 'buddyforms' ) {
		return;
	}
	$elements_select_options['acf']['label']               = 'ACF';
	$elements_select_options['acf']['class']               = 'bf_show_if_f_type_post';
	$elements_select_options['acf']['fields']['acf-field'] = array(
		'label' => __( 'ACF Field', 'buddyforms' ),
	);

	$elements_select_options['acf']['fields']['acf-group'] = array(
		'label' => __( 'ACF Group', 'buddyforms' ),
	);

	return $elements_select_options;
}

add_filter( 'buddyforms_add_form_element_select_option', 'buddyforms_acf_elements_to_select', 1, 2 );


/*
 * Create the new ACF Form Builder Form Elements
 *
 */
function buddyforms_acf_form_builder_form_elements( $form_fields, $form_slug, $field_type, $field_id ) {
	global $field_position, $buddyforms;

	$post_type = 'acf';
	if ( post_type_exists( 'acf-field-group' ) ) {
		$post_type = 'acf-field-group';
	}

	switch ( $field_type ) {
		case 'acf-field':

			unset( $form_fields );

			// get acf grups
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
			if ( isset( $buddyforms[ $form_slug ]['form_fields'][ $field_id ]['acf_group'] ) ) {
				$acf_group = $buddyforms[ $form_slug ]['form_fields'][ $field_id ]['acf_group'];
			}
			$form_fields['general']['acf_group'] = new Element_Select( '', "buddyforms_options[form_fields][" . $field_id . "][acf_group]", $acf_groups, array(
				'value'         => $acf_group,
				'class'         => 'bf_acf_field_group_select',
				'data-field_id' => $field_id
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
			if ( isset( $buddyforms[ $form_slug ]['form_fields'][ $field_id ]['acf_field'] ) ) {
				$acf_field = $buddyforms[ $form_slug ]['form_fields'][ $field_id ]['acf_field'];
			}
			$form_fields['general']['acf_field'] = new Element_Select( '', "buddyforms_options[form_fields][" . $field_id . "][acf_field]", $field_select, array(
				'value' => $acf_field,
				'class' => 'bf_acf_fields_select bf_acf_' . $field_id
			) );

			$name = 'ACF-Field';
			if ( $acf_field && $acf_field != 'false' ) {
				$name = 'ACF Field: ' . $acf_field;
			}
			$form_fields['general']['name'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][name]", $name );

			$form_fields['general']['slug']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][slug]", 'acf_field_key' );
			$form_fields['general']['type']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][type]", $field_type );
			$form_fields['general']['order'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][order]", $field_position, array( 'id' => 'buddyforms/' . $form_slug . '/form_fields/' . $field_id . '/order' ) );
			break;
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
			if ( isset( $buddyforms[ $form_slug ]['form_fields'][ $field_id ]['acf_group'] ) ) {
				$acf_group = $buddyforms[ $form_slug ]['form_fields'][ $field_id ]['acf_group'];
			}
			$form_fields['general']['acf_group'] = new Element_Select( '', "buddyforms_options[form_fields][" . $field_id . "][acf_group]", $acf_groups, array( 'value' => $acf_group ) );

			$name = 'ACF-Group';
			if ( $acf_group != 'false' ) {
				$name = ' ACF Group: ' . $acf_group;
			}
			$form_fields['general']['name'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][name]", $name );

			$form_fields['general']['slug']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][slug]", 'acf-fields-group' );
			$form_fields['general']['type']  = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][type]", $field_type );
			$form_fields['general']['order'] = new Element_Hidden( "buddyforms_options[form_fields][" . $field_id . "][order]", $field_position, array( 'id' => 'buddyforms/' . $form_slug . '/form_fields/' . $field_id . '/order' ) );
			break;

	}

	return $form_fields;
}

add_filter( 'buddyforms_form_element_add_field', 'buddyforms_acf_form_builder_form_elements', 1, 5 );

/*
 * Display the new ACF Fields in the frontend form
 *
 */
function buddyforms_acf_frontend_form_elements( $form, $form_args ) {
	global $buddyforms, $nonce;

	$form_slug   = '';
	$customfield = array();
	$post_id     = 0;

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

			$tmp = '';

			if ( ! $nonce ) {
				$tmp .= '<input type="hidden" name="_acfnonce" value="' . wp_create_nonce( 'input' ) . '" />';
			}

			if ( ! isset( $customfield['acf_field'] ) ) {
				return $form;
			}

			$field = get_field_object( $customfield['acf_field'], $post_id, false );

			// make sure we have a field key. If user switch from free to pro ACF this can happen so we need to catch it...
			if ( ! isset( $field['key'] ) ) {
				return $form;
			}

			$field['name'] = 'fields[' . $field['key'] . ']';
			ob_start();

			if ( post_type_exists( 'acf-field-group' ) ) {
				create_field( $field, $post_id );
			} else {
				do_action( 'acf/create_field', $field, $post_id );
			}


			$acf_form_field = ob_get_clean();
			$required_class = '';

			// if the field type is not set for any reason, make it a text field. This check is again in tplace for people how switch from pro to free and have some elements with no type
			$field_type = isset( $field['type'] ) ? $field['type'] : 'text';

			// Create the BuddyForms Form Element Structure
			if ( post_type_exists( 'acf-field-group' ) ) {
				// Create the BuddyForms Form Element Structure
				$tmp .= sprintf( "<div id=\"acf-%s\" class=\"bf_field bf_field_group acf-field acf-field-%s acf-%s %s\" data-name=\"%s\" data-key=\"%s\" data-type=\"%s\"><label for=\"%s\">%s</label>", $field['name'], str_replace( "_", "-", $field_type ), str_replace( "_", "-", $field['key'] ), $required_class, $field['name'], $field['key'], $field['type'], $field['name'], $field['label'] );
			} else {
				// Create the BuddyForms Form Element Structure
				$tmp .= sprintf( "<div id=\"acf-%s\" class=\"bf_field_group field field_type-%s field_key-%s%s\" data-field_name=\"%s\" data-field_key=\"%s\" data-field_type=\"%s\"><label for=\"%s\"><label for=\"%s\">%s</label>", $field['name'], $field_type, $field['key'], $required_class, $field['name'], $field['key'], $field_type, $field['name'], $field['name'], $field['label'] );
			}

			if ( $field['required'] ) {
				$tmp            = str_replace( '</label>', '&nbsp;<span class="required" aria-required="true">&nbsp;&ast;&nbsp;</span>&nbsp;</label>', $tmp );
				$acf_form_field = str_replace( 'type=', 'required type=', $acf_form_field );
			}
			$acf_form_field = str_replace( 'acf-input-wrap', 'bf_inputs', $acf_form_field );
			if ( strpos( $acf_form_field, 'class=' ) === false ) {
				$acf_form_field = str_replace( 'class="', 'class="settings-input form-control ', $acf_form_field );
			} else {
				$acf_form_field = str_replace( 'id="', 'class="settings-input form-control" id="', $acf_form_field );
			}

			if ( $field['instructions'] ) {
				$tmp .= '<span class="help-inline">' . $field['instructions'] . '</span>';
			}
			//settings-input  form-control

			$tmp .= $acf_form_field;
			$tmp .= '</div>';

			wp_enqueue_script( 'buddyforms-acf-js', BUDDYFORMS_ACF_PLUGIN_URL . '/assets/js/buddyforms-acf.js', array(
				'jquery',
				'buddyforms-js'
			) );

			$form->addElement( new Element_HTML( $tmp ) );

			break;
		case 'acf-group':

			$post_id = empty( $post_id ) ? 'new_post' : $post_id;

			// load fields
			if ( post_type_exists( 'acf-field-group' ) ) {
				$parent = (int) $customfield['acf_group'];
				$fields = acf_get_fields( $parent );
			} else {
				$fields = apply_filters( 'acf/field_group/get_fields', array(), $customfield['acf_group'] );
			}
			if ( ! isset( $fields ) || ! is_array( $fields ) ) {
				return $form;
			}

			$tmp = '';

			if ( ! $nonce ) {
				$tmp .= '<input type="hidden" name="_acfnonce" value="' . wp_create_nonce( 'input' ) . '" />';
			}

			foreach ( $fields as $field ) {
				// set value
				if ( ! isset( $field['value'] ) ) {
					$field['value'] = get_field( $field['name'], $post_id, false );
				}

				// make sure we have a field key. If user switch from free to pro ACF this can happen so we need to catch it...
				if ( ! isset( $field['key'] ) ) {
					return $form;
				}

				$field['name'] = 'fields[' . $field['key'] . ']';

				ob_start();
				if ( post_type_exists( 'acf-field-group' ) ) {
					create_field( $field );
				} else {
					do_action( 'acf/create_field', $field, $post_id );
				}
				$acf_form_field = ob_get_clean();

				if ( empty( $acf_form_field ) ) {
					continue;
				}

				$required_class = '';

				// if the field type is not set for any reason, make it a text field. This check is again in tplace for people how switch from pro to free and have some elements with no type
				$field_type = isset( $field['type'] ) ? $field['type'] : 'text';

				// Create the BuddyForms Form Element Structure
				if ( post_type_exists( 'acf-field-group' ) ) {
					// Create the BuddyForms Form Element Structure

					if ( ! empty( $field['conditional_logic'] ) ) {
						$rule = esc_html( json_encode( $field['conditional_logic'] ) );
						$tmp  .= sprintf( "<div id=\"acf-%s\" class=\"bf_field acf-field acf-field-%s acf-%s %s\" data-name=\"%s\" data-key=\"%s\" data-type=\"%s\" data-conditions=\"%s\"  ><label for=\"%s\"  >%s</label>", $field['name'], str_replace( "_", "-", $field_type ), str_replace( "_", "-", $field['key'] ), $required_class, $field['name'], $field['key'], $field['type'], $rule, $field['name'], $field['label'] );
					} else {
						$tmp .= sprintf( "<div id=\"acf-%s\" class=\"bf_field acf-field acf-field-%s acf-%s %s\" data-name=\"%s\" data-key=\"%s\" data-type=\"%s\"  ><label for=\"%s\"  >%s</label>", $field['name'], str_replace( "_", "-", $field_type ), str_replace( "_", "-", $field['key'] ), $required_class, $field['name'], $field['key'], $field['type'], $field['name'], $field['label'] );
					}

				} else {
					// Create the BuddyForms Form Element Structure
					$tmp .= sprintf( "<div id=\"acf-%s\" class=\"bf_field_group field field_type-%s field_key-%s%s\" data-field_name=\"%s\" data-field_key=\"%s\" data-field_type=\"%s\"><label for=\"%s\"><label for=\"%s\">%s</label>", $field['name'], $field_type, $field['key'], $required_class, $field['name'], $field['key'], $field_type, $field['name'], $field['name'], $field['label'] );
				}

				if ( $field['required'] ) {
					$tmp            = str_replace( '</label>', '&nbsp;<span class="required" aria-required="true">&nbsp;&ast;&nbsp;</span>&nbsp;</label>', $tmp );
					$acf_form_field = str_replace( 'type=', 'required type=', $acf_form_field );
				}
				$acf_form_field = str_replace( 'acf-input-wrap', 'bf_inputs', $acf_form_field );

				if ( $field['instructions'] ) {
					$tmp .= '<span class="help-inline">' . $field['instructions'] . '</span>';
				}

				$tmp .= $acf_form_field;
				ob_start();
				if ( ! empty( $field['conditional_logic'] ) ):
					?>

				<?php endif;


				$tmp .= ob_get_clean();
				$tmp .= '</div>';

			}

			$form->addElement( new Element_HTML( $tmp ) );
			break;
	}

	return $form;
}

add_filter( 'buddyforms_create_edit_form_display_element', 'buddyforms_acf_frontend_form_elements', 1, 2 );

/*
 * Save ACF Fields
 *
 */
function buddyforms_acf_update_post_meta( $customfield, $post_id ) {
	if ( $customfield['type'] == 'acf-group' ) {

		$group_ID = $customfield['acf_group'];

		$fields = array();

		// load fields
		if ( post_type_exists( 'acf-field-group' ) ) {
			$fields = acf_get_fields( $group_ID );

			if ( $fields ) {
				foreach ( $fields as $field ) {
					if ( isset( $_POST['acf'][ $field['key'] ] ) ) {
						update_field( $field['key'], $_POST['acf'][ $field['key'] ], $post_id );
					}
				}
			}
		} else {
			$fields = apply_filters( 'acf/field_group/get_fields', $fields, $group_ID );
			if ( $fields ) {
				foreach ( $fields as $field ) {

					if ( isset( $_POST[ $field['name'] ] ) ) {
						update_field( $field['key'], $_POST[ $field['name'] ], $post_id );
					}

				}
			}
		}

	}
	if ( $customfield['type'] == 'acf-field' ) {
		if ( post_type_exists( 'acf-field-group' ) ) {
			if ( isset( $_POST['acf'][ $customfield['acf_field'] ] ) ) {
				update_field( $customfield['acf_field'], $_POST['acf'][ $customfield['acf_field'] ], $post_id );
			}
		} else {
			if ( isset( $_POST['fields'][ $customfield['acf_field'] ] ) ) {
				update_field( $customfield['acf_field'], $_POST['fields'][ $customfield['acf_field'] ], $post_id );
			}
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
