<?php if (!defined('THINK_PATH')) {
	exit();
}
/*a:4:{s:81:"C:\xampp\htdocs\fastadmin\public/../application/admin\view\contract\info\add.html";i:1553041758;s:68:"C:\xampp\htdocs\fastadmin\application\admin\view\layout\default.html";i:1545959258;s:65:"C:\xampp\htdocs\fastadmin\application\admin\view\common\meta.html";i:1547016869;s:67:"C:\xampp\htdocs\fastadmin\application\admin\view\common\script.html";i:1545959258;}*/?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '') ? $title : ''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug') ? '' : '.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if (!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach ($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach;?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif;?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_info_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-project_info_id" data-rule="required" data-source="project/info/index" class="form-control selectpage" name="row[project_info_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_section_ids'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-project_section_ids" data-rule="required" data-source="project/section/index" data-multiple="true" class="form-control selectpage" name="row[project_section_ids]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('company_info_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-company_info_id" data-rule="required" data-source="project/company/index" class="form-control selectpage" name="row[company_info_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-category_id" data-rule="required" data-source="category/selectpage" data-params='{"custom[type]":"contract_info"}' class="form-control selectpage" name="row[category_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Label_ids'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-label_ids" data-rule="required" data-source="label/index" data-multiple="true" class="form-control selectpage" name="row[label_ids]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Phone'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-phone" data-rule="required" class="form-control" name="row[phone]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Signdate'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-signdate" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[signdate]" type="text" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Expirydate'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-expirydate" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[expirydate]" type="text" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-price" class="form-control" step="0.01" name="row[price]" type="number">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Operatorname'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-operatorname" class="form-control" name="row[operatorname]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Operatorphone'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-operatorphone" class="form-control" name="row[operatorphone]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Settlement'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-settlement" class="form-control " rows="5" name="row[settlement]" cols="50"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-content" class="form-control editor" rows="5" name="row[content]" cols="50"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Uploadimages'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-uploadimages" class="form-control" size="50" name="row[uploadimages]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-uploadimages" class="btn btn-danger plupload" data-input-id="c-uploadimages" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-uploadimages"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-uploadimages" class="btn btn-primary fachoose" data-input-id="c-uploadimages" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-uploadimages"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-uploadimages"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remarkcontext'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-remarkcontext" class="form-control " rows="5" name="row[remarkcontext]" cols="50"></textarea>
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug') ? '' : '.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug') ? '' : '.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>