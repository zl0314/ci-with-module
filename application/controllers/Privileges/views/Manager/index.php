<form action="" id="Form" method="post">

    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="selallck(this)" style="cursor:pointer;"/></th>
            <th>&nbsp;</th>
            <th>名称</th>
            <th>添加时间</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ( $list as $k => $r ): ?>
            <tr id="item_<?=$r['id']?>" loaded="0" level="0">
                <td><input name="data[id]" type="checkbox" value="<?= $r['id'] ?>"/></td>
                <td><span class="fa fa-chevron-right" style="cursor: pointer;"
                          onclick="getSubmenus('<?= $r['id'] ?>')"></span></td>
                <td><?= $r['name'] ?></td>
                <td><?= $r['addtime'] ?></td>
                <td><input type="text" name="listorder[<?= $r['id'] ?>]" value="<?= $r['listorder'] ?>"
                           class="listorder" id=""></td>
                <td>
                    <a href="<?= ADMIN_MANAGER_PATH ?>/edit?id=<?= $r['id'] ?>" class="tablelink">编辑</a>
                    | <a href="javascript:;" onclick="delitem('<?= $r['id'] ?>')" class="tablelink"> 删除</a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>
</form>
<?php $this->load->view('Manager/list_page')?>

<script>
    function getSubmenus(id) {
        var loaded = $('#item_' + id).attr('loaded');
        var level = $('#item_' + id).attr('level');

        if (loaded == 1) {
            return false;
        }
        ajax('/Manager/Privileges/public_get_submenus', {id: id, level: level}, function (res) {
            if (res == '') {
                alert_mini('没有子菜单');
            } else {
                $('#item_' + id).attr('loaded', 1);
                $('#item_' + id).after(res);
            }
        }, 'html');
    }
</script>

