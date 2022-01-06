<?php

class Model {

    public function __construct($datas) {
        $this->id = $datas->pk;
        foreach ($datas->fields as $key => $value) {
            $this->$key = $value;
        }
    }

    public function __toString() {
        $attrs = get_object_vars($this);
        $content = "";
        $content .= '<br>';
        $content .= '---' . get_class($this) . '---';
        $content .= '<br>';
        $content .= '<pre>';
        $content .= '<code>';
        foreach ($attrs as $key => $value) {
            if (gettype($value) == "array") {
                $content .= "<b>" . $key . "</b> : <br>";
                foreach ($value as $v) {
                    if (gettype($v) == "object") {
                        $content .= "    " . $v->name . "<br>";
                    } else {
                        $content .= "    " . $v . "<br>";
                    }
                }
            } else {
                $content .= "<b>" . $key . "</b> : " . $value . "<br>";
            }

        }
        $content .= '</code>';
        $content .= '</pre>';
        return $content;
    }
}