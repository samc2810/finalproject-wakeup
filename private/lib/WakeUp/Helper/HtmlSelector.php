<?php

namespace WakeUp\Helper;

/**
 * Description of HtmlSelector
 *
 * @author sarora
 */
class HtmlSelector{
//put your code here

/**
 * this function creates an HTML-Select element with the following parameters
 *
 * @param string $name the name and ID of the Select element
 * @param array $options the texts to be displayed in the options
 * @param array $values the values of the options default is null,
 *		if null then the values are same as the option text
 * @param array $attributes an assoc array with the keys as the attribute names and the respective values
 *
 */
    public static function generate($name, array $options, array $values=null, $selected=null, array $attributes=null) {
        if($values==null)
            $values = $options;
        //            var_dump($options);

        $attr = '';
        if($attributes!==null)
            foreach($attributes as $key => $val) {
                $attr .= "$key = \"$val\" ";
            }
        $select = '<select name="'.$name.'" id="'.$name.'" '.$attr.'>';

        $optionTag = "";
        for($i=0;$i<count($options);++$i) {
            $selectedVal = "";
            if($values[$i]==$selected)
                $selectedVal = ' selected="selected "';
            $optionTag .= '<option value="'.$values[$i].'"'.$selectedVal.'>'.$options[$i].'</option>';
        }
        $select .= $optionTag.'</select>';

        return $select;
    }
}
?>
