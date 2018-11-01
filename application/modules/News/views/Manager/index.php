<form action="" id="Form" method="post">

    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
            <th>标题</th>
            <th>关键字</th>
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
                    <td><?= $r['title'] ?></td>
                    <td><?= $r['keyword'] ?></td>
                    <td><?= $r['description'] ?></td>
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

    <?php if ( !empty( $GLOBALS['total_rows'] ) ): ?>
        <div class="pagin">
            <div class="message">
                共 <i class="blue"><?= $GLOBALS['total_rows'] ?? '' ?></i> 条记录，当前显示第&nbsp;
                <i class="blue"> <?= $GLOBALS['curpage'] ?? '' ?>&nbsp;</i>页
            </div>

            <ul class="paginList">
                <?= $page_html ?? '' ?>
            </ul>
        </div>
    <?php endif; ?>
</form>