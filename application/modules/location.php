<div class="place">
    <span><?=lang('position')?></span>
    <ul class="placeul">
        <li><a href="javascript:;"><?=lang('index')?></a></li>
        <?php if(!empty($this->menu->getPosition( $siteclass, $sitemethod ))):?>
        <li><a href="javascript:;"><?= $this->menu->getPosition( $siteclass, $sitemethod ) ?></a></li>
        <?php endif;?>
    </ul>
</div>
