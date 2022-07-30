<div class="ColorPaletteField ColorPaletteField--readonly $extraClass" $AttributesHTML('class') >
    <% if $GroupTitle %>
        <div class="ColorPaletteField__group">
            <h4 class="ColorPaletteField__title">$Title</h4>
    <% end_if %>
    <ul class="ColorPaletteField__colors">
        <% include Fromholdio\ColorPaletteField\Fields\ColorPaletteFieldOption_Readonly %>
    </ul>
    <% if $GroupTitle %>
        </div>
    <% end_if %>
</div>
