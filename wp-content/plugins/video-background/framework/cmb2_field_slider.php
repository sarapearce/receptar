<?php
class OWN_Field_Slider {
	const VERSION = '0.1.0';
	public function hooks() {
		add_filter( 'cmb2_render_own_slider',  array( $this, 'own_slider_field' ), 10, 5 );
	}
	public function own_slider_field( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		echo '<div class="own-slider-field"></div>';
		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'class'      => 'own-slider-field-value',
			'readonly'   => 'readonly',
			'data-start' => absint( $field_escaped_value ),
			'data-min'   => $field->min(),
			'data-max'   => $field->max(),
			'desc'       => '',
		) );
		echo '<span class="own-slider-field-value-display">'. $field->value_label() .' <span class="own-slider-field-value-text"></span></span>';
		$field_type_object->_desc( true, true );
	}
}
$own_field_slider = new OWN_Field_Slider();
$own_field_slider->hooks();
?>
