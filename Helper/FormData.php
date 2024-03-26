<?php

namespace Modules\Agent\Helper;

class FormData {
    public $field_type;
    public $field_name;
    public $field_placeholder;
    public $field_required;
    public $select_options;
    public $mimes_type;

    public function __construct($field_type = null, $field_name = null, $field_placeholder = null, $field_required = null, $select_options = null, $mimes_type = null) {
        $this->field_type = $field_type;
        $this->field_name = $field_name;
        $this->field_placeholder = $field_placeholder;
        $this->field_required = $field_required;
        $this->select_options = $select_options;
        $this->mimes_type = $mimes_type;
    }

    public static function objFormData($form_data_, ) {
        $verification_form = [];
        try{
            $i = 0;
            $num = 0;
            foreach ($form_data_ as $key => $value){
                //dd($value);
                foreach($value as $k => $v){
                    //dd($v);
                    if($key == 'select_options'){
                        $verification_form[$i][$key] = $v;
                        if($num>0){
                            $i++;
                            $num--;
                        }
                    }else{
                        if($key == 'field_type' && $v == 'select' && $i == 0){
                            $i = $k;
                        }else{
                            $num++;
                        }
                        $verification_form[$k][$key] = $v;
                    }
                    
                }
            }
        }catch(\Exception $e){
            $verification_form = [];
            echo $e->getMessage();
        }

        $fdt = [];
        try{
            foreach ($verification_form as $key => $value){
                $fd = new FormData();
                foreach($value as $k => $v){
                    $fd->$k = $v;
                }
                $fdt[$key] = $fd;
            }

        }catch(\Exception $e){
            echo $e->getMessage();
        }

        return $fdt;
    }
}

?>