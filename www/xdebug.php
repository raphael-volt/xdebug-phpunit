<?php
$enabled = extension_loaded("xdebug");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>xdebug</title>
</head>
<body>
    <?
        if(! $enabled) {
            ?><p style="color:red">xdebug extension is not loaded</p><?
        }
        else {
            $values = [];
            foreach (ini_get_all("xdebug") as $key => $value) {
            	$key = explode(".", $key);
            	$values[$key[1]] = $value;
            }
            $first = [
            		"remote_enable",
            		"remote_host",
            		"remote_port",
            		"idekey",
            		"remote_autostart",
            		"remote_connect_back",
            		"remote_handler",
            		"show_exception_trace",
            		"profiler_enable",
            ];
            $sorted = [];
            foreach ($first as $key) {
            	if(! isset($values[$key]))
            		continue;
            	$sorted[] = [$key, $values[$key]["local_value"], $values[$key]["global_value"]];
            }
            foreach ($values as $key => $value) {
            	if(array_search($key, $first) !== false)
            		continue;
            	$sorted[] = [$key, $value["local_value"], $value["global_value"]];
            }
    ?>
    <dl>
            <dt>xdebug configuration</dt>
            <dd>
            	<table>
            		<thead>
            			<tr><th></th><th>local</th><th>global</th></tr>
            		</thead>
            		<tbody>
            			<?
            			foreach ($sorted as $value) {
            			?>
            			<tr>	
            				<td><? echo $value[0];?></td>
            				<td><? echo $value[1];?></td>
            				<td><? echo $value[2];?></td>
            			</tr>
            			<?
            			}
            			?>
            		</tbody>
            	</table>
            </dd>
    <dl>
    <?
        }
    ?>
</body>
</html>