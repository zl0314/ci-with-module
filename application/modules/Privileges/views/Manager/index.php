<form action="" id="Form" method="post">

    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
            <th>名称</th>
            <th>添加时间</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ( $list as $k => $r ): ?>
            <tr>
                <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
                <td><?= $r['name'] ?></td>
                <td><?= $r['addtime'] ?></td>
                <td><input type="text" name="listorder[<?= $r['id'] ?>]" value="<?= $r['listorder'] ?>"
                           class="listorder" id=""></td>
                <td>
                    <a href="<?= ADMIN_MANAGER_PATH ?>/edit" class="tablelink">编辑</a>
                    | <a href="<?= ADMIN_MANAGER_PATH ?>/delete" class="tablelink"> 删除</a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>
</form>
<div class="pagin">
    <div class="message">共 <i class="blue"><?= $GLOBALS['total_rows'] ?></i> 条记录，当前显示第&nbsp;<i
                class="blue"> <?= $GLOBALS['curpage'] ?>&nbsp;</i>页
    </div>

    <ul class="paginList">
        <?= $page_html ?>
    </ul>
</div>

