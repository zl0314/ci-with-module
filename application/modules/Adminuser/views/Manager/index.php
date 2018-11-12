<table class="tablelist">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
        <th><?= lang( 'username' ) ?></th>
        <th><?= lang( 'display_name' ) ?></th>
        <th><?= lang( 'status' ) ?></th>
        <th><?= lang( 'addtime' ) ?></th>

        <th><?= lang( 'operater' ) ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ( $list as $k => $r ): ?>
        <tr>
            <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
            <td><?= $r['username'] ?></td>
            <td><?= $r['nickname'] ?></td>
            <td><?= $statusArr[ $r['status'] ] ?></td>
            <td><?= $r['addtime'] ?></td>
            <td>
                <a href="<?= ADMIN_MANAGER_PATH ?>/edit?id=<?= $r['id'] ?>" class="tablelink"><?= lang( 'view' ) ?></a>
                <?php if ( !$r['is_system'] ): ?>
                    | <a href="javascript:;" onclick="delitem('<?= $r['id'] ?>')"
                         class="tablelink"> <?= lang( 'delete' ) ?></a>
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
<?php $this->load->view('Manager/list_page')?>