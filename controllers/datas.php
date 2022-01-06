<?php

class Data {

    public function getData($element) {
        $array = ["films", "people", "planets", "species", "transport", "vehicles"];
        if (in_array($element, $array)) {
            $data = json_decode(file_get_contents("swapi/" . $element . ".json"));
            return $data;
        }
        return false;
    }
}

?>