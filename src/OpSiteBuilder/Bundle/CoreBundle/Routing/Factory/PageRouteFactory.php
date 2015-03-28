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
use OpSiteBuilder\Bundle\CoreBundle\Routing\Configuration\PageRouteConfigurationInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;

/**
 * Class PageRouteFactory
 *
 * @package OpSiteBuilder\Bundle\CoreBundle\Routing\Factory
 * @author jobou
 */
class PageRouteFactory implements PageRouteFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(
        PageRouteConfigurationInterface $routeConfiguration,
        AbstractPage $page,
        $path,
        array $breadcrumbs = array()
    ) {
        $route = new Route();
        $route->setName($routeConfiguration->getPageRouteName($page));
        $route->setPath($routeConfiguration->buildPath($path));
        $route->setDefaults(array(
            '_controller' => $routeConfiguration->getController(),
            'page' => $page,
            'path' => $breadcrumbs
        ));

        return $route;
    }
}
