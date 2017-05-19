<?php

namespace AppBundle\Utils;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManager;
use Liip\ImagineBundle\Controller\ImagineController;

/**
 * @author David Velasco <david@dualhand.com>
 */
class MediaProcessor
{
    public function __construct(EntityManager $entityManager, $imagineController, $request, $provider)
    {
        $this->em = $entityManager;
        /* @var ImagineController liipImagineController */
        $this->liipImagineController = $imagineController;
        $this->request = $request->getCurrentRequest();
        $this->provider = $provider;
    }

    /**
     * @param $category
     * @param $width
     * @param $height
     *
     * @return Media
     */
    public function ProcessImage($category, $width, $height)
    {
        $candidateImages = $this->em->getRepository(Media::class)->getAccurateImage($category, $width, $height);

        /** @var Media $selectedImage */
        $selectedImage = $candidateImages[array_rand($candidateImages, 1)];

        return $selectedImage;
    }

    public function ServeImages($all = false, $category = null)
    {
        if (!$all && $category) {
            $images = $this->em->getRepository(Media::class)->findBy(
                array('context' => $category)
            );
        } else {
            $images = $this->em->getRepository(Media::class)->findAll();
        }

        shuffle($images);

        return $images;
    }
}
