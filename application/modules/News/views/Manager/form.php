<div id="usual1" class="usual">
    <div id="tab1" class="tabson">
        <?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
        <input type="hidden" name="data[<?=$this->primary?>]" value="<?=$model[$this->primary]?>">
        <ul class="forminfo">
            <li><label>标题<b>*</b></label>

                <input name="data[title]" value="<?= $model['title'] ?? '' ?>" type="text" maxlength="30"
                       class="dfinput"/><i></i>
            </li>
            <li><label>缩略图<b>*</b></label>
                <input id="thumb" type="hidden" name="data[thumb]" value="<?= $model['thumb'] ?? '' ?>"
                       class="input-txt"/>
                <input type="button" class="ajaxUploadBtn btn-primary btn" id="thumb_button"
                       onclick="ajaxUpload('thumb','<?= $siteclass ?>')"
                       value="上传图片">
                <br>
                <img alt="" class="imglist " id="preview_image" style="max-width:100px;min-width:100px;margin-top:10px;"
                     src="<?= $model['thumb'] ?? '' ?>"></li>
            </li>
            <li><label>页面关键字<b></b></label>
                <input name="data[keyword]" value="<?= $model['keyword'] ?? '' ?>" type="text"
                       class="dfinput"/>
            </li>
            <li><label>页面描述<b></b></label>
                <textarea name="data[description]" id="" class="textinput"><?= $model['description'] ?? '' ?></textarea>
            </li>

            <li><label>内容<b></b></label>
                <script id="content" name="data[content]" type="text/plain" style="width:80%;height:450px;margin-left:80px;"><?= $this->model->getContentAttribute() ?? '' ?></script>
            </li>


            <li><label>&nbsp;</label><input type="submit" class="btn" value="保 存"/></li>
        </ul>
        <?= form_close() ?>
    </div>

    <script type="text/javascript" charset="utf-8" src="/static/ueditor1_4_3/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor1_4_3/editor_api.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor1_4_3/lang/zh-cn/zh-cn.js"></script>
                <script>
                    var ue = UE.getEditor('content');
                </script>