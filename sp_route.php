<?php
$flagNoAuth = true;
include('common/auth.php');

if($_POST['DataAction']=='update'){
	$arrPP = explode('_',$_POST['polpod']);
	$sql = "UPDATE ref_route SET route=".(integer)$_POST['route']." 
			WHERE pol_country=".$oSQL->e($arrPP[0])."
				AND pod_country=".$oSQL->e($arrPP[1]).";";
	$rs = $oSQL->q($sql);
	header('Content-type: application/json;');
	echo json_encode(Array('status'=>'ok'));
	die();
}

include ('includes/inc-frame_top.php');

$sql = "SELECT	rteID as optValue, rteTitle as optText FROM tbl_route";
$rs = $rs = $oSQL->q($sql);
$arrRoute[0] = "Undefined";
while ($rw = $oSQL->f($rs)){
	$arrRoute[$rw['optValue']] = $rw['optText'];
}
$sql = "SELECT pol_country, POL.cntTitle as pol_title, pod_country, POD.cntTitle as pod_title, route
		FROM ref_route 
		LEFT JOIN geo.tbl_country POL on POL.cntID=pol_country
		LEFT JOIN geo.tbl_country POD on POD.cntID=pod_country
		WHERE route=0;";
$rs = $oSQL->q($sql);
?>
<h1>Missing routes</h1>
<table class='log'>
<tr>
	<th colspan="2">Origin</th>
	<th colspan="2">Destination</th>
	<th>Route</th>
</tr>
	
<?php
while ($rw = $oSQL->f($rs)){
	?>
	<tr>
		<td><?php echo $rw['pol_country'];?></td>
		<td><?php echo $rw['pol_title'];?></td>
		<td><?php echo $rw['pod_country'];?></td>
		<td><?php echo $rw['pod_title'];?></td>
		<td><?php select($rw['pol_country'].'_'.$rw['pod_country'],$arrRoute,$rw['route']);?></td>
	</tr>
	<?php
}
?>
</table>
<script>
	$(document).ready(function(){
		$('select').change(function(){
			route = $(this).val();
			$.post(location.href, {DataAction:'update',
									polpod:$(this).attr('id'),
								route:route}, 
					function(data){
						console.log(data);
					});
		});
	});
</script>
<?php
include ('includes/inc-frame_bottom.php');

function select($id,$data, $value){
	?>
	<select name="<?php echo $id;?>" id="<?php echo $id;?>">
		<?php
		foreach ($data as $key=>$title){
			?>
			<option value="<?php echo $key;?>" <?php if ($key==$value) echo "SELECTED";?>><?php echo $title;?></option>
			<?php
		}
	?>
	</select>
	<?php
}
?>