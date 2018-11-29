<div class="formbody">
    <div id="usual1" class="usual">

        <div id="tab1" class="tabson">
            <?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
            <input type="hidden" name="data[<?=$this->primary?>]" value="<?=$model[$this->primary]??''?>">
            <ul class="forminfo">
                <li><label>角色名称<b>*</b></label>
                    <input  name="data[name]" value="<?= $model['name'] ?? '' ?>" type="text" maxlength="30"
                           class="dfinput"/><i>例：将军</i>
                </li>

                <li><label>显示名<b></b></label>
                    <input name="data[display_name]" value="<?= $model['display_name'] ?? '' ?>" type="text"
                           class="dfinput"/><i>例：大将军</i>
                </li>
                <li><label>描述<b></b></label>
                    <input name="data[display_name]" value="<?= $model['display_name'] ?? '' ?>" type="text"
                           class="dfinput"/><i>例：掌管一个军队</i>
                </li>



                <li><label>&nbsp;</label><input type="submit" class="btn" value="保 存"/></li>
            </ul>
            <?= form_close() ?>
        </div>
