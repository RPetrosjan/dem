<?php


namespace AppBundle\service;


use AppBundle\Entity\Distancematrix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class DistancematrixService
 * @package AppBundle\service
 */
class DistancematrixService
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var \AppBundle\Repository\DistancematrixRepository|\Doctrine\Common\Persistence\ObjectRepository
     */
    private $distancematrixRepository;

    /** @var EntityManagerInterface  */
    private $em;


    /**
     * DistancematrixService constructor.
     * @param Container $container
     * @param EntityManagerInterface $em
     */
    public function __construct(Container $container, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->container = $container;
        $this->distancematrixRepository = $em->getRepository(Distancematrix::class);
    }

    /**
     * @param $cpfrom
     * @param $cpto
     * @return array
     */
    public function getDistance($cpfrom, $cpto, $villefrom, $villeto) {

        /** @var  $distance */
        $distance = null;
        // We check if exist distance a la base
        $result = $this->distancematrixRepository->getDistanceFromTo(substr($cpfrom,0,5), substr($cpto,0, 5));
        if(empty($result)) {
            /** @var string $key */
            $key = $this->container->getParameter('api_distancematrix');

            /** @var string $url */
            $url = sprintf('https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s %sfrom&destinations=%s %s&language=fr-FR&sensor=false&key=%s', $cpfrom, $villefrom, $cpto, $villeto, $key);

            $url = preg_replace('/\s+/', '%20', $url);

            /** @var $data */
            $data = file_get_contents($url);
            /** @var array $data */

            /*
            $data = '{
   "destination_addresses" : [ "38100, France" ],
   "origin_addresses" : [ "67100 Strasbourg, France" ],
   "rows" : [
      {
         "elements" : [
            {
               "distance" : {
                  "text" : "574 km",
                  "value" : 573979
               },
               "duration" : {
                  "text" : "5 heures 30 minutes",
                  "value" : 19811
               },
               "status" : "OK"
            }
         ]
      }
   ],
   "status" : "OK"
}';*/

            $data = json_decode($data, TRUE);
            $distance = $data['rows'][0]['elements'][0]['distance']['value'];

            // Add new Distance in the Entity DeistanceMatrix
            $distanceMatrix = new Distancematrix();
            $distanceMatrix->setCpTo($cpto);
            $distanceMatrix->setCpFrom($cpfrom);
            $distanceMatrix->setVilleTo(strtolower($villeto));
            $distanceMatrix->setVilleFrom(strtolower($villefrom));
            $distanceMatrix->setDistance($distance);

            $this->em->persist($distanceMatrix);
            $this->em->flush();

        }
        else {
            $distance = current($result)->getDistance();
        }

        return [
            'distance' => $distance,
        ];

    }
}