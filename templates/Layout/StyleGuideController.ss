<div class="styleGuideMaster">
    <% if Styles %>
        <h1>{$Title}</h1>
        <% if ShowContents %>
            <div class="styleGuideContents">
                <ul>
                    <% loop Styles %>
                        <li>
                            <a href="{$Anchor}">
                                {$Name}
                            </a>
                        </li>
                    <% end_loop %>
                </ul>
            </div>
        <% end_if %>

        <div class="styleGuideGroups">
            <% loop Styles %>
                <div {$AnchorAttr} class="styleGuideGroup">
                    <p class="styleGuideTitle">{$Name}</p>
                    <div class="styleGuideLayout">
                        {$Layout}
                    </div>
                </div>
            <% end_loop %>
        </div>
    <% else %>
        <p>
            No styles found
        </p>
    <% end_if %>
</div>
