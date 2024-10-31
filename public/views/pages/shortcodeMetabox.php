<?php
$postId = @$_GET['post'];
?>
<div class="ypl-bootstrap-wrapper">
    <label><?php _e('Shortcode', YPL_TEXT_DOMAIN); ?></label>
    <?php if (empty($postId)) : ?>
    <p>Please do save the Poll form, to getting the shortcode.</p>
    <?php else: ?>
    <div class="ypl-tooltip">
        <span class="ypl-tooltiptext" id="ypl-tooltip-<?php echo $postId; ?>"><?php _e('Copy to clipboard', YPL_TEXT_DOMAIN)?></span>
        <input type="text" id="ypl-shortcode-input-<?php echo $postId; ?>" data-id="<?php echo $postId; ?>" class="widefat ypl-shortcode-info" readonly="readonly" value="[ypl_poll id=<?php echo $postId; ?>]">
    </div>
    <?php endif; ?>
    <label>
        <?php _e('Current version', YPL_TEXT_DOMAIN); ?>
    </label>
    <p class="current-version-text" style="color: #3474ff;"><?php echo YPL_VERSION_TEXT; ?></p>
    <label>
        <?php _e('Last update date', YPL_TEXT_DOMAIN); ?>
    </label>
    <p style="color: #11ca79;"><?php echo YPL_LAST_UPDATE; ?></p>
    <label>
        <?php _e('Next update date', YPL_TEXT_DOMAIN); ?>
    </label>
    <p style="color: #efc150;"><?php echo YPL_NEXT_UPDATE; ?></p>
</div>