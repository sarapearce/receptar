<?php

require_once("templaty-theme-options-defaults.php");

class TemplatyThemeOptions
{
	private $_options = array();
	
	public function __construct()
	{
		$this->_options = get_option( 'phogra_option_name' );
	}
	
	public function GenerateTextField($fieldName, $fieldLabel, $default = "", $fieldDescription = "")
	{
		printf('
				<tr>
					<td>%s</td>
					<td>
						<input id="theme-options-%s" class="regular-text" type="text" name="phogra_option_name[%s]" value="%s" />
						<label class="description">%s</label>
					</td>
				</tr>',
				$fieldLabel,
				$fieldName,
				$fieldName,
				(esc_attr($this->_options[$fieldName]) != "" ? esc_attr($this->_options[$fieldName]) : $default),
				$fieldDescription
		);
	} 
	
	
	public function GenerateFileUploadField($fieldName, $fieldLabel, $fieldDescription = "")
	{
		$hasUploadedImage = trim($this->_options[$fieldName]) != "";
		$imagePreview = $hasUploadedImage ? sprintf('<img src="%s" alt="Logo" />', $this->_options[$fieldName]) : '';
		
		printf('
				<tr>
					<td>%s</td>
					<td>
 						<input id="theme-options-%s" class="regular-text" type="text" name="phogra_option_name[%s]" value="%s" readonly="readonly" />
 						<input class="templaty-upload-button button" type="button" value="%s" />
	 						
 						<div class="image-preview">
 							%s
	 						<input class="templaty-remove-button button" type="button" value="%s" style="display: %s;" />
 						</div>
					</td>
				</tr>',
				$fieldLabel,
				$fieldName,
				$fieldName,
				esc_attr($this->_options[$fieldName]),
				__("Upload Image", 'templaty'),
				$imagePreview,
				__("Remove Image", 'templaty'),
				($hasUploadedImage ? 'inline' : 'none')
		);
	}
	
	public function GenerateColorPickerField($fieldName, $fieldLabel, $default = "", $fieldDescription = "")
	{
		printf('
				<tr class="color-row">
					<td>%s</td>
					<td>
                        <div>

                        </div>
						<div class="color-field">
						    <input id="theme-options-%s" type="text" name="phogra_option_name[%s]" value="%s" class="templaty-theme-options-color-field" data-default-color="%s" />
							<label class="description">%s</label>
						</div>
					</td>
				</tr>',
				$fieldLabel,
				$fieldName,
				$fieldName,
				(trim(esc_attr($this->_options[$fieldName])) == "" ? $default : esc_attr($this->_options[$fieldName])),
				$default,
				$fieldDescription
		);
	}
}
