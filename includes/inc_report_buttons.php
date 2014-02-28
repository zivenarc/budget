<input type='hidden' id='request_uri' value='<?php echo $_SERVER['REQUEST_URI'];?>'/>
<input type='hidden' id='pccGUID' value='<?php echo $_GET['tab'];?>'/>
<div class="report-radio f-row">
<div id='period_switch'>
	<input type='radio' id='period_monthly_<?php echo $_GET['tab'];?>' name='period' value='monthly'/>
	<label for='period_monthly_<?php echo $_GET['tab'];?>'>Monthly</label>
	<input type='radio' checked id='period_quarterly_<?php echo $_GET['tab'];?>' name='period' value='quarterly'/>
	<label for='period_quarterly_<?php echo $_GET['tab'];?>'>Quarterly</label>
</div>
<div id='detail_switch'>
	<input type='radio' id='detail_all_<?php echo $_GET['tab'];?>' checked name='detail' value='all'/>
	<label for='detail_all_<?php echo $_GET['tab'];?>'>Details</label>
	<input type='radio' id='detail_totals_<?php echo $_GET['tab'];?>' name='detail' value='totals'/>
	<label for='detail_totals_<?php echo $_GET['tab'];?>'>Totals</label>
</div>
</div>