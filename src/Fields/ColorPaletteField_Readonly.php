<?php

namespace Fromholdio\ColorPalette\Fields;

use SilverStripe\Forms\LookupField;
use SilverStripe\View\Requirements;

class ColorPaletteField_Readonly extends LookupField
{
    protected ?string $groupTitle = null;

    public function Field($properties = [])
    {
        Requirements::css('fromholdio/silverstripe-colorpalette:css/ColorPaletteField.css');
        return parent::Field($properties);
    }

    public function setGroupTitle(?string $title): self
    {
        $this->groupTitle = $title;
        return $this;
    }

    public function getGroupTitle(): ?string
    {
        return $this->groupTitle;
    }
}
