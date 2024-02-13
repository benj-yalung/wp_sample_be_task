<?php
$data = data_get($args, 'data', []);
echo sprintf('<script>console.log(%s)</script>', json_encode($data));
?>

<div class="hero__weather-image">
    <img
        src="<?php echo data_get($data, 'cloudImage'); ?>"
        alt="Hero Weather Image"
    />
</div>
