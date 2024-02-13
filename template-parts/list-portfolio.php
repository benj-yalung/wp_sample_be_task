<?php
$portfolios = data_get($args, 'portfolios', []);
?>

<?php if ($portfolios): ?>
    <div class="portfolios">
        <?php foreach ($portfolios as $portfolio): ?>
            <?php
                $id = $portfolio->ID;
                $title = $portfolio->post_title;
                $image1 = get_field( 'project_image_1', $id );
                $image2 = get_field( 'project_image_2', $id );
                $image3 = get_field( 'project_image_3', $id );
                $description = get_field( 'description', $id );
                $date = get_field( 'date', $id );
                $projectLink = get_field( 'project_link', $id );

                $rawImages = array_map(function ($item) {
                    if ($item) {
                        return data_get($item, 'url', null);
                    } else {
                        return null;
                    }
                }, [$image1, $image2, $image3]);

                $images = array_filter($rawImages, function($item) {
                    return ! is_null($item);
                });
            ?>

            <div class="portfolios__item">
                <?php if ( $images ): ?>
                    <div class="portfolios__item-images">
                        <img
                            src="<?php echo $images[0]; ?>"
                            alt="Portfolio Image"
                        />
                    </div>
                <?php endif; ?>

                <div class="portfolio__item-content">
                    <p class="portfolio__item-title"><?php echo $title; ?></p>
                    <p class="portfolio__item-description"><?php echo $description; ?></p>
                    <p class="portfolio__item-date"><?php echo $date; ?></p>
                    <a href="<?php echo $projectLink; ?>" class="portfolio__item-project-ink"><?php echo $projectLink; ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="empty-portfolio">No portfolio found.</p>
<?php endif; ?>