<div class="ColorPaletteField $extraClass" $AttributesHTML('class') >
    <ul class="ColorPaletteField__colors">
        <% loop $Options %>
            <% include Fromholdio\ColorPalette\Fields\ColorPaletteFieldOption %>
        <% end_loop %>
    </ul>
</div>
