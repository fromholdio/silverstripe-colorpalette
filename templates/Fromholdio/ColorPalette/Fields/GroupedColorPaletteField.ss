<div class="ColorPaletteField $extraClass" $AttributesHTML('class') >
    <% loop $Groups %>
        <div class="ColorPaletteField__group ColorPaletteField__group--{$Name}">
            <h4 class="ColorPaletteField__title">$Title</h4>
            <ul class="ColorPaletteField__colors">
                <% loop $Options %>
                    <% include Fromholdio\ColorPaletteField\Fields\ColorPaletteFieldOption %>
                <% end_loop %>
            </ul>
        </div>
    <% end_loop %>
</div>
