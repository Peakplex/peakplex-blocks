<?php
/**
 * Template for Text and Image block
 */
<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'text-and-image-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'text-and-image';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if ( ! empty( $block['backgroundColor'] ) ) {
	$className .= ' has-background';
	$className .= ' has-' . $block['backgroundColor'] . '-background-color';
}
if ( ! empty( $block['textColor'] ) ) {
	$className .= ' has-text-color';
	$className .= ' has-' . $block['textColor'] . '-color';
}

// Load values and assing defaults.
$text = get_field('text');
$image = get_field('image');
$buttonText = get_field('button_text');
$buttonLink = get_field('button_link');
$wantButton = get_field('want_button');
$leftSide = get_field('left_side');
    
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?><?php if($leftSide == 'image'){ ?>reverse<?php } ?>">
	<?php if($text){ ?>
        <div class="content-side">
            <?php echo $text; ?>
			<?php if($wantButton == 'yes'){ ?>
				<?php if($buttonText and $buttonLink){ ?>
				<a href="<?php echo $buttonLink; ?>" title="<?php echo $buttonText; ?>" class="cta-button"><?php echo $buttonText; ?></a>
				<?php } ?>
			<?php } ?>
        </div>
    <?php } ?>
    <?php if($image){ ?>
		<?php $caption = $image['caption']; ?>
        <div class="image-side">
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
			<?php if($caption){ ?>
	<div class="caption">
		<?php echo $caption; ?>
	</div>
<?php } ?>
        </div>
    <?php } ?>
</div>