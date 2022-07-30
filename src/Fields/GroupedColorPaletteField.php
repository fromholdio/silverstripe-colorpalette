<?php

namespace Fromholdio\ColorPalette\Fields;

use SilverStripe\Core\Convert;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\SingleLookupField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * $source = [
 *      'group name' => [
 *          'black' => '#000',
 *          'white' => [
 *              'label' => 'White',
 *              'background_css' => '#000',
 *              'color_css' => '#FFF', // optional
 *              'sample_text' => 'Aa' // optional
 *          ]
 *      ],
 *      'Another group' => [
 *          'red' => '#ff0',
 *          'blue' => 'blue'
 *      ]
 * ];
 */
class GroupedColorPaletteField extends ColorPaletteField
{
    protected array $groupsData = [];

    public function setSource($source): self
    {
        $flatSource = [];
        $groupsData = [];
        foreach ($source as $groupTitle => $groupData)
        {
            if (!empty($groupTitle) && !empty($groupData))
            {
                $groupName = Convert::raw2htmlid($groupTitle);
                $groupsData[$groupName] = [
                    'title' => $groupTitle,
                    'options' => []
                ];
                foreach ($groupData as $optionValue => $optionData)
                {
                    if (is_array($optionData)) {
                        if (!empty($optionData['background_css'])) {
                            $groupsData[$groupName]['options'][] = $optionValue;
                            $flatSource[$optionValue] = $optionData;
                        }
                    }
                    elseif (!empty($optionData)) {
                        $groupsData[$groupName]['options'][] = $optionValue;
                        $flatSource[$optionValue] = $optionData;
                    }
                }
                $groupOptions = $groupsData[$groupName]['options'];
                if (empty($groupOptions)) {
                    unset($groupsData[$groupName]);
                }
            }
        }
        $this->groupsData = $groupsData;
        return parent::setSource($flatSource);
    }

    public function Field($properties = [])
    {
        $groups = ArrayList::create();
        $groupsData = $this->groupsData;
        foreach ($groupsData as $groupName => $groupData)
        {
            $group = ArrayData::create();
            $group->setField('Title', $groupData['title']);
            $group->setField('Name', $groupName);

            $options = ArrayList::create();
            $optionValues = $groupData['options'];
            $odd = false;
            foreach ($optionValues as $optionValue)
            {
                $odd = !$odd;
                $title = $this->getOptionTitle($optionValue);
                $options->push(
                    $this->getFieldOption($optionValue, $title, $odd)
                );
            }
            $group->setField('Options', $options);
            $groups->push($group);
        }

        $properties = array_merge($properties, [
            'Groups' => $groups
        ]);

        Requirements::css('fromholdio/silverstripe-colorpalette:css/styles.css');
        return FormField::Field($properties);
    }

    public function Type(): string
    {
        return 'groupedcolorpalettefield ' . parent::Type();
    }

    protected function getOptionGroupTitle($value): ?string
    {
        $title = null;
        $groupsData = $this->groupsData;
        foreach ($groupsData as $groupName => $groupData) {
            if (in_array($value, $groupData['options'])) {
                $title = $groupData['title'];
                break;
            }
        }
        return $title;
    }

    public function performReadonlyTransformation(): SingleLookupField
    {
        $field = parent::performReadonlyTransformation();
        if (is_a($field, ColorPaletteField_Readonly::class)) {
            $field->addOptionData('GroupTitle', $this->getOptionGroupTitle($this->Value()));
        }
        return $field;
    }
}
