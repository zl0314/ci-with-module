<div class="formbody">

    <div class="formtitle"><span>基本信息</span></div>
    <?= form_open() ?>
    <ul class="forminfo">
        <input type="hidden" name="data[id]" value="<?= $setting['id'] ?>">

        <li>
            <label>站点标题 <b>*</b></label>
            <input name="data[site_title]" maxlength="30"
                   value="<?= set_value('data[site_title]', $setting['site_title']) ?>" type="text"
                   class="dfinput"/><i>标题不能超过30个字符</i>
            <?= form_error('data[site_title]') ?>
        </li>

        <li>
            <label>关键字<b>*</b></label>
            <input name="data[site_keyword]" type="text"
                   value="<?= set_value('data[site_keyword]', $setting['site_keyword']) ?>" class="dfinput"/><i>多个关键字用,隔开</i>
            <?= form_error('data[site_keyword]') ?>
        </li>

        <li>
            <label>站点描述<b>*</b></label>
            <input name="data[site_description]" max="100"
                   value="<?= set_value('data[site_description]', $setting['site_description']) ?>" type="text"
                   class="dfinput"/><i>描述不能超过100个字符</i>
            <?= form_error('data[site_description]') ?>
        </li>


        <li><label>&nbsp;</label><input type="submit" class="btn" value="确认保存"/></li>
    </ul>
    <?= form_close() ?>

</div>
