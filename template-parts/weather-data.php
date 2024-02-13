<?php
$data = data_get($args, 'data', []);
?>

<div class="hero__weather">
    <p><?php echo data_get($data, 'windLabel'); ?></p>
    <p><?php echo data_get($data, 'temperatureLabel'); ?></p>
    <p>As of <?php echo date('F j, Y h:i A'); ?></p>
</div>
