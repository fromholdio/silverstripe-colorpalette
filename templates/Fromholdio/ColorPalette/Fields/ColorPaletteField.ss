<div class="ColorPaletteField $extraClass" $AttributesHTML('class') >
    <ul class="ColorPaletteField__colors">
        <% loop $Options %>
            <% include PPIU\Web\Palette\ColorPaletteFieldOption %>
        <% end_loop %>
    </ul>
</div>
