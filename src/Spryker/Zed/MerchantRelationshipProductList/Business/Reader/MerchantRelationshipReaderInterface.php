<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipProductList\Business\Reader;

use Generated\Shared\Transfer\ProductListTransfer;

interface MerchantRelationshipReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer $productListTransfer
     *
     * @return array<\Generated\Shared\Transfer\MerchantRelationshipTransfer>
     */
    public function getMerchantRelationshipsByProductList(ProductListTransfer $productListTransfer): array;
}
