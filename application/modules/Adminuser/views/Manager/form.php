<?= form_open( ADMIN_MANAGER_PATH . '/' . $sitemethod . '?id=' . _get( 'id' ) ) ?>
    <input type="hidden" name="data[<?=$this->primary?>]" value="<?=$model[$this->primary]??''?>">
    <ul class="forminfo">
        <li><label><?= lang( 'username' ) ?></label>
            <?php if ( empty( $model['username'] ) ): ?>
                <input type="text" maxlength="30" name="data[username]"
                       class="dfinput "/>
            <?php else: ?>
                <input readonly value="<?= $model['username'] ?? '' ?>" name="data[username]" type="text" maxlength="30"
                       class="dfinput input-readonly"/>
            <?php endif; ?>
        </li>
        <li><label><?= lang( 'password' ) ?></label>
            <input name="data[password]" minlength="6" type="text" maxlength="30"
                   class="dfinput"/> <?= lang( 'password_tip' ) ?>
        </li>
        <li><label><?= lang( 'display_name' ) ?></label>
            <input value="<?= $model['nickname'] ?? '' ?>" name="data[nickname]" type="text" maxlength="30"
                   class="dfinput"/>
        </li>
        <li><label><?= lang( 'status' ) ?></label>
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
        <li><label><?= lang( 'is_super' ) ?></label>
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
        <?php if ( empty( $model['is_super'] ) ): ?>
            <hr style="clear: both;">
            <li><label><?= lang( 'choose_role' ) ?></label>
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
        <?php endif; ?>

        <li><label>&nbsp;</label><input type="submit" class="btn btn-primary" value="<?= lang( 'save' ) ?>"/></li>

    </ul>
<?= form_close() ?>