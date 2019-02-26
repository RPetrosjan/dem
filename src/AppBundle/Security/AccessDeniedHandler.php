<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 16/12/2018
 * Time: 04:27
 */

namespace AppBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Templating\EngineInterface;



class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $templating;
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        // TODO: Implement handle() method.


       /// $this->templating->render('@Twig/Exception/error403.html.twig');

       /// $loader = new \Twig_Loader_Filesystem('Pages/homepage.html.twig');

        dump($accessDeniedException);
        return new Response('Access Denied Ruben', 403);

    }
}