<div class="formbody">
    <div id="usual1" class="usual">

        <div id="tab1" class="tabson">
            <?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
            <ul class="forminfo">
                <li><label>名称<b>*</b></label>
                    <input name="data[name]" value="<?= $model['name'] ?? '' ?>" type="text" maxlength="30"
                           class="dfinput"/>
                </li>

                <li><label>控制器名<b>*</b></label>
                    <input name="data[controller]" value="<?= $model['controller'] ?? '' ?>" type="text"
                           class="dfinput"/><i>例：Welcome</i>
                </li>
                <li><label>方法<b>*</b></label>
                    <input name="data[method]" value="<?= $model['method'] ?? 'index' ?>" type="text"
                           class="dfinput"/><i>例：test</i>
                </li>

                <li><label>参数</label>
                    <input name="data[param]" value="<?= $model['param'] ?? '' ?>" type="text" class="dfinput"/> <i>例：a=1&b=2</i>
                </li>

                <li>
                    <label>显示位置 <b>*</b></label>
                    <label for="pos0"><input
                            <?php if ( isset( $model['show_at'] ) && $model['show_at'] == 0 ): ?>checked<?php endif; ?>
                            name="data[show_at]" id="pos0" type="radio" value="0"> 页面顶部</label>
                    <label for="pos1"><input
                            <?php if ( isset( $model['show_at'] ) && $model['show_at'] == 2 ): ?>checked<?php endif; ?>
                            name="data[show_at]" type="radio" id="pos1" value="1"> 左侧</label>
                    <label for="pos2"><input
                            <?php if ( isset( $model['show_at'] ) && $model['show_at'] == 2 ): ?>checked<?php endif; ?>
                            name="data[show_at]" type="radio" value="2" id="pos2"> 列表顶部</label>&nbsp;
                    <label for="pos3"><input
                            <?php if ( isset( $model['show_at'] ) && $model['show_at'] == 3 ): ?>checked<?php endif; ?>
                            name="data[show_at]" type="radio" value="3" id="pos3"> 列表项</label>&nbsp;
                </li>


                <li><label>上级菜单<b>*</b></label>

                    <select name="data[parent_id]" class="form-control" style="min-width:100px; max-width:200px;" id="">
                        <option value="">请选择</option>
                        <?php foreach ( $this->menu->treePermisstionsByLevel() as $r ): ?>
                            <option <?php if ( !empty( $model ) && $model['parent_id'] == $r['id'] ): ?>
                                selected <?php endif; ?> value="<?= $r['id'] ?>">
                                <?php if ( $r['parent_id'] != 0 ) : ?>
                                    <?= str_repeat( '&nbsp;', $r['level'] * 2 ) ?>|_
                                <?php endif; ?>
                                <?= $r['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </li>

                <li><label>&nbsp;</label><input type="submit" class="btn" value="保 存"/></li>
            </ul>
            <?= form_close() ?>
        </div>
