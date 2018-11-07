<div id="usual1" class="usual">
    <script type="text/javascript" charset="utf-8" src="/static/ueditor1_4_3/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor1_4_3/editor_api.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor1_4_3/lang/zh-cn/zh-cn.js"></script>
    <div id="tab1" class="tabson">
        <?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
        <input type="hidden" name="data[<?=$this->primary?>]" value="<?=$model[$this->primary]?>">
        <ul class="forminfo">
            <li><label>KEY<b>*</b></label>
                <input name="data[keys]" value="<?= $model['keys'] ?? '' ?>" type="text" maxlength="30"
                       class="dfinput"/>
            </li>

            <li><label>类型 <b>*</b></label>
                <select id="type" name="data[type]" class="form-control" style="width:187px;" onchange="changeType(this)">
                    <option value="0">请选择</option>
                    <?php foreach ( $typeArr as $k => $r ): ?>
                        <option value="<?= $k ?>"
                            <?php if ( !empty( $model['type'] ) && $model['type'] == $k ): ?> selected <?php endif ?> >
                            <?= $r ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </li>

            <div class="form-group">
                <div id="type_target"></div>
                <div id="type_ueditor" style="margin-left:83px">
                    <script type="text/plain" style="width:80%;height:400px;" id="value_content" name="data[value]"><?=@htmlspecialchars_decode($model['value'])?></script>
                </div>
            </div>

            <li><label>&nbsp;</label><input type="submit" class="btn btn-primary" value="保 存"/></li>
        </ul>
        <?= form_close() ?>
    </div>
    <div style="display:none;" id="setting_value"><?=@htmlspecialchars_decode($model['value'])?></div>
    <script>
<?php if(!empty($model['type'])):?>
    changeType('<?=$model['type']?>');
<?php endif;?>
function changeType(obj) {
    type = typeof(obj) == 'string' ? obj : obj.value;
    $('#type_target').html('');
    var html = '<li><label><b>*</b></label>';
    var setting_value = $('#setting_value').html();
    if (type == 1) {
        html += '<textarea name="data[value]" cols="30" rows="10"class="form-control" style="width:80%">'+setting_value+'</textarea>';
    } else if (type == 2) {
        html += '<input id="value" type="hidden" name="data[value]" value="" class="input-txt"/>' +
            '            <input type="button" class="ajaxUploadBtn btn-primary btn" id="value_button"' +
            '                   onclick="ajaxUpload(\'value\',\'setting\')"' +
            '                   value="上传图片">' +
            '            <br><img   alt=""  class="imglist " id="preview_value" style="max-width:100px;min-width:100px;margin-top:10px;" src="'+setting_value+'"></li>';
    } else if (type == 3) {
        $('#type_target').html(html);
        $('#type_ueditor').show();
        var ue = UE.getEditor('value_content');
        ue.ready(function () {
            ue.execCommand('serverparam', '<?= $this->security->get_csrf_token_name(); ?>', '<?= $this->security->get_csrf_hash(); ?>');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        });

        return;
    }
    $('#type_target').html(html);
    $('#type_ueditor').hide();
    if (type == 2) {
        $(".ajaxUploadBtn").trigger('click');
    }


}
</script>