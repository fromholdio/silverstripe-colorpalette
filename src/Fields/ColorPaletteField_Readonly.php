<?php

namespace Fromholdio\ColorPalette\Fields;

use SilverStripe\Forms\SingleLookupField;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

class ColorPaletteField_Readonly extends SingleLookupField
{
    protected array $optionData = [];

    public function Field($properties = [])
    {
        $this->setTemplate(static::class);
        return parent::Field($properties);
    }

    public function addOptionData($key, $value): self
    {
        $this->optionData[$key] = $value;
        return $this;
    }

    public function getOptionData(): ArrayData
    {
        return ArrayData::create($this->optionData);
    }

    public function Type(): string
    {
        return 'colorpalettefield-readonly colorpalettefield';
    }
}
