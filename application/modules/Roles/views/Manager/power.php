<link rel="stylesheet" href="/static/admin/css/power.css">

<form action="" method="post">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    <div class="formbody" style="margin: 0 auto;width:80%">
        <table style=" " border="0" cellpadding="0" cellspacing="0" class="table">
            <tbody>
            <tr class="tr1">
                <td width="22%" height="35" align="right"><p class="b">角色ID：</p></td>
                <td colspan="2" align="left"><?= _get( 'id' ) ?></td>
            </tr>
            <tr>
                <td height="35" align="right"><p class="b">角色名称 / 描述：</p></td>
                <td colspan="2" align="left"><?= $role["name"] ?> / <?= $role["description"] ?></td>
            </tr>
            </tbody>
        </table>

        <div class="title"
             style="margin-bottom:10px;margin-top:15px;height:40px; font-weight:bold; font-size:15px;line-height:40px;">
            全局权限&nbsp;&nbsp;
            (<a href="javascript:;" onclick="checkALLPrivileges('on');">全选</a> /
            <a href="javascript:;" onclick="checkALLPrivileges('off');">反选</a>)
        </div>

        <?php foreach ( $menus as $mk => $mr ):
            ?>
            <div class="title"
                 style="margin-top:15px;height:40px; font-weight:bold; font-size:15px;line-height:40px; border:1px solid #d8dee3"><?php echo $mr['name'] ?>
                权限&nbsp;&nbsp;
                (<a href="javascript:;" onclick="checkALLPrivileges2('<?php echo $mr['id'] ?>','on');">全选</a> / <a
                        href="javascript:;" onclick="checkALLPrivileges2('<?php echo $mr['id'] ?>','off');">反选</a>)
            </div>
            <input type="checkbox" style="display: none" id="parent_input_<?=$mr['id']?>" name="privileges[<?php echo $mr['id'] ?>][]" value="<?=$mr['id']?>">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table"
                   style="margin-top:-15px;border-top:none;" id="<?php echo $mr['id'] ?>_p">
                <tbody>
                <?php
                $i = 0;
                foreach ( $mr['submenu'] as $k => $v ):?>
                    <?php $i++ ?>
                    <tr class="<?php if ( $i % 2 == 0 ): ?>tr1<?php endif; ?>">
                        <td width="22%" height="35" align="right">
                            <p class="b">
                                <span style="color:green;">  <?php echo $v['name'] ?></span>
                                (
                                <a href="javascript:;" href="javascript:;"
                                   onclick="checkPrivileges('<?php echo $v['id'] ?>','on')">全选</a> /
                                <a href="javascript:;" href="javascript:;"
                                   onclick="checkPrivileges('<?php echo $v['id'] ?>','off')">反选</a>
                                )：
                            </p>
                        </td>
                        <td colspan="2" align="left" id="<?= $v['id'] ?>_p">
                            <?php
                            $checkstr = '';
                            if ( in_array( $v['id'], $roles_privileges ) ) {
                                $checkstr = ' checked';
                            }
                            ?>
                            <label for="p_item_<?=$v['id']?>" class="labels" style="cursor: pointer;">
                                <input id="p_item_<?=$v['id']?>" type="checkbox" onclick="checkPrivilegesParent(<?php echo $v['parent']['id'] ?>,this)" name="privileges[<?php echo $v['id'] ?>][]"
                                       value="<?php echo $v['id'] ?>" <?php echo $checkstr ?> />
                                <b><?php echo $v['name'] ?></b> &nbsp; &nbsp; &nbsp;
                            </label>

                            <?php foreach ( $v['submenu'] as $methodk => $methodv ): ?>
                                <?php
                                $checkstr = '';
                                if ( in_array( $methodv['id'], $roles_privileges ) ) {
                                    $checkstr = ' checked';
                                }
                                ?>
                                <label class="labels"for="p_item_<?=$methodv['id']?>" style="font-weight:normal;cursor: pointer;">
                                    <input id="p_item_<?=$methodv['id']?>"  onclick="checkPrivilegesParent(<?php echo $v['parent']['id'] ?>,this)" type="checkbox" name="privileges[<?php echo $methodv['id'] ?>][]"
                                           value="<?php echo $methodv['id'] ?>" <?php echo $checkstr ?> /> <?php echo $methodv['name'] ?> &nbsp;

                                </label>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php endforeach; ?>
        <input type="submit" class="btn" value="保存权限">
    </div>
</form>

<script>
    function checkPrivilegesParent(p,obj){
        $('#parent_input_'+p).prop('checked', $(obj).prop('checked'));
    }
    function checkALLPrivileges(b) {
        var checkd = b == 'on' ? true : false;
        $('.formbody').find('input').prop('checked', checkd);
    }

    function checkPrivileges(id, b) {
        var checkd = b == 'on' ? true : false;
        $('#' + id + '_p').find('input').prop('checked', checkd);
    }

    function checkALLPrivileges2(id, b) {
        var checkd = b == 'on' ? true : false;
        $('#' + id + '_p').find('input').prop('checked', checkd);
    }
</script>

