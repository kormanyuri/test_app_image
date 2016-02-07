<?php

namespace ImageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ImageBundle\Entity\Album;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

/**
 * AlbumRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlbumRepository extends EntityRepository implements PaginatorAwareInterface
{
    /**
     * @var \Knp\Component\Pager\Paginator
     */
    private $paginator;

    /**
     * Sets the KnpPaginator instance.
     *
     * @param Paginator $paginator
     *
     * @return mixed
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }


    /**
     * @param Album $album
     * @param $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getItems(Album $album, $page)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('i')
            ->from('ImageBundle:Image', 'i')
            ->where('i.album=:album')
            ->setParameter('album', $album);

        $query = $qb->getQuery();

        return $this->paginator->paginate(
            $query,
            $page,
            12
        );
    }
}
