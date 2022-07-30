<div class="ColorPaletteField ColorPaletteField--readonly $extraClass" $AttributesHTML('class') >
    <% if $OptionData.GroupTitle %>
        <div class="ColorPaletteField__group">
            <h4 class="ColorPaletteField__title">$OptionData.GroupTitle</h4>
    <% end_if %>
    <ul class="ColorPaletteField__colors">
        <li class="ColorPaletteField__color $Class">
            <input class="ColorPaletteField__input"
                   id="$ID"
                   name="$Name"
                   type="hidden"
                   value="$InputValue" />
            <label class="ColorPaletteField__label"
                   for="$ID"
                   style="<% if $OptionData.BackgroundCSS %>background: {$OptionData.BackgroundCSS};<% end_if %> <% if $OptionData.ColorCSS %>color: {$OptionData.ColorCSS};<% end_if %>"
                <% if $OptionData.Label %>data-colorpalette-label="$OptionData.Label" <% end_if %>
                <% if $OptionData.SampleText %>data-colorpalette-sample-text="$OptionData.SampleText" <% end_if %>
            ></label>
        </li>
    </ul>
    <% if $OptionData.GroupTitle %>
        </div>
    <% end_if %>
</div>
