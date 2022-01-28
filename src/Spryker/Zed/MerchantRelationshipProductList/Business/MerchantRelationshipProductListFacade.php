<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipProductList\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MerchantRelationshipTransfer;
use Generated\Shared\Transfer\MerchantRelationshipValidationErrorCollectionTransfer;
use Generated\Shared\Transfer\ProductListCollectionTransfer;
use Generated\Shared\Transfer\ProductListResponseTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\MerchantRelationshipProductList\Business\MerchantRelationshipProductListBusinessFactory getFactory()
 * @method \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListRepositoryInterface getRepository()
 */
class MerchantRelationshipProductListFacade extends AbstractFacade implements MerchantRelationshipProductListFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function expandCustomerTransferWithProductListIds(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->getFactory()
            ->createCustomerExpander()
            ->expandCustomerTransferWithProductListIds($customerTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return void
     */
    public function deleteProductListsByMerchantRelationship(MerchantRelationshipTransfer $merchantRelationshipTransfer): void
    {
        $this->getFactory()
            ->createProductListWriter()
            ->deleteProductListsByMerchantRelationship($merchantRelationshipTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListCollectionTransfer
     */
    public function getAvailableProductListsForMerchantRelationship(MerchantRelationshipTransfer $merchantRelationshipTransfer): ProductListCollectionTransfer
    {
        return $this->getRepository()->getAvailableProductListsForMerchantRelationship($merchantRelationshipTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer
     */
    public function updateProductListMerchantRelationshipAssignments(MerchantRelationshipTransfer $merchantRelationshipTransfer): MerchantRelationshipTransfer
    {
        return $this->getFactory()
            ->createProductListWriter()
            ->updateProductListMerchantRelationshipAssignments($merchantRelationshipTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListResponseTransfer
     */
    public function isProductListDeletable(ProductListTransfer $productListTransfer): ProductListResponseTransfer
    {
        return $this->getFactory()
            ->createProductListDeleteChecker()
            ->isProductListDeletable($productListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductList
     *
     * @return array<int>
     */
    public function getMerchantRelationshipIdsByProductListId(int $idProductList): array
    {
        return $this->getRepository()->getMerchantRelationshipIdsByProductListId($idProductList);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return void
     */
    public function clearMerchantRelationshipFromProductLists(
        MerchantRelationshipTransfer $merchantRelationshipTransfer
    ): void {
        $this->getFactory()
            ->createProductListWriter()
            ->clearMerchantRelationshipFromProductLists($merchantRelationshipTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     * @param \Generated\Shared\Transfer\MerchantRelationshipValidationErrorCollectionTransfer $merchantRelationshipValidationErrorCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipValidationErrorCollectionTransfer
     */
    public function validateMerchantRelationshipProductList(
        MerchantRelationshipTransfer $merchantRelationshipTransfer,
        MerchantRelationshipValidationErrorCollectionTransfer $merchantRelationshipValidationErrorCollectionTransfer
    ): MerchantRelationshipValidationErrorCollectionTransfer {
        return $this->getFactory()
            ->createMerchantRelationshipProductListValidator()
            ->validate(
                $merchantRelationshipTransfer,
                $merchantRelationshipValidationErrorCollectionTransfer,
            );
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantRelationshipTransfer
     */
    public function expandMerchantRelationship(MerchantRelationshipTransfer $merchantRelationshipTransfer): MerchantRelationshipTransfer
    {
        return $this->getFactory()
            ->createMerchantRelationshipProductListExpander()
            ->expandMerchantRelationship($merchantRelationshipTransfer);
    }
}
