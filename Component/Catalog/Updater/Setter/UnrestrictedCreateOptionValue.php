<?php
namespace Niji\AutoAttributeOptionsSetterBundle\Component\Catalog\Updater\Setter;
use Akeneo\Tool\Bundle\StorageUtilsBundle\Doctrine\Common\Saver\BaseSaver;
use Akeneo\Tool\Component\StorageUtils\Factory\SimpleFactoryInterface;
use Akeneo\Pim\Structure\Component\Updater\AttributeOptionUpdater;
use Akeneo\Tool\Bundle\StorageUtilsBundle\Doctrine\Common\Detacher\ObjectDetacher;
class UnrestrictedCreateOptionValue
{
    /** @var SimpleFactoryInterface */
    protected $optionValueFactory;
    /**
     * @var ObjectDetacher
     */
    protected $objectDetacher;
    /**
     * UnrestrictedCreateOptionValue constructor.
     * @param SimpleFactoryInterface $optionValueFactory
     * @param AttributeOptionUpdater $attributeOptionUpdater
     * @param BaseSaver $baseSaver
     */
    public function __construct(
        SimpleFactoryInterface $optionValueFactory,
        AttributeOptionUpdater $attributeOptionUpdater,
        BaseSaver $baseSaver,
        ObjectDetacher $objectDetacher
    )
    {
        $this->optionValueFactory = $optionValueFactory;
        $this->attributeOptionUpdater = $attributeOptionUpdater;
        $this->baseSaver = $baseSaver;
        $this->objectDetacher = $objectDetacher;
    }
    /**
     * @param $codeAttribute
     * @param $code
     */
    public function createOptionValue($codeAttribute, $code, $label) {
        $attributeOptionValue = $this->optionValueFactory->create();
        $tab = [
            'attribute' => $codeAttribute,
            'code' => $code,
            'sort_order' => 2,
            'labels' => [
                'fr_FR' => $label,
            ]
        ];
        $this->attributeOptionUpdater->update($attributeOptionValue, $tab, []);
        $this->baseSaver->save($attributeOptionValue, []);
        $this->objectDetacher->detach($attributeOptionValue);
    }
}