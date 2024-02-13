<?php
$data = data_get($args, 'data', []);
?>

<div class="hero__weather">
    <p><?php echo data_get($data, 'windLabel'); ?></p>
    <p><?php echo data_get($data, 'temperatureLabel'); ?></p>
    <p><?php echo data_get($data, 'cloudLabel'); ?></p>
    <p>As of <?php echo data_get($data, 'currentTime'); ?></p>
</div>
