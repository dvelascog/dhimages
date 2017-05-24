<?php

namespace AppBundle\Controller;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * @param $category
     * @Route("/{category}/{width}/{height}")
     * @ParamConverter("category", class="ApplicationSonataClassificationBundle:Category", options={
     *    "repository_method" = "findOneCategoryBySlug",
     *    "mapping": {"category": "slug"},
     *    "map_method_signature" = true
     * })
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Category $category, $width, $height)
    {
        $image = $this->getMediaProcessor()->ProcessImage($category, $width, $height);

        return $this->render(
            ':default:show.html.twig', array('image' => $image, 'width' => $width, 'height' => $height)
        );
    }

    private function getMediaProcessor()
    {
        return $this->container->get('dualhand.media_processor');
    }
}
