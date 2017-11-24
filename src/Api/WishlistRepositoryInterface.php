<?php
/**
 * @copyright: Copyright © 2017 mediaman GmbH. All rights reserved.
 * @see LICENSE.txt
 */

namespace Euknyaz\WishlistApi\Api;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface WishlistRepositoryInterface
 * @package Euknyaz\WishlistApi\Api
 * @api
 */
interface WishlistRepositoryInterface
{

    /**
     * Get the current customers wishlist
     *
     * @return \Euknyaz\WishlistApi\Api\WishlistInterface
     * @throws NoSuchEntityException
     */
    public function getCurrentWishlist(): WishlistInterface;

    /**
     * Get the customers wishlist by $customerId
     * @param int $customerId (0 - current customer wishlist)
     * @return \Euknyaz\WishlistApi\Api\WishlistInterface
     * @throws NoSuchEntityException
     */
    public function getCustomerWishlist(int $customerId): WishlistInterface;

    /**
     * Add an item from the customers wishlist
     *
     * @param string $sku
     * @return bool
     */
    public function addItem(string $sku, int $customerId): bool;

    /**
     * Remove an item from the customers wishlist
     *
     * @param int $itemId
     * @return boolean
     * @throws NoSuchEntityException
     */
    public function removeItem(int $itemId, int $customerId): bool;
}
