<?php

// Add attributes to all attribute sets

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Attributes must be created already
$attributes = [
    'attribute1',
    'attribute2',
    'attribute3',
    'attribute4'
];

use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Model\Product;

require __DIR__ . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get(Magento\Framework\App\State::class);
$state->setAreaCode('adminhtml');

/* Attribute assign logic */
$eavSetup = $objectManager->create(\Magento\Eav\Setup\EavSetup::class);
$config = $objectManager->create('Magento\Catalog\Model\Config');

$entityTypeId = $eavSetup->getEntityTypeId(Product::ENTITY);
$attributeSetIds = $eavSetup->getAllAttributeSetIds($entityTypeId);

foreach ($attributeSetIds as $attributeSetId) {
    if ($attributeSetId) {
        $i = 500;
        foreach ($attributes as $attribute) {
            echo "Assigning {$attribute} to attribute set {$attributeSetId}" . PHP_EOL;

            $eavSetup->addAttributeToGroup(
                Product::ENTITY,
                $attributeSetId,
                'General', // group
                $attribute,
                $i // sort order
            );

            $i++;
        }
    }
}


