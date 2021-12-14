<?php
    class Controllers {
        /*function controllerLettersNumbers($string){
            $string = str_replace(" ", "", $string);
            $string = str_replace(".", "", $string);
            $string = str_replace(",", "", $string);
            $string = str_replace("!", "", $string);
            $string = str_replace("?", "", $string);
            $string = str_replace(";", "", $string);
            $string = str_replace(":", "", $string);
            $string = str_replace("'", "", $string);
            $string = str_replace("\"", "", $string);
            $string = str_replace("-", "", $string);
            $string = str_replace("_", "", $string);
            $string = str_replace("(", "", $string);
            $string = str_replace(")", "", $string);
            $string = str_replace("[", "", $string);
            $string = str_replace("]", "", $string);
            $string = str_replace("{", "", $string);
            $string = str_replace("}", "", $string);
            $string = str_replace("/", "", $string);
            $string = str_replace("\\", "", $string);
        }*/


        function controllerLettersNumbers($string){
            for($i=0; $i<strlen($string); $i++){
                if(!ctype_alnum($string[$i])){
                    $string[$i] = "";
                }
            }

            }
        }
    
?>