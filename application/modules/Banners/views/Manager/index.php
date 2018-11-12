<form action="" id="Form" method="post">

    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
            <th>自定义位置</th>
            <th>图片</th>
            <th>链接</th>
            <th>排序</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if ( !empty( $list ) ): ?>
            <?php foreach ( $list as $k => $r ): ?>
                <tr id="item_<?= $r['id'] ?>">
                    <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
                    <td><?= $r['customer_pos'] ?></td>
                    <td><a href="<?= $r['image'] ?>" target="_blank"><img style=" padding:10px;width:100px;"
                                                                          src="<?= $r['image'] ?>" alt=""></a></td>
                    <td><?php if ( !empty( $r['url'] ) ): ?><a href="<?= $r['url'] ?>" target="_blank">
                                点击查看</a><?php else: ?>--<?php endif; ?></td>
                    <td><input type="text" name="listorder[<?= $r['id'] ?>]" value="<?= $r['listorder'] ?>"
                               class="listorder" id=""></td>
                    <td><?= $r['created_at'] ?></td>
                    <td>
                        <a href="<?= ADMIN_MANAGER_PATH ?>/edit?id=<?= $r['id'] ?>" class="tablelink">编辑</a> |
                        <a href="javascript:delitem('<?= $r['id'] ?>');" class="tablelink"> 删除</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">
                    暂时没有记录...
                </td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>
        <?php $this->load->view('Manager/list_page')?>
</form>