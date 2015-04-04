<?php
/**
 * Copyright 2015 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2015 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/OpSiteBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/OpSiteBundle
 */

namespace OpSiteBuilder\Bundle\CoreBundle\Routing\Configuration;

use OpSiteBuilder\Bundle\CoreBundle\Model\AbstractPage;

/**
 * Class AbstractPageRouteConfiguration
 *
 * @package OpSiteBuilder\Bundle\CoreBundle\Routing\Configuration
 * @author jobou
 */
abstract class AbstractPageRouteConfiguration
{
    /**
     * Check if route configuration matches url
     *
     * @param string $url
     *
     * @return null|string
     */
    public function isMatching($url)
    {
        if ($this->getRegex() === null) {
            return true;
        }

        if (preg_match($this->getRegex(), $url)) {
            return true;
        }

        return false;
    }

    /**
     * Extract page pathinfo
     * Call isMatching before to be sure regex matches
     *
     * @param $pathInfo
     *
     * @return string
     */
    public function extractPathInfo($pathInfo)
    {
        if ($this->getRegex() === null) {
            return $pathInfo;
        }

        preg_match($this->getRegex(), $pathInfo, $matches);
        return $matches[1];
    }

    /**
     * Get page route name
     *
     * @param AbstractPage $page
     *
     * @return string
     */
    public function getPageRouteName(AbstractPage $page)
    {
        return sprintf('%s%s', $this->getPrefix(), $page->getId());
    }

    /**
     * Extract a page id from the route name
     *
     * @param string $routeName
     *
     * @return int|null
     */
    public function extractId($routeName)
    {
        if (!$this->supports($routeName)) {
            return null;
        }

        return (int) str_replace($this->getPrefix(), '', $routeName);
    }

    /**
     * Build a path
     *
     * @param string $pathInfo
     *
     * @return string
     */
    public function buildPath($pathInfo)
    {
        if (null === $this->getPath()) {
            return $pathInfo;
        }

        return sprintf($this->getPath(), $pathInfo);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($name)
    {
        return strpos($name, $this->getPrefix()) === 0;
    }

    /**
     * Get the route name prefix
     *
     * @return string
     */
    abstract public function getPrefix();

    /**
     * Get the regex to match a pathinfo
     *
     * @return string
     */
    abstract public function getRegex();

    /**
     * Get the controller to execute
     *
     * @return string
     */
    abstract public function getController();

    /**
     * Get the path sprintf to generate pathinfo
     *
     * @return string
     */
    abstract public function getPath();
}
