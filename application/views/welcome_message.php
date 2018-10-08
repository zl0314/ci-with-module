<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>jQuery多张图片批量上传插件</title>
    <script src="/static/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/diyUpload/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/static/diyUpload/diyUpload.css">
    <script type="text/javascript" src="/static//diyUpload/webuploader.html5only.min.js"></script>
    <script type="text/javascript" src="/static//diyUpload/diyUpload.js"></script>
</head>
<body>
<div id="demo">
    <div id="as"></div>
</div>
</body>
<script type="text/javascript">
    /*
    * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
    * 其他参数同WebUploader
    */

    $('#as').diyUpload({
        url: 'server/fileupload.php',
        success: function (data) {
            console.info(data);
        },
        error: function (err) {
            console.info(err);
        },
        buttonText: '选择文件',
        chunked: true,
        // 分片大小
        chunkSize: 512 * 1024,
        //最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
        fileNumLimit: 50,
        fileSizeLimit: 500000 * 1024,
        fileSingleSizeLimit: 50000 * 1024,
        accept: {}
    });
</script>
</html>
