<?php
    $inputs = [];
    foreach( $form['fields'] as $field ){
        switch( $field['type']){
            case 'string':
                $inputs[] = "<input name='{$field['name']}' type='text' placeholder='{$field['title']}'>";
                break;
            case 'int':
                $inputs[] = "<input name='{$field['name']}' type='number' placeholder='{$field['title']}'>";
                break;
            case 'float':
                $inputs[] =
                    "<label for='{$field['name']}'>{$field['title']}</label><input
                        id='{$field['name']}'
                        type='range'
                        name='{$field['name']}'
                        min='0'
                        max='.1'
                        value='.001'
                        step='0.000001'
                        placeholder='{$field['name']}'
                        oninput='this.nextElementSibling.value = this.value'
                        >"
                    ."<output>0.001</output>";
                break;
            case 'date':
                $inputs[] =
                    "<label for='{$field['name']}'>{$field['title']}</label>"
                    . "<input id='{$field['name']}' name='{$field['name']}' type='date' placeholder='{$field['title']}'>";
                break;

        }
    }
    $out = "<h3 class='form-title'>{$form['title']}</h3>";
    $out .= "<form class='form' method='get' action='{$form['action']}'>";
        $out .= implode( '', $inputs );
        $out .= '<br><button type="submit">' . $form['submit'] . '</button>';
    $out .= '</form>';
    
    return $out;