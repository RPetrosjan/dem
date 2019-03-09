<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 08/03/2019
 * Time: 01:37
 */

namespace AppBundle\service;


use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ImagineFilter implements LoaderInterface
{
    private $container;

    /**
     * ImagineFilter constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function load(ImageInterface $image, array $options = []){

}

    public function filterAction($path, $filter)
    {
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $dataManager  = $this->container->get('liip_imagine.data.manager');
        $filterManager = $this->container->get('liip_imagine.filter.manager');

        if (!$cacheManager->isStored($path, $filter)) {
            $binary = $dataManager->find($filter, $path);

            $filteredBinary = $filterManager->applyFilter($binary, $filter, [
                'filters' => [
                    'thumbnail' => [
                        'size' => [300, 100]
                    ]
                ]
            ]);

            $cacheManager->store($filteredBinary, $path, $filter);
        }
        return new RedirectResponse($cacheManager->resolve($path, $filter), Response::HTTP_MOVED_PERMANENTLY);
    }

}