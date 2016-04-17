<div class="styleGuideMaster">
    <% if Styles %>
        <ul class="styleGuideNav">
        	<% loop Styles %>
                <li><a href="#{$ID}">$Name</a></li>
            <% end_loop %>
        </ul>
        <div class="styleGuideGroups">
            <h1>Style Guide</h1>
            <% loop Styles %>
                <div id="{$ID}" class="styleGuideGroup">
                    <p class="styleGuideTitle">$Name</p>
                    <div class="styleGuideLayout">
                        $Layout
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
