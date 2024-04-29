<?php
/**
 * Dummy driver for Omnireceipt fiscal receipt processing library
 *
 * @link      https://github.com/omnireceipt/common
 * @package   omnireceipt/common
 * @license   MIT
 * @copyright Copyright (c) 2024, Alexander Arhitov, clgsru@gmail.com
 */

namespace Omnireceipt\Common\Tests\Fixtures\Gateway\Dummy;

use Omnireceipt\Common\AbstractGateway;
use Omnireceipt\Common\Tests\Fixtures\Gateway\Dummy\Http\CreateReceiptRequest;
use Omnireceipt\Common\Tests\Fixtures\Gateway\Dummy\Http\DetailsReceiptRequest;
use Omnireceipt\Common\Tests\Fixtures\Gateway\Dummy\Http\ListReceiptsRequest;

/**
 * @method self setKeyAccess(string $value)
 * @method string getKeyAccess()
 * @method self setUserID(string $value)
 * @method string getUserID()
 * @method self setStoreUUID(string $value)
 * @method string getStoreUUID()
 */
class Gateway extends AbstractGateway
{

    public function getName(): string
    {
        return 'Dummy';
    }

    public static function getClassRequestNameCreateReceipt(): string
    {
        return CreateReceiptRequest::class;
    }

    public static function getClassRequestNameListReceipts(): string
    {
        return ListReceiptsRequest::class;
    }

    public static function getClassRequestNameDetailsReceipt(): string
    {
        return DetailsReceiptRequest::class;
    }
}