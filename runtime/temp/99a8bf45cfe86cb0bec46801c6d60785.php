<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"C:\xampp\htdocs\fastadmin\public/../application/admin\view\finance\tax\add.html";i:1561710714;s:68:"C:\xampp\htdocs\fastadmin\application\admin\view\layout\default.html";i:1557482263;s:65:"C:\xampp\htdocs\fastadmin\application\admin\view\common\meta.html";i:1557482263;s:67:"C:\xampp\htdocs\fastadmin\application\admin\view\common\script.html";i:1557482263;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

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
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_info_id'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <input id="c-project_info_id" data-rule="required" data-source="project/info/index" class="form-control selectpage" name="row[project_info_id]" value="">
        </div>
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_section_id'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <input id="c-project_section_id" data-rule="required" data-source="project/section/index" class="form-control selectpage" name="row[project_section_id]" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Zzs'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-zzs" class="form-control" step="0.01" name="row[zzs]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>        
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Cjs'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-cjs" class="form-control" step="0.01" name="row[cjs]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Jyfj'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-jyfj" class="form-control" step="0.01" name="row[jyfj]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Dfjyfj'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-dfjyfj" class="form-control" step="0.01" name="row[dfjyfj]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Yhs'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-yhs" class="form-control" step="0.01" name="row[yhs]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Grsds_c'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-grsds_c" class="form-control" step="0.01" name="row[grsds_c]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Grsds_g'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-grsds_g" class="form-control" step="0.01" name="row[grsds_g]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Qtsr_g'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-qtsr_g" class="form-control" step="0.01" name="row[qtsr_g]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sljs'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-sljs" class="form-control" step="0.01" name="row[sljs]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Qysds'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-qysds" class="form-control" step="0.01" name="row[qysds]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Ghjf'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-ghjf" class="form-control" step="0.01" name="row[ghjf]" type="number">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Starttime'); ?>:</label>
        <div class="col-xs-12 col-sm-3">
            <input id="c-starttime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[starttime]" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>    
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-3">
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
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>