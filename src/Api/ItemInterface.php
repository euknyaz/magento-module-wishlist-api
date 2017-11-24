<?php
/**
 * @copyright: Copyright © 2017 mediaman GmbH. All rights reserved.
 * @see LICENSE.txt
 */

namespace Euknyaz\WishlistApi\Api;

use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Interface ItemInterface
 * @package Euknyaz\WishlistApi\Api
 * @api
 */
interface ItemInterface
{

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct(): ProductInterface;
}
