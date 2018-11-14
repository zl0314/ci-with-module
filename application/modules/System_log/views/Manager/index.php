<script src="/static/js/wdate/Wdatepicker.js"></script>
<div id="search">
    <form action="">
        操作时间：
        <input type="text"  name="start_time" value="<?=_get('start_time')?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="" readonly class="dfinput Wdate" style=" height:30px;"> --
        <input type="text" name="end_time" id=""  value="<?=_get('end_time')?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"  readonly class="dfinput Wdate" style="height:30px;">
        <input type="submit" value="搜 索" class="btn" style="width:70px;">
    </form>
</div>

<table class="tablelist">
    <thead>
    <tr>
        <th>控制器</th>
        <th>方法</th>
        <th>位置</th>
        <th>信息</th>
        <th>结果</th>
        <th>操作人</th>
        <th>操作时间</th>

    </tr>
    </thead>
    <tbody>
    <?php if ( !empty( $list ) ): ?>
        <?php foreach ( $list as $k => $r ): ?>
            <tr id="item_<?= $r['id'] ?>">
                <td><?=$r['siteclass']?></td>
                <td><?=$r['sitemethod']?></td>
                <td><?=$r['pos']?></td>
                <td><?=$r['msg']?></td>
                <td><?=$r['result']?></td>
                <td><?=$r['admin_name']??''?></td>
                <td><?= $r['created_at'] ?></td>

            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

    </tbody>
</table>

<div class="pagin">
    <div class="message">共 <i class="blue"><?= $GLOBALS['total_rows'] ?? '' ?></i> 条记录，当前显示第&nbsp;<i
                class="blue"> <?= $GLOBALS['curpage'] ?? '' ?>&nbsp;</i>页
    </div>

    <ul class="paginList">
        <?= $page_html ?? '' ?>
    </ul>
</div>

