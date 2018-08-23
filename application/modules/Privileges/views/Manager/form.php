<div class="formbody">
    <script type="text/javascript">
        $(document).ready(function (e) {
            $(".select1").uedSelect({
                width: 167
            });
        });
    </script>


    <div id="usual1" class="usual">

        <div id="tab1" class="tabson">
            <?= form_open() ?>
            <ul class="forminfo">
                <li><label>名称<b>*</b></label>
                    <input name="data[name]" type="text" maxlength="30" class="dfinput"/>
                </li>

                <li><label>控制器名<b>*</b></label>
                    <input name="data[controller]" type="text" class="dfinput"/><i>例：Tzl</i>
                </li>

                <li><label>参数</label>
                    <input name="data[param]" type="text" class="dfinput"/> <i>例：a=1&b=2</i>
                </li>

                <li>
                    <label>显示位置 <b>*</b></label>
                    <cite>
                        <input name="data[show_at]" type="radio" value="0"> 页面顶部&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="data[show_at]" type="radio" value="1"> 左侧&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="data[show_at]" type="radio" value="2"> 列表顶部&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="data[show_at]" type="radio" value="3"> 列表项&nbsp;&nbsp;&nbsp;&nbsp;
                    </cite>
                </li>


                <li><label>上级菜单<b>*</b></label>

                    <div class="vocation">
                        <select class="select1">
                            <option>UI设计师</option>
                            <option>交互设计师</option>
                            <option>前端设计师</option>
                            <option>网页设计师</option>
                            <option>Flash动画</option>
                            <option>视觉设计师</option>
                            <option>插画设计师</option>
                            <option>美工</option>
                            <option>其他</option>
                        </select>
                    </div>

                </li>

                <li><label>&nbsp;</label><input type="submit" class="btn" value="保 存"/></li>
            </ul>
            <?= form_close() ?>
        </div>
