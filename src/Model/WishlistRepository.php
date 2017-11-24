<?php
/**
 * @copyright: Copyright © 2017 mediaman GmbH. All rights reserved.
 * @see LICENSE.txt
 */

namespace Euknyaz\WishlistApi\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Request\Http;
use Magento\Integration\Model\Oauth\Token;
use Magento\Integration\Model\Oauth\TokenFactory;
use Magento\Wishlist\Model\ResourceModel\Item as ItemResource;
use Euknyaz\WishlistApi\Api\WishlistInterface;
use Euknyaz\WishlistApi\Api\WishlistRepositoryInterface;

/**
 * Class WishlistRepository
 * @package Euknyaz\WishlistApi\Model
 */
class WishlistRepository implements WishlistRepositoryInterface
{

    /**
     * @var Http
     */
    private $http;

    /**
     * @var TokenFactory
     */
    private $tokenFactory;

    /**
     * @var WishlistFactory
     */
    private $wishlistFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ItemResource
     */
    private $itemResource;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * WishlistRepository constructor.
     * @param Http $http
     * @param TokenFactory $tokenFactory
     * @param WishlistFactory $wishlistFactory
     * @param ProductRepositoryInterface $productRepository
     * @param ItemResource $itemResource
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Http $http,
        TokenFactory $tokenFactory,
        WishlistFactory $wishlistFactory,
        ProductRepositoryInterface $productRepository,
        ItemResource $itemResource,
        CustomerSession $customerSession
    ) {
        $this->http = $http;
        $this->tokenFactory = $tokenFactory;
        $this->wishlistFactory = $wishlistFactory;
        $this->productRepository = $productRepository;
        $this->itemResource = $itemResource;
        $this->customerSession = $customerSession;
    }

    /**
     * @inheritdoc
     */
    private function getCurrentCustomerId()
    {
      // Retrieve $customerId from session
      $customerId = $this->customerSession->getCustomerId();

      // If there is no $customerId in session,
      // try to authenticate and retrieve from token
      if (!$customerId) {
          $authorizationHeader = $this->http->getHeader('Authorization');

          $tokenParts = explode('Bearer', $authorizationHeader);
          $tokenPayload = trim(array_pop($tokenParts));

          /** @var Token $token */
          $token = $this->tokenFactory->create();
          $token->loadByToken($tokenPayload);

          $customerId = $token->getCustomerId();
      }
      return $customerId;
    }
    /**
     * @inheritdoc
     */
    public function getCurrentWishlist(): WishlistInterface
    {
        $customerId = 0; // retrieve current customer id
        return $this->getCustomerWishlist($customerId);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerWishlist(int $customerId): WishlistInterface
    {
        if (!$customerId) {
            $customerId = $this->getCurrentCustomerId();
        }

        // TODO: verify that current session has admin access permissions
        // to access any customer record

        // TODO: Verify that customer with $customerId really exists
        /** @var Wishlist $wishlist */
        $wishlist = $this->wishlistFactory->create();
        $wishlist->loadByCustomerId($customerId);

        if (!$wishlist->getId()) {
            $wishlist->setCustomerId($customerId);
            $wishlist->getResource()->save($wishlist);
        }

        return $wishlist;
    }

    /**
     * @inheritdoc
     */
    public function addItem(string $sku, int $customerId = 0): bool
    {
        $product = $this->productRepository->get($sku);
        $wishlist = $this->getCustomerWishlist($customerId); // current by default

        $wishlist->addNewItem($product);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function removeItem(int $itemId, int $customerId = 0): bool
    {
        $wishlist = $this->getCustomerWishlist($customerId); // current by default

        $item = $wishlist->getItem($itemId);
        if (!$item) {
            return false;
        }

        $this->itemResource->delete($item);

        return true;
    }
}
