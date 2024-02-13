<?php
$data = data_get($args, 'data', []);
?>

<div class="hero__weather">
    <p><?php echo data_get($data, 'windLabel'); ?></p>
    <p><?php echo data_get($data, 'temperatureLabel'); ?></p>
    <p>As of: <?php echo date('y-m-d h-i-s'); ?></p>
</div>
