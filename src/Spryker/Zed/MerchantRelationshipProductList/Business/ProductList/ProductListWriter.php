<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipProductList\Business\ProductList;

use Generated\Shared\Transfer\MerchantRelationshipTransfer;
use Generated\Shared\Transfer\ProductListCollectionTransfer;
use Spryker\Zed\MerchantRelationshipProductList\Dependency\Facade\MerchantRelationshipProductListToProductListFacadeInterface;
use Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListEntityManagerInterface;
use Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListRepositoryInterface;

class ProductListWriter implements ProductListWriterInterface
{
    /**
     * @var \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListRepositoryInterface
     */
    protected $merchantRelationshipProductListRepository;

    /**
     * @var \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListEntityManagerInterface
     */
    protected $merchantRelationshipProductListEntityManager;

    /**
     * @var \Spryker\Zed\MerchantRelationshipProductList\Dependency\Facade\MerchantRelationshipProductListToProductListFacadeInterface
     */
    protected $productListFacade;

    /**
     * @param \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListRepositoryInterface $merchantRelationshipProductListRepository
     * @param \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListEntityManagerInterface $merchantRelationshipProductListEntityManager
     * @param \Spryker\Zed\MerchantRelationshipProductList\Dependency\Facade\MerchantRelationshipProductListToProductListFacadeInterface $productListFacade
     */
    public function __construct(
        MerchantRelationshipProductListRepositoryInterface $merchantRelationshipProductListRepository,
        MerchantRelationshipProductListEntityManagerInterface $merchantRelationshipProductListEntityManager,
        MerchantRelationshipProductListToProductListFacadeInterface $productListFacade
    ) {
        $this->merchantRelationshipProductListRepository = $merchantRelationshipProductListRepository;
        $this->merchantRelationshipProductListEntityManager = $merchantRelationshipProductListEntityManager;
        $this->productListFacade = $productListFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return void
     */
    public function deleteProductListsByMerchantRelationship(
        MerchantRelationshipTransfer $merchantRelationshipTransfer
    ): void {
        $merchantRelationshipTransfer->requireIdMerchantRelationship();

        $productListCollectionTransfer = $this->merchantRelationshipProductListRepository
            ->findProductListCollectionByIdMerchantRelationship($merchantRelationshipTransfer->getIdMerchantRelationship());

        foreach ($productListCollectionTransfer->getProductLists() as $productListTransfer) {
            $this->productListFacade->removeProductList($productListTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer
     */
    public function updateProductListMerchantRelationshipAssignments(MerchantRelationshipTransfer $merchantRelationshipTransfer): MerchantRelationshipTransfer
    {
        $productListCollectionTransfer = $this->merchantRelationshipProductListRepository
            ->findProductListCollectionByIdMerchantRelationship($merchantRelationshipTransfer->getIdMerchantRelationship());

        $productListIds = $this->cleanUpProductLists(
            $productListCollectionTransfer,
            $merchantRelationshipTransfer->getProductListIds(),
        );

        $productListTransfers = $this->merchantRelationshipProductListEntityManager->assignProductListsToMerchantRelationship(
            $productListIds,
            $merchantRelationshipTransfer->getIdMerchantRelationship(),
        );

        $merchantRelationshipTransfer->setProductLists($productListTransfers);

        return $merchantRelationshipTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return void
     */
    public function clearMerchantRelationshipFromProductLists(
        MerchantRelationshipTransfer $merchantRelationshipTransfer
    ): void {
        $merchantRelationshipTransfer->requireIdMerchantRelationship();

        $productListCollectionTransfer = $this->merchantRelationshipProductListRepository
            ->findProductListCollectionByIdMerchantRelationship($merchantRelationshipTransfer->getIdMerchantRelationship());

        $this->cleanUpProductLists(
            $productListCollectionTransfer,
            $merchantRelationshipTransfer->getProductListIds(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListCollectionTransfer $productListCollectionTransfer
     * @param array $productListIds
     *
     * @return array<int>
     */
    protected function cleanUpProductLists(ProductListCollectionTransfer $productListCollectionTransfer, array $productListIds): array
    {
        foreach ($productListCollectionTransfer->getProductLists() as $productListTransfer) {
            if (in_array($productListTransfer->getIdProductList(), $productListIds)) {
                continue;
            }

            $this->merchantRelationshipProductListEntityManager->clearProductListMerchantRelationship(
                $productListTransfer->getIdProductList(),
            );

            unset($productListIds[$productListTransfer->getIdProductList()]);
        }

        return $productListIds;
    }
}
