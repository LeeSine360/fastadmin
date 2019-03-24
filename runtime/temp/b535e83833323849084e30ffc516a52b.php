<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"/Users/work/WEB/fastadmin/public/../application/admin/view/finance/verify/add.html";i:1553346227;s:68:"/Users/work/WEB/fastadmin/application/admin/view/layout/default.html";i:1553167192;s:65:"/Users/work/WEB/fastadmin/application/admin/view/common/meta.html";i:1553167192;s:67:"/Users/work/WEB/fastadmin/application/admin/view/common/script.html";i:1553167192;}*/ ?>
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
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Finance_info_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-finance_info_id" data-rule="required" data-source="finance/info/index" class="form-control selectpage" name="row[finance_info_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_agreedata'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($projectAgreedataList) || $projectAgreedataList instanceof \think\Collection || $projectAgreedataList instanceof \think\Paginator): if( count($projectAgreedataList)==0 ) : echo "" ;else: foreach($projectAgreedataList as $key=>$vo): ?>
            <label for="row[project_agreedata]-<?php echo $key; ?>"><input id="row[project_agreedata]-<?php echo $key; ?>" name="row[project_agreedata]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"wait"))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-project_content" class="form-control" name="row[project_content]"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Finance_agreedata'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($financeAgreedataList) || $financeAgreedataList instanceof \think\Collection || $financeAgreedataList instanceof \think\Paginator): if( count($financeAgreedataList)==0 ) : echo "" ;else: foreach($financeAgreedataList as $key=>$vo): ?>
            <label for="row[finance_agreedata]-<?php echo $key; ?>"><input id="row[finance_agreedata]-<?php echo $key; ?>" name="row[finance_agreedata]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"wait"))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Finace_content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-finace_content" class="form-control" name="row[finace_content]"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remarkcontent'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-remarkcontent" class="form-control" name="row[remarkcontent]"></textarea>
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
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>