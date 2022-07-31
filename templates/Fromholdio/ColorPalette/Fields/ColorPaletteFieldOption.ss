<li class="ColorPaletteField__color $Class" <% if $Label %>data-colorpalette-label="$Label"<% end_if %>>
    <input class="ColorPaletteField__input"
           id="$ID"
           name="$Name"
           type="radio"
           value="$Value"
        <% if $isChecked %>checked<% end_if %>
        <% if $isDisabled %>disabled<% end_if %> />
    <label class="ColorPaletteField__label"
           for="$ID"
           style="<% if $BackgroundCSS %>background: {$BackgroundCSS};<% end_if %> <% if $ColorCSS %>color: {$ColorCSS};<% end_if %>"
        <% if $SampleText && $ColorCSS %>data-colorpalette-sample-text="$SampleText" <% end_if %>
    ></label>
</li>
