<?php
/**
 * Copyright 2015 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2015 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/OpSiteBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/OpSiteBundle
 */

namespace OpSiteBuilder\Bundle\CoreBundle\Routing\Factory;

use OpSiteBuilder\Bundle\CoreBundle\Model\AbstractPage;
use OpSiteBuilder\Bundle\CoreBundle\Routing\Configuration\AbstractPageRouteConfiguration;

/**
 * Class PageRouteFactoryInterface
 *
 * @package OpSiteBuilder\Bundle\CoreBundle\Routing\Factory
 * @author jobou
 */
interface PageRouteFactoryInterface
{
    /**
     * Create a new route instance
     *
     * @param AbstractPageRouteConfiguration $routeConfiguration
     * @param AbstractPage                   $page
     *
     * @return \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route
     */
    public function create(AbstractPageRouteConfiguration $routeConfiguration, AbstractPage $page);

    /**
     * Create a new route instance from a page id
     *
     * @param AbstractPageRouteConfiguration $routeConfiguration
     * @param int                            $pageId
     *
     * @return \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route
     */
    public function createFromId(AbstractPageRouteConfiguration $routeConfiguration, $pageId);
}
