<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>后台信息管理</title>
</head>

<link href="<?= ADMIN_CSS_PATH ?>style.css" rel="stylesheet" type="text/css"/>

<script>
    var SITEC = '<?php echo SITEC;?>';
    var SITEM = '<?php echo SITEM;?>';
    var DOMAIN = 'http://' + document.domain + '/';
    var doit = false;
    var is_manager = true;
    var ping = 0;
</script>
<?php if (!empty($this->data['header'])): ?>
    <?php $this->load->view('location'); ?>
<?php endif; ?>
