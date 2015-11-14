<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/13/15
 * Time: 9:11 PM
 */
class query
{
    public static function all($class_name) {

        return "SELECT * FROM $class_name;";

    }

    /**
     * @param condition[] $condtions
     * @param string $class_name
     * @return string
     */

    public static function by_condition($condtions, $class_name) {

        $query = "SELECT * FROM $class_name ";

        if(count($condtions) > 0) {
            $query .= "WHERE ";
        } else {
            return $query . ";";
        }

        for($i = 0; $i < count($condtions) -1; $i++) {

            $query .= $condtions[$i]->getLeft()." ".$condtions[$i]->getOperator()." ".$condtions[$i]->getRigth()." AND ,";
        }

        $query .= $condtions[count($condtions) -1]->getLeft()." ".$condtions[count($condtions) -1]->getOperator()." ".$condtions[count($condtions) -1]->getRigth().";";


        $query .= ";";

        return $query;

    }


    public static function insert_object($object) {

        $class = get_class($object);

        $data = (array) $object;

        $class = get_class($object);

        $query = "INSERT INTO  $class ";

        $params = "(";
        $values = "(";


        foreach($data as $key => $value) {

            if(in_array($key,["data", "components", "orm", "auxiliars"])) continue;

            $colum = ltrim($key);
            $colum = substr($colum, 2);
//            $colum[strlen($colum) -1] = "";

            $params .= $colum . ", ";

            if(is_numeric($value)) {

                $values .= " $value ,";

            } else {
                $values .= "  '$value',";
            }

        }

        $params[strlen($params) -2] = ")";
        $values[strlen($values) -1] = ")";

        $query .= $params . " VALUES " . $values . ";";

//        echo $query;

        return  ltrim($query);

    }
}