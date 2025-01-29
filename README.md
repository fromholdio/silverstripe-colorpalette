# SilverStripe Color Palette Field

Provides a color picker field in SilverStripe allowing a user to select from defined selection of colors (palette)

Forked from heyday/silverstripe-colorpalette, applying PRs and fresh styling. 2.x branch is compatible as a direct replacement of the original repo's 2.x branch.

**As of 3.2.0, this module now contains a React component, enabling compatibility for the field with Elemental inline forms.**

The active 3.x branch diverges from the original with additional features and breaking changes:
- Provide text labels per color and have them displayed to users
- Set a full CSS background declaration per color rather than just a hex value (allowing for gradients/images/etc)
- Can set some text string like "Aa" which will be placed on top of the color box (optional)
- Set a CSS color value separate to the background value, which the text on top of the box will be colored (might have two different themes with same bg style but different text colour, for example)
- Improved 'selected' visual treatment
- Grouped field now subclasses the single version of the field and reduced repeated code

## Installation (with composer)

	$ composer require fromholdio/silverstripe-colorpalette

## Example

![Color Palette Example](resources/example_v3.png?raw=true)

## Usage

### Regular palette

```php
$fields->addFieldToTab(
    'Root.Main',
    Fromholdio\ColorPalette\Fields\ColorPaletteField::create(
        'BackgroundColor',
        'Background Color',
        [
            // still works
            'white' => '#fff',      // will be applied as 'background_css' value
            // new config options
            'black' => [
                'label' => 'Jet Black',     // displayed in field under color box
                'background_css' => '#111', // without ';', used to fill in color box
                'color_css' => '#FFFFFE',   // used to style the sample_text displayed on top of color box
                'sample_text' => 'Aa'       // if color_css is provided, this text displayed on top of color box
            ]
        ]
    )
);```

### Grouped Palette

```php
$fields->addFieldToTab(
    'Root.Main',
    Fromholdio\ColorPalette\Fields\GroupedColorPaletteField::create(
        'BackgroundColor',
        'Background Color',
        [
            'Group title' => [
                'black' => '#000',
                'white' => [
                    'label' => 'White',
                    'background_css' => '#FFF',
                    'color_css' => '#000',
                    'sample_text' => 'Aa'
                ]
            ],
            'Another group title' => [
                'red' => '#ff0'
            ]
        ]
    )
);
```

## License

SilverStripe Color Palette Field is licensed under an [MIT license](http://fromholdio.mit-license.org/)
