<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/batch_upload/css/upload.css">
    <title>上传插件的开发</title>
</head>
<body>
<div class="upload_item">
<span class="upload-btn" id="upload-btn">
    <input type="file" class="add"  >点击上传文件
</span>
    <div id="zwb_upload">

    </div>

</div>
<script src="/static/js/jquery.js"></script>
<script src="/static/batch_upload/js/upload.min.js"></script>
<script>
    //配置需要引入jq 1.7.2版本以上
    //服务器端成功返回 {state:1,path:文件保存路径}
    //服务器端失败返回 {state:0,errmsg:错误原因}
    //默认做了文件名不能含有中文,后端接收文件的变量名为file
    $("#zwb_upload").bindUpload({
        btn: '#upload-btn',
        inputName: 'pics[]',
        url: "/UploadPic/index?filedata=file&path=pics",//上传服务器地址
        num: 2,//上传数量的限制 默认为空 无限制
        type: "jpg|png|gif|svg",//上传文件类型 默认为空 无限制
        size: 3,//上传文件大小的限制,默认为5单位默认为mb,
        callback: function (m, a, b, j) {
            b[j].state = 1;
            a.eq(j).find(".state").html("上传成功");
            a.eq(j).find(".success").addClass("success2");
            a.eq(j).find(".delete").remove();

            a.eq(j).find('.upload_file').val(m.path);
        }
    });
</script>
</body>
</html>