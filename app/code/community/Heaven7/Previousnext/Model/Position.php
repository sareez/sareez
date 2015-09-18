<?php
/**
 * Date: 2013.01.03.
 * Time: 9:27
 *
 * @author Fehérdi Lóránd <feherdi.lorand@gmail.com>
 */
class Heaven7_Previousnext_Model_Position
{
    public function toOptionArray()
    {
        $options = array(
        		array('label'=>'Before', 'value'=>'before'),
        		array('label'=>'After', 'value'=>'after'),
        		array('label'=>'Both', 'value'=>'both'),
        );

        return $options;
    }
}
?>