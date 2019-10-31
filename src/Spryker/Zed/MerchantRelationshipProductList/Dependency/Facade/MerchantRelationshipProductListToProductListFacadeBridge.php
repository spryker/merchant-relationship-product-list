<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipProductList\Dependency\Facade;

use Generated\Shared\Transfer\ProductListResponseTransfer;
use Generated\Shared\Transfer\ProductListTransfer;

class MerchantRelationshipProductListToProductListFacadeBridge implements MerchantRelationshipProductListToProductListFacadeInterface
{
    /**
     * @var \Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected $productListFacade;

    /**
     * @param \Spryker\Zed\ProductList\Business\ProductListFacadeInterface $productListFacade
     */
    public function __construct($productListFacade)
    {
        $this->productListFacade = $productListFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListResponseTransfer
     */
    public function updateProductList(ProductListTransfer $productListTransfer): ProductListResponseTransfer
    {
        return $this->productListFacade->updateProductList($productListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListResponseTransfer
     */
    public function removeProductList(ProductListTransfer $productListTransfer): ProductListResponseTransfer
    {
        return $this->productListFacade->removeProductList($productListTransfer);
    }
}
