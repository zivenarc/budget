<input type='hidden' id='request_uri' value='<?php echo $_SERVER['REQUEST_URI'];?>'/>
<input type='hidden' id='pccGUID' value='<?php echo $_GET['pccGUID'];?>'/>
<div class="report-radio">
<table>
<tr>
<td>
<div id='period_switch'>
	<input type='radio' id='period_monthly_<?php echo $_GET['pccGUID'];?>' name='period' value='monthly'/>
	<label for='period_monthly_<?php echo $_GET['pccGUID'];?>'>Monthly</label>
	<input type='radio' checked id='period_quarterly_<?php echo $_GET['pccGUID'];?>' name='period' value='quarterly'/>
	<label for='period_quarterly_<?php echo $_GET['pccGUID'];?>'>Quarterly</label>
</div>
</td>
<td>
<div id='detail_switch'>
	<input type='radio' id='detail_all_<?php echo $_GET['pccGUID'];?>' checked name='detail' value='all'/>
	<label for='detail_all_<?php echo $_GET['pccGUID'];?>'>Details</label>
	<input type='radio' id='detail_totals_<?php echo $_GET['pccGUID'];?>' name='detail' value='totals'/>
	<label for='detail_totals_<?php echo $_GET['pccGUID'];?>'>Totals</label>
</div>
</td>
</tr>
</table>
</div>