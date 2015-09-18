<?php
/**
 * Date: 2013.01.03.
 * Time: 9:29
 *
 * @author Fehérdi Lóránd <feherdi.lorand@gmail.com>
 */
class Heaven7_Previousnext_Model_Type{

	public function toOptionArray(){

		$options = array('link'   => 'Link',
						 'button' => 'Button');

		return $options;
	}
}