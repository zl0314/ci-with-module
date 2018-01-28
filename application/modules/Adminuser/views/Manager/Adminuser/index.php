<div class="rightinfo">

    <div class="tools">

        <ul class="toolbar">
            <a href="<?= ADMIN_MANAGER_PATH ?>/add">
                <li class="click"><span><img src="<?= ADMIN_IMG_PATH ?>t01.png"/></span>添加
                </li>
            </a>
            <a href="<?= ADMIN_MANAGER_PATH ?>/delete_batch">
                <li><span><img src="<?= ADMIN_IMG_PATH ?>t03.png"/></span>删除</li>
            </a>
        </ul>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
            <th>用户名</th>
            <th>显示名</th>
            <th>添加时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $k => $r): ?>
            <tr>
                <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
                <td><?= $r['username'] ?></td>
                <td><?= $r['nickname'] ?></td>
                <td><?= $statusArr[$r['status']] ?></td>
                <td>2013-09-09 15:05</td>
                <td>
                    <a href="<?= ADMIN_MANAGER_PATH ?>/edit" class="tablelink">查看</a>
                    <?php if (!$r['is_system']): ?>
                        | <a href="<?= ADMIN_MANAGER_PATH ?>/delete" class="tablelink"> 删除</a>
                    <?php endif; ?>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

    <div class="pagin">
        <div class="message">共 <i class="blue"><?= $GLOBALS['total_rows'] ?></i> 条记录，当前显示第&nbsp;<i
                    class="blue"> <?= $GLOBALS['curpage'] ?>&nbsp;</i>页
        </div>

        <ul class="paginList">
            <?= $page_html ?>
        </ul>
    </div>

