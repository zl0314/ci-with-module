<div id="usual1" class="usual">
    <div id="tab1" class="tabson">
        <?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
        <input type="hidden" name="data[id]" value="<?= $model['id'] ?? '' ?>">
        <ul class="forminfo">
            <li><label>自定义位置<b>*</b></label>

                <input name="data[customer_pos]" value="<?= $model['customer_pos'] ?? '' ?>" type="text" maxlength="30"
                       class="dfinput"/><i>例：index,只能是英文字字母</i>
            </li>
            <li><label>图片<b>*</b></label>
                <input id="image" type="hidden" name="data[image]" value="" class="input-txt"/>
                <input type="button" class="ajaxUploadBtn btn-primary btn" id="image_button"
                       onclick="ajaxUpload('image','banners')"
                       value="上传图片">
                <br>
                <img   alt=""  class="imglist " id="preview_image" style="max-width:100px;min-width:100px;margin-top:10px;" src="<?= $model['image'] ?? '' ?>"></li>
            </li>
            <li><label>链接地址<b></b></label>
                <input name="data[url]" value="<?= $model['url'] ?? '' ?>" type="text"
                       class="dfinput"/>
            </li>
            <li><label>排序<b></b></label>
                <input name="data[listorder]" value="<?= $model['listorder'] ?? '0' ?>" type="text"
                       class="dfinput"/>
            </li>



            <li><label>&nbsp;</label><input type="submit" class="btn" value="保 存"/></li>
        </ul>
        <?= form_close() ?>
    </div>
