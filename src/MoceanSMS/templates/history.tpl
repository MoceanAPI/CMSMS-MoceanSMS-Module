<style type="text/css">
    /* Pagination links */
    .pagination a {ldelim}
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
    {rdelim}

    /* Style the active/current link */
    .pagination a.active {
        background-color: dodgerblue;
        color: white;
    }

    /* Add a grey background color on mouse-over */
    .pagination a:hover:not(.active)
    {ldelim}
        background-color: #ddd;
    {rdelim}
</style>

{form_start}

<div class="pageoverflow">
    <p class="pageinput">
        <input type="submit" name="{$actionid}cancel" value="{$mod->Lang("back")}">
    </p>
</div>
{form_end}
<div class="pagination">
    <a href="{$pathname}&page={$paging["first"]}" >First</a>
    <a href="{$pathname}&page={$paging["previous"]}")">Prev</a>
    {for $i=$paging["start"] to $paging["end"]}
        {if $i == $paging["now"]}
            <a  class="active" href="{$pathname}&page={$i}">{$i}</a>
        {else}
            <a href="{$pathname}&page={$i}">{$i}</a>
        {/if}
    {/for}
    <a href="{$pathname}&page={$paging["next"]}")">Last</a>
    <a href="{$pathname}&page={$paging["last"]}">Last</a>
</div>

<div class="pageoverflow">
    <table class="pagetable" style="border:0;overflow-x:auto;">
        <thead>
        <tr>
            <th>Date</th>
            <th>Content</th>
            <th>Contact(s)</th>
            <th>IP</th>
        </tr>
        </thead>
        <tbody>
        {if (!is_array($histories))}
            <tr>
                <td colspan="4">No data...</td>
            </tr>
        {else}
            {foreach from=$histories item=history}
                {cycle name=gates values="row1,row2" assign='rowclass'}
                <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';"
                    onmouseout="this.className='{$rowclass}';">
                    <td>{$history["datetime"]}</td>
                    <td>{$history["text"]}</td>
                    <td>{$history["receiver"]}</td>
                    <td>{$history["ip"]}</td>
                </tr>
            {/foreach}
        {/if}
        </tbody>
    </table>
</div>

<script>
    {literal}
    function getEndpointByPage(page) {
        var pathname = location.pathname;
        var params = window.location.search.substr(1)

        if (params != '') return pathname+"?"+params+"&page="+page;
        else  return pathname+"?"+"page="+page;

    }

    function redirectToPage(page) {
        location.href = getEndpointByPage(page);
    }
    {/literal}
</script>