# SilverStripe Color Palette Field

Provides a color picker field in SilverStripe allowing a user to select from defined selection of colors (palette)

Forked from heyday/silverstripe-colorpalette, applying PRs and fresh styling. 2.x branch is compatible as a direct replacement of the original repo's 2.x branch.

The active 3.x branch diverges from the original with additional features and breaking changes.

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
		array(
			'White' => '#fff',
			'Black' => '#000'
		)
	)
);
```

### Grouped Palette

```php
$fields->addFieldToTab(
	'Root.Main',
	Fromholdio\ColorPalette\Fields\GroupedColorPaletteField::create(
		'BackgroundColor',
		'Background Color',
		array(
			'Primary Palette' => array(
				'White' => '#fff',
				'Black' => '#000'
			),
			'Secondary Palette' => array(
				'Blue' => 'blue',
				'Red' => 'red'
			)
		)
	)
);
```

## License

SilverStripe Color Palette Field is licensed under an [MIT license](http://heyday.mit-license.org/)
