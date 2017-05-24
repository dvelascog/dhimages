<?php
namespace Application\Sonata\ClassificationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author David Velasco <david@dualhand.com>
 */
class CategoryRepository extends EntityRepository
{

    public function findOneCategoryBySlug($slug)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.slug= :slug')
            ->setParameter('slug', $slug);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }
}
