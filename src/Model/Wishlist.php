<?php
/**
 * @copyright: Copyright © 2017 mediaman GmbH. All rights reserved.
 * @see LICENSE.txt
 */

namespace Euknyaz\WishlistApi\Model;

use Euknyaz\WishlistApi\Api\WishlistInterface;

/**
 * Class Wishlist
 * @package Euknyaz\WishlistApi\Model
 */
class Wishlist extends \Magento\Wishlist\Model\Wishlist implements WishlistInterface
{

    /**
     * @inheritdoc
     */
    public function getItems()
    {
        return $this->getItemCollection()->getItems();
    }
}
