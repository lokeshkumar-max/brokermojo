<?php
/**
 * Registers the Home page fields with ACF, built from inc/schema.php.
 *
 * Works with ACF PRO, Secure Custom Fields (free, includes repeaters) and
 * the free ACF plugin. Without a repeater field type, every list becomes a
 * fixed set of slots with a “Show this item” switch, so nothing is lost —
 * only the add/remove buttons are.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

/** Is an ACF-compatible plugin active? */
function bm_acf_ready() {
	return function_exists( 'get_field' ) && function_exists( 'acf_add_local_field_group' );
}

/** Does the active ACF build ship the repeater field? */
function bm_has_repeater() {
	if ( ! bm_acf_ready() ) {
		return false;
	}
	if ( class_exists( 'acf_field_repeater' ) ) {
		return true;
	}
	return function_exists( 'acf_get_field_type' ) && (bool) acf_get_field_type( 'repeater' );
}

/** "repeater" or "slots" — how lists are stored with the active plugin. */
function bm_list_mode() {
	return bm_has_repeater() ? 'repeater' : 'slots';
}

add_action( 'acf/init', 'bm_register_fields' );

function bm_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = array(
		array(
			'key'     => 'field_bm_intro',
			'label'   => '',
			'name'    => '',
			'type'    => 'message',
			'message' => 'Every text, image, link and button on the home page is edited here. Pick a section on the left, edit, then press <strong>Update</strong>. Need the original content back? Go to <em>Appearance → BrokerMojo</em>.',
			'new_lines' => '',
			'esc_html'  => 0,
		),
	);

	foreach ( bm_schema() as $key => $section ) {
		$fields[] = array(
			'key'       => 'field_bm_tab_' . $key,
			'label'     => $section['label'],
			'name'      => '',
			'type'      => 'tab',
			'placement' => 'left',
			'endpoint'  => 0,
		);
		$fields[] = array(
			'key'          => 'field_bm_' . $key,
			'label'        => $section['label'],
			'name'         => $key,
			'type'         => 'group',
			'layout'       => 'block',
			'instructions' => '',
			'sub_fields'   => bm_acf_fields( $section['fields'], 'bm_' . $key ),
		);
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_bm_home',
			'title'                 => 'BrokerMojo — Home Page Content',
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'acf_after_title',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array( 'the_content', 'excerpt', 'discussion', 'comments', 'featured_image', 'send-trackbacks' ),
			'active'                => true,
		)
	);
}

/**
 * Turns a list of schema fields into ACF field arrays.
 *
 * @param array  $defs  Schema field definitions.
 * @param string $path  Key prefix of the parent (keeps every key unique and stable).
 */
function bm_acf_fields( $defs, $path ) {
	$out = array();
	foreach ( $defs as $def ) {
		$out[] = bm_acf_field( $def, $path );
	}
	return $out;
}

function bm_acf_field( $def, $path ) {
	$key = 'field_' . $path . '_' . $def['name'];
	$f   = array(
		'key'          => $key,
		'label'        => $def['label'],
		'name'         => $def['name'],
		'instructions' => isset( $def['help'] ) ? $def['help'] : '',
		'required'     => 0,
		'wrapper'      => array(
			'width' => isset( $def['w'] ) ? (string) $def['w'] : '',
			'class' => 'bm-f bm-f--' . $def['type'],
			'id'    => '',
		),
	);

	if ( ! empty( $def['cond'] ) ) {
		$f['conditional_logic'] = array(
			array(
				array(
					'field'    => 'field_' . $path . '_' . $def['cond'][0],
					'operator' => '==',
					'value'    => $def['cond'][1],
				),
			),
		);
	}

	$sub_path = $path . '_' . $def['name'];

	switch ( $def['type'] ) {
		case 'text':
			$f['type'] = 'text';
			break;

		case 'number':
			$f['type'] = 'number';
			$f['min']  = 0;
			break;

		case 'textarea':
			$f['type']      = 'textarea';
			$f['rows']      = 3;
			$f['new_lines'] = '';
			break;

		case 'lines':
			$f['type']      = 'textarea';
			$f['rows']      = 4;
			$f['new_lines'] = '';
			break;

		case 'paras':
			$f['type']      = 'textarea';
			$f['rows']      = 5;
			$f['new_lines'] = '';
			break;

		case 'svg':
			$f['type']      = 'textarea';
			$f['rows']      = 3;
			$f['new_lines'] = '';
			break;

		case 'bool':
			$f['type']          = 'true_false';
			$f['ui']            = 1;
			$f['default_value'] = 0;
			break;

		case 'select':
			$f['type']          = 'select';
			$f['choices']       = $def['choices'];
			$f['default_value'] = isset( $def['default'] ) ? $def['default'] : '';
			$f['return_format'] = 'value';
			$f['allow_null']    = 0;
			$f['ui']            = 0;
			break;

		case 'image':
			$f['type']          = 'image';
			$f['return_format'] = 'id';
			$f['preview_size']  = 'medium';
			$f['library']       = 'all';
			break;

		case 'file':
			$f['type']          = 'file';
			$f['return_format'] = 'url';
			$f['library']       = 'all';
			$f['mime_types']    = 'mp4,webm,ogg,mov';
			break;

		case 'group':
			$f['type']       = 'group';
			$f['layout']     = 'block';
			$f['sub_fields'] = bm_acf_fields( $def['sub'], $sub_path );
			break;

		case 'fixed':
			$f['type']       = 'group';
			$f['layout']     = 'block';
			$f['sub_fields'] = array();
			for ( $i = 1; $i <= $def['count']; $i++ ) {
				$f['sub_fields'][] = array(
					'key'        => 'field_' . $sub_path . '_item_' . $i,
					'label'      => $def['item'] . ' ' . $i,
					'name'       => 'item_' . $i,
					'type'       => 'group',
					'layout'     => 'row',
					'sub_fields' => bm_acf_fields( $def['sub'], $sub_path . '_item_' . $i ),
				);
			}
			break;

		case 'repeater':
			if ( bm_has_repeater() ) {
				$subs                = bm_acf_fields( $def['sub'], $sub_path );
				$f['type']           = 'repeater';
				$f['layout']         = 'block';
				$f['min']            = isset( $def['min'] ) ? $def['min'] : 0;
				$f['max']            = $def['max'];
				$f['button_label']   = 'Add ' . strtolower( $def['item'] );
				$f['collapsed']      = $subs[0]['key'];
				$f['sub_fields']     = $subs;
				$f['rows_per_page']  = 20;
				$f['pagination']     = 0;
			} else {
				$f['type']         = 'group';
				$f['layout']       = 'block';
				$f['instructions'] = trim( $f['instructions'] . ' Up to ' . $def['max'] . ' items — switch “Show” off to hide an item.' );
				$f['sub_fields']   = array();
				for ( $i = 1; $i <= $def['max']; $i++ ) {
					$slot_path         = $sub_path . '_item_' . $i;
					$subs              = bm_acf_fields( $def['sub'], $slot_path );
					array_unshift(
						$subs,
						array(
							'key'           => 'field_' . $slot_path . '__show',
							'label'         => 'Show',
							'name'          => '_show',
							'type'          => 'true_false',
							'ui'            => 1,
							'default_value' => 0,
							'wrapper'       => array( 'width' => '', 'class' => 'bm-f bm-f--show', 'id' => '' ),
						)
					);
					$f['sub_fields'][] = array(
						'key'        => 'field_' . $slot_path,
						'label'      => $def['item'] . ' ' . $i,
						'name'       => 'item_' . $i,
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => $subs,
					);
				}
			}
			break;
	}

	return $f;
}

/**
 * A little breathing room for the long field screen.
 */
add_action(
	'acf/input/admin_head',
	function () {
		echo '<style>
			#acf-group_bm_home .acf-field.bm-f--svg textarea{font-family:Menlo,Consolas,monospace;font-size:11px;line-height:1.45;color:#50575e}
			#acf-group_bm_home .acf-field-group > .acf-label:empty,#acf-group_bm_home .acf-field-group > .acf-label label:empty{display:none}
			#acf-group_bm_home .acf-field[data-name="_show"]{background:#f6f7f7}
		</style>';
	}
);
