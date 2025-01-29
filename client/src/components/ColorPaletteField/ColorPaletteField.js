import React, { Component } from 'react';
import PropTypes from 'prop-types';
import fieldHolder from '../../lib/FieldHolder';

class ColorPaletteField extends Component {
    constructor(props) {
        super(props);

        this.getItemKey = this.getItemKey.bind(this);
        this.getInputProps = this.getInputProps.bind(this);
        this.handleItemChange = this.handleItemChange.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.renderItem = this.renderItem.bind(this);
    }

    /**
     * Mirroring OptionsetField.getItemKey():
     * Generates a unique key/ID for each item, based on field ID + value or index.
     */
    getItemKey(item, index) {
        const value = item.value || `empty${index}`;
        return `${this.props.id}-${value}`;
    }

    /**
     * Combines the logic from OptionsetField's getOptionProps() and
     * OptionField's getInputProps(), using plain HTML.
     */
    getInputProps(item, index) {
        const id = this.getItemKey(item, index);
        const isChecked = `${this.props.value}` === `${item.value}`;

        return {
            id,
            name: this.props.name,
            type: 'radio',
            checked: isChecked,
            // If this field or the item is disabled/readOnly, disable the input
            disabled: this.props.disabled || this.props.readOnly || item.disabled,
            // We'll handle the 'onChange' event to replicate OptionField's logic
            onChange: this.handleItemChange,
            // Like OptionField, we store the "checked" value as 1
            value: 1,
        };
    }

    /**
     * Equivalent to OptionField.handleChange(),
     * but it delegates to our field-level handleChange with the item ID.
     */
    handleItemChange(event) {
        // If the field is readOnly/disabled, ignore changes
        if (this.props.readOnly || this.props.disabled) {
            event.preventDefault();
            return;
        }

        const { id, checked } = event.target;
        const value = checked ? 1 : 0;

        // We replicate OptionsetField.handleChange's approach
        // by calling a dedicated method with the field data
        this.handleChange(event, { id, value });
    }

    /**
     * Equivalent to OptionsetField.handleChange():
     * Finds the matching item in `this.props.source` and calls
     * `this.props.onChange(event, { id: ..., value: ... })`
     */
    handleChange(event, fieldData) {
        if (typeof this.props.onChange === 'function') {
            // Only proceed if we actually checked a radio (value=1)
            if (fieldData.value === 1) {
                // Find which item was clicked, matching the generated ID
                const sourceItem = (this.props.source || []).find((item, index) =>
                    this.getItemKey(item, index) === fieldData.id
                );

                if (sourceItem) {
                    this.props.onChange(event, {
                        id: this.props.id,
                        value: sourceItem.value,
                    });
                }
            }
        }
    }

    /**
     * Renders a single radio item, inlining the logic previously in OptionField's render().
     */
    renderItem(item, index) {
        const inputProps = this.getInputProps(item, index);
        const liDataAttrs = {};

        // If there's a title, set data-colorpalette-label on <li>
        if (item.title) {
            liDataAttrs['data-colorpalette-label'] = item.title;
        }

        // Build label ref to apply inline CSS, if any
        const labelRef = item.inlineStyle
            ? (el) => {
                if (el) {
                    el.setAttribute('style', item.inlineStyle);
                }
            }
            : null;

        // Collect label data attrs, e.g. data-colorpalette-sample-text
        const labelDataAttrs = {};
        if (item.sampleText) {
            labelDataAttrs['data-colorpalette-sample-text'] = item.sampleText;
        }

        return (
            <li
                key={inputProps.id}
                className="ColorPaletteField__color"
                {...liDataAttrs}
            >
                <input
                    className="ColorPaletteField__input"
                    {...inputProps}
                />
                <label
                    className="ColorPaletteField__label"
                    htmlFor={inputProps.id}
                    ref={labelRef}
                    {...labelDataAttrs}
                />
            </li>
        );
    }

    /**
     * Renders a <ul> containing a list of items
     */
    renderSource(items) {
        return (
            <ul className="ColorPaletteField__colors">
                {items.map((item, index) => this.renderItem(item, index))}
            </ul>
        );
    }

    /**
     * Main render: maps over source, calls renderItem for each
     */
    render() {
        const { groups, source } = this.props;

        // If we have groups, show grouped sections
        if (groups && groups.length) {
            return (
                <div className={`ColorPaletteField ${this.props.extraClass}`}>
                    {groups.map((group, groupIndex) => (
                        <div className={`ColorPaletteField__group ColorPaletteField__group--${groupIndex}`}>
                            {group.title && <h4 className="ColorPaletteField__groupTitle">{group.title}</h4>}
                            {this.renderSource(group.source || [])}
                        </div>
                    ))}
                </div>
            );
        }

        // Otherwise, fallback to a single source array
        if (!source) {
            return null;
        }

        return (
            <div className={`ColorPaletteField ${this.props.extraClass}`}>
                {this.renderSource(source)}
            </div>
        );
    }
}

ColorPaletteField.propTypes = {
    extraClass: PropTypes.string,
    itemClass: PropTypes.string,
    id: PropTypes.string,
    name: PropTypes.string.isRequired,
    source: PropTypes.arrayOf(
        PropTypes.shape({
            value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
            title: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
            disabled: PropTypes.bool,
            inlineStyle: PropTypes.string,
            sampleText: PropTypes.string,
        })
    ),
    onChange: PropTypes.func,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    readOnly: PropTypes.bool,
    disabled: PropTypes.bool,
    groups: PropTypes.arrayOf(
        PropTypes.shape({
            title: PropTypes.string,
            source: PropTypes.arrayOf(
                PropTypes.shape({
                    value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
                    title: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
                    disabled: PropTypes.bool,
                    inlineStyle: PropTypes.string,
                    sampleText: PropTypes.string,
                })
            ),
        }),
    )
};

ColorPaletteField.defaultProps = {
    extraClass: '',
    itemClass: '',
};

export { ColorPaletteField as Component };
export default fieldHolder(ColorPaletteField);
