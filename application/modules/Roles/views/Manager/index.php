<table class="tablelist">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
        <th>角色名</th>
        <th>显示名</th>
        <th>描述</th>
        <th>添加时间</th>
        <th>操作</th>

    </tr>
    </thead>
    <tbody>
    <?php if ( !empty( $list ) ): ?>
        <?php foreach ( $list as $k => $r ): ?>
            <tr id="item_<?= $r['id'] ?>">
                <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
                <td><?= $r['name'] ?></td>
                <td><?= $r['display_name'] ?></td>
                <td><?= $r['description'] ?></td>

                <td><?= $r['created_at'] ?></td>
                <td>
                    <a href="<?= ADMIN_MANAGER_PATH ?>/power?id=<?= $r['id'] ?>" class="tablelink">权限分配</a> |
                    <a href="<?= ADMIN_MANAGER_PATH ?>/edit?id=<?= $r['id'] ?>" class="tablelink">编辑</a> |
                    <a href="javascript:delitem('<?= $r['id'] ?>');" class="tablelink"> 删除</a>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

    </tbody>
</table>
<?php $this->load->view('Manager/list_page')?>

