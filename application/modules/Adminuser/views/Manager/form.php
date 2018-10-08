<?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
    <input type="hidden" name="data[id]" value="<?= $model['id'] ?? '' ?>">
    <ul class="forminfo">
        <li><label>用户名</label>
            <?php if (empty($model['username'])): ?>
                <input  type="text" maxlength="30"  name="data[username]"
                        class="dfinput "/>
            <?php else: ?>
                <input readonly value="<?= $model['username'] ?? '' ?>"  name="data[username]" type="text" maxlength="30"
                       class="dfinput input-readonly"/>
            <?php endif; ?>
        </li>
        <li><label>密码</label>
            <input name="data[password]" type="text" maxlength="30"
                   class="dfinput"/> 不修改请留空
        </li>
        <li><label>显示名</label>
            <input value="<?= $model['nickname'] ?? '' ?>" name="data[nickname]" type="text" maxlength="30"
                   class="dfinput"/>
        </li>
        <li><label>状态</label>
            <div class="form-check">
                <?php foreach ( $this->statusArr as $k => $r ): ?>
                    <label class="form-check-label">
                        <input type="radio" <?php if ( isset( $model['status'] ) && $model['status'] == $k ): ?> checked <?php endif; ?>
                               class="form-check-input" name="data[status]" id="" value="<?= $k ?>">
                        <?= $r ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </li>
        <li><label>是否超管</label>
            <div class="form-check">
                <?php foreach ( $this->isSuper as $k => $r ): ?>
                    <label class="form-check-label">
                        <input type="radio" <?php if ( isset( $model['is_super'] ) && $model['is_super'] == $k ): ?> checked <?php endif; ?>
                               class="form-check-input" name="data[is_super]" value="<?= $k ?>">
                        <?= $r ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </li>
        <hr style="clear: both;">
        <li><label>选择角色</label>
            <?php foreach ( $this->rs_model->getList( 'roles', '*', [] ) as $r ): ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox"
                               class="form-check-input" <?php if ( in_array( $r['id'], $this->adminRoles ) ): ?> checked <?php endif ?>
                               name="data[roles][]" value="<?= $r['id'] ?>">
                        <?= $r['display_name'] ?? $r['name'] ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </li>

        <li><label>&nbsp;</label><input type="submit" class="btn btn-primary" value="保 存"/></li>

    </ul>
<?= form_close() ?>