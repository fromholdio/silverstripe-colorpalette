<?php

namespace Fromholdio\ColorPalette\Fields;

use SilverStripe\Forms\FormField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\SingleLookupField;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * $source = [
 *      'black' => '#000',
 *      'white' => [
 *          'label' => 'White',
 *          'background_css' => '#000',
 *          'color_css' => '#FFF', // optional
 *          'sample_text' => 'Aa' // optional
 *      ]
 * ];
 */
class ColorPaletteField extends OptionsetField
{
    private static $sample_text_string = 'Aa';

    protected $schemaComponent = 'ColorPaletteField';

    protected $schemaDataType = FormField::SCHEMA_DATA_TYPE_SINGLESELECT;

    protected array $optionsData = [];
    protected ?string $sampleText = null;

    public function __construct(
        $name,
        $title = null,
        $source = [],
        $value = null,
        ?string $sampleText = null
    ) {
        parent::__construct($name, $title, $source, $value);
        $this->setSampleText($sampleText);
    }

    public function getSchemaStateDefaults()
    {
        $data = parent::getSchemaStateDefaults();

        $data['value'] = $this->getDefaultValue();
        unset($data['source']);

        $disabled = $this->getDisabledItems();

        $source = $this->getSource();
        $data['source'] = (is_array($source))
            ? array_map(function ($value, $title) use ($disabled) {
                $item = [
                    'value' => $value,
                    'title' => $title,
                    'disabled' => in_array($value, $disabled),
                    'inlineStyle' => '',
                    'sampleText' => '',
                ];
                $sampleText = $this->getOptionSampleText($value);
                if (!empty($sampleText)) {
                    $item['sampleText'] = $sampleText;
                }
                $inlineStyle = $this->getOptionInlineStyle($value);
                if (!empty($inlineStyle)) {
                    $item['inlineStyle'] = $inlineStyle;
                }
                return $item;
            }, array_keys($source), $source)
            : [];

        return $data;
    }

    public function setSource($source): self
    {
        $newSource = [];
        $optionsData = [];
        foreach ($source as $optionValue => $optionData)
        {
            if (is_array($optionData)) {
                $label = $optionData['label'] ?? null;
                $backgroundCSS = $optionData['background_css'] ?? null;
                if (!empty($backgroundCSS)) {
                    $title = empty($label) ? $backgroundCSS : $label;
                    $optionsData[$optionValue] = $optionData;
                    $newSource[$optionValue] = $title;
                }
            }
            elseif (!empty($optionData)) {
                $optionsData[$optionValue] = ['background_css' => $optionData];
                $newSource[$optionValue] = $optionData;
            }
        }
        $this->source = $newSource;
        $this->optionsData = $optionsData;
        return $this;
    }

    protected function getFieldOption($value, $title, $odd): ArrayData
    {
        $option = parent::getFieldOption($value, $title, $odd);
        $option->setField('BackgroundCSS', $this->getOptionBackgroundCSS($value));
        $option->setField('ColorCSS', $this->getOptionColorCSS($value));
        $option->setField('SampleText', $this->getOptionSampleText($value));
        $option->setField('Label', $this->getOptionLabel($value));
        return $option;
    }

    protected function getOptionDataValue($value, $key): ?string
    {
        $data = $this->optionsData;
        return $data[$value][$key] ?? null;
    }

    protected function getOptionBackgroundCSS($value): ?string
    {
        return $this->getOptionDataValue($value,'background_css');
    }

    protected function getOptionColorCSS($value): ?string
    {
        return $this->getOptionDataValue($value,'color_css');
    }

    protected function getOptionInlineStyle($value): ?string
    {
        $css = '';
        $background = $this->getOptionBackgroundCSS($value);
        if (!empty($background)) {
            $css .= 'background:' . $background . ';';
        }
        $color = $this->getOptionColorCSS($value);
        if (!empty($color)) {
            $css .= 'color:' . $color . ';';
        }
        return empty($css) ? null : $css;
    }

    protected function getOptionSampleText($value): ?string
    {
        $text = $this->getOptionDataValue($value, 'sample_text');
        if ($text === false) {
            $text = null;
        }
        elseif (empty($text)) {
            $text = $this->getSampleText();
        }
        return $text;
    }

    protected function getOptionLabel($value): ?string
    {
        return $this->getOptionDataValue($value,'label');
    }

    protected function getOptionTitle($value): ?string
    {
        $label = $this->getOptionLabel($value);
        if (empty($label)) {
            $label = $this->getOptionBackgroundCSS($value);
        }
        return $label;
    }

    public function setSampleText(?string $text = null): self
    {
        if (is_null($text)) {
            $text = static::config()->get('sample_text_string');
        }
        $this->extend('updateSampleText', $text);
        $this->sampleText = $text;
        return $this;
    }

    public function getSampleText(): ?string
    {
        return $this->sampleText;
    }

    public function Type(): string
    {
        return 'colorpalettefield';
    }

    public function performReadonlyTransformation(): SingleLookupField
    {
        $value = $this->Value();
        if (!empty($value))
        {
            /** @var ColorPaletteField_Readonly $field */
            $field = $this->castedCopy(ColorPaletteField_Readonly::class);
            $field->setSource($this->getSource());
            $field->setReadonly(true);
            $field->addOptionData('BackgroundCSS', $this->getOptionBackgroundCSS($value));
            $field->addOptionData('ColorCSS', $this->getOptionColorCSS($value));
            $field->addOptionData('SampleText', $this->getOptionSampleText($value));
            $field->addOptionData('Label', $this->getOptionLabel($value));
            $field->addOptionData('Title', $this->getOptionTitle($value));
        }
        else {
            $field = parent::performReadonlyTransformation();
        }
        return $field;
    }
}
