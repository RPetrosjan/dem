<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 11.07.2018
 * Time: 02:34
 */

namespace AppBundle\Service;


class GetDistance
{
    /**
     * Google API pour recuperatin distance entre code postal 1 et code postal 2
     * @param $cp1
     * @param $cp2
     * @return int
     */
    public function getDistance($cp1, $cp2)
    {
        $distance = 0;
        if(strlen($cp1)>2 && strlen($cp2)>2) {
            $from = urlencode($cp1);
            $to = urlencode($cp2);

            $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
            $data = json_decode($data);

            $time = 0;
            $distance = 0;

            if ($data) {
                foreach ($data->rows[0]->elements as $road) {
                    $time += $road->duration->value;
                    $distance += $road->distance->value;
                }
            }
        }
        return $distance/1000;
    }
}