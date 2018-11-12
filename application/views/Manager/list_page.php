<?php if ( !empty( $GLOBALS['total_rows'] ) ): ?>

<div class="pagin">
    <div class="message"><?= lang( 'list_page', [ $GLOBALS['total_rows'], $GLOBALS['curpage'] ] ) ?>
    </div>

    <ul class="paginList">
        <?= $page_html ?>
    </ul>
</div>

<?php endif;?>