<?php
/**
 * Copyright 2015 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2015 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/OpSiteBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/OpSiteBundle
 */

namespace OpSiteBuilder\Bundle\CoreBundle\Entity\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use OpSiteBuilder\Bundle\CoreBundle\Model\AbstractPage;
use OpSiteBuilder\Bundle\CoreBundle\Model\Repository\PageRepositoryInterface;

/**
 * Class PageRepository
 *
 * @package OpSiteBuilder\Bundle\CoreBundle\Entity\Repository
 * @author jobou
 */
class PageRepository extends NestedTreeRepository implements PageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPageInTree($slug, AbstractPage $root = null)
    {
        $qb = $this
            ->createQueryBuilder('page')
            ->where('page.slug = :slug')
            ->setParameter('slug', $slug);

        if ($root !== null) {
            $qb
                ->andWhere('page.root = :root')
                ->setParameter('root', $root);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @var array
     */
    protected $cachedPaths = array();

    /**
     * {@inheritdoc}
     */
    public function getCachedPath(AbstractPage $page)
    {
        $pageId = $page->getId();
        if (isset($this->cachedPaths[$pageId])) {
            return $this->cachedPaths[$pageId];
        }

        return $this->cachedPaths[$pageId] = $this->getPath($page);
    }
}
