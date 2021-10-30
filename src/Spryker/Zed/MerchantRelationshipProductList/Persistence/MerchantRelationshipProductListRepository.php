<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipProductList\Persistence;

use Generated\Shared\Transfer\MerchantRelationshipTransfer;
use Generated\Shared\Transfer\ProductListCollectionTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Orm\Zed\ProductList\Persistence\Map\SpyProductListTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \Spryker\Zed\MerchantRelationshipProductList\Persistence\MerchantRelationshipProductListPersistenceFactory getFactory()
 */
class MerchantRelationshipProductListRepository extends AbstractRepository implements MerchantRelationshipProductListRepositoryInterface
{
    /**
     * @module ProductList
     * @module MerchantRelationship
     *
     * @param int $idCompanyBusinessUnit
     *
     * @return \Generated\Shared\Transfer\ProductListCollectionTransfer
     */
    public function getProductListCollectionByIdCompanyBusinessUnit(int $idCompanyBusinessUnit): ProductListCollectionTransfer
    {
        /** @var array<\Orm\Zed\ProductList\Persistence\SpyProductList> $productListEntities */
        $productListEntities = $this->getFactory()
            ->getProductListQuery()
            ->useSpyMerchantRelationshipQuery()
                ->useSpyMerchantRelationshipToCompanyBusinessUnitQuery()
                    ->filterByFkCompanyBusinessUnit($idCompanyBusinessUnit)
                ->endUse()
            ->endUse()
            ->find();

        $productListCollectionTransfer = new ProductListCollectionTransfer();

        $merchantRelationshipProductListMapper = $this->getFactory()->createMerchantRelationshipProductListMapper();
        foreach ($productListEntities as $productListEntity) {
            $productListCollectionTransfer->addProductList(
                $merchantRelationshipProductListMapper->mapProductList($productListEntity, new ProductListTransfer()),
            );
        }

        return $productListCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer $merchantRelationshipTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListCollectionTransfer
     */
    public function getAvailableProductListsForMerchantRelationship(MerchantRelationshipTransfer $merchantRelationshipTransfer): ProductListCollectionTransfer
    {
        $productListQuery = $this->getFactory()
            ->getProductListQuery()
            ->useSpyMerchantRelationshipQuery()
                ->filterByIdMerchantRelationship(null, Criteria::ISNULL)
            ->endUse();

        if ($merchantRelationshipTransfer->getIdMerchantRelationship()) {
            $productListQuery = $this->getFactory()
                ->getProductListQuery()
                ->useSpyMerchantRelationshipQuery()
                    ->filterByIdMerchantRelationship(null, Criteria::ISNULL)
                    ->_or()
                    ->filterByIdMerchantRelationship($merchantRelationshipTransfer->getIdMerchantRelationship())
                ->endUse();
        }

        /** @var \Propel\Runtime\Collection\ObjectCollection|\Orm\Zed\ProductList\Persistence\SpyProductList[] $productListEntities */
        $productListEntities = $productListQuery->find();

        return $this->getFactory()
            ->createMerchantRelationshipProductListMapper()
            ->mapProductListCollection($productListEntities, new ProductListCollectionTransfer());
    }

    /**
     * @module ProductList
     *
     * @param int $idMerchantRelationship
     *
     * @return \Generated\Shared\Transfer\ProductListCollectionTransfer
     */
    public function findProductListCollectionByIdMerchantRelationship(int $idMerchantRelationship): ProductListCollectionTransfer
    {
        $productListEntities = $this->getFactory()
            ->getProductListQuery()
            ->filterByFkMerchantRelationship($idMerchantRelationship)
            ->find();

        $productListCollectionTransfer = $this->getFactory()
            ->createMerchantRelationshipProductListMapper()
            ->mapProductListCollection(
                $productListEntities,
                new ProductListCollectionTransfer(),
            );

        return $productListCollectionTransfer;
    }

    /**
     * @param int $idProductList
     *
     * @return array<int>
     */
    public function getMerchantRelationshipIdsByProductListId(int $idProductList): array
    {
        return $this->getFactory()
            ->getProductListQuery()
            ->filterByIdProductList($idProductList)
            ->select(SpyProductListTableMap::COL_FK_MERCHANT_RELATIONSHIP)
            ->find()
            ->toArray();
    }
}
