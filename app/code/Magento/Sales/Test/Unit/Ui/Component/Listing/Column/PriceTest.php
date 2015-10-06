<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sales\Test\Unit\Ui\Component\Listing\Column;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Sales\Ui\Component\Listing\Column\Price;

/**
 * Class PriceTest
 */
class PriceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Price
     */
    protected $model;

    /**
     * @var PriceCurrencyInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priceFormatterMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->priceFormatterMock = $this->getMockForAbstractClass('Magento\Framework\Pricing\PriceCurrencyInterface');
        $this->model = $objectManager->getObject(
            'Magento\Sales\Ui\Component\Listing\Column\Price',
            ['priceFormatter' => $this->priceFormatterMock]
        );
    }

    public function testPrepareDataSource()
    {
        $itemName = 'itemName';
        $oldItemValue = 'oldItemValue';
        $newItemValue = 'newItemValue';
        $dataSource = [
            'data' => [
                'items' => [
                    [$itemName => $oldItemValue]
                ]
            ]
        ];

        $this->priceFormatterMock->expects($this->once())
            ->method('format')
            ->with($oldItemValue, false)
            ->willReturn($newItemValue);

        $this->model->setData('name', $itemName);
        $dataSource = $this->model->prepareDataSource($dataSource);
        $this->assertEquals($newItemValue, $dataSource['data']['items'][0][$itemName]);
    }
}
