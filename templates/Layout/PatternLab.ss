<h1>Patterns</h1>

<div class="patternMaster">
    <ul class="patternList">
    	<% loop Patterns %>
            <li><a href="#{$Name}">$Name</a></li>
        <% end_loop %>
    </ul>
    <% loop Patterns %>
        <div id="{$Name}" class="patternGroup">
            <p class="patternTitle">$Name</p>
            <div class="patternLayout">
                $Layout
            </div>
        </div>
    <% end_loop %>
</div>
