<table class="tablelist">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
        <th>ID</th>
        <th>KEY</th>
        <th>类别</th>
        <th>值</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ( $list as $k => $r ): ?>
        <tr id="item_<?= $r['id'] ?>">
            <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
            <td><?= $r['id'] ?></td>
            <td><?= $r['keys'] ?></td>
            <td><?= $typeArr[ $r['type'] ] ?></td>
            <td>
                <?php if ( $r['type'] == 3 ): ?>
                    <div id="iframe_customize_html_<?= $r['id'] ?>" style="display:none;">
                        <?= htmlspecialchars_decode( ( $r['value'] ) ) ?>
                    </div>
                    <a href="javascript:iframe_customize_html('<?= $r['id'] ?>');" style="color:red">内容可能过多，点击查看</a>
                <?php elseif ( $r['type'] == 2 ): ?>
                    <div id="iframe_customize_html_<?= $r['id'] ?>" style="display:none;">
                        <img src="<?= $r['value'] ?>" alt="">
                    </div>
                    <a href="javascript:iframe_customize_html('<?= $r['id'] ?>');" style="color:green">点击查看图片</a>

                <?php else: ?>
                    <?= htmlspecialchars_decode( ( $r['value'] ) ) ?>
                <?php endif; ?>
            </td>
            <td><?= $r['created_at'] ?></td>
            <td>
                <a href="<?= ADMIN_MANAGER_PATH ?>/edit?id=<?= $r['id'] ?>" class="tablelink">编辑</a> |
                <a href="javascript:delitem('<?= $r['id'] ?>');" class="tablelink"> 删除</a>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
<?php $this->load->view('Manager/list_page')?>