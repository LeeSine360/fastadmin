<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"/Users/work/WEB/fastadmin/public/../application/admin/view/project/info/index.html";i:1554898136;s:68:"/Users/work/WEB/fastadmin/application/admin/view/layout/default.html";i:1553167192;s:65:"/Users/work/WEB/fastadmin/application/admin/view/common/meta.html";i:1553167192;s:67:"/Users/work/WEB/fastadmin/application/admin/view/common/script.html";i:1553167192;}*/ ?>
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
                                <div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#one" data-toggle="tab">项目列表</a></li>
            <li><a href="#two" data-toggle="tab">添加</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" class="btn btn-success btn-add <?php echo $auth->check('project/info/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>
                        <a href="javascript:;" class="btn btn-success btn-edit btn-disabled disabled <?php echo $auth->check('project/info/edit')?'':'hide'; ?>" title="<?php echo __('Edit'); ?>" ><i class="fa fa-pencil"></i> <?php echo __('Edit'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-del btn-disabled disabled <?php echo $auth->check('project/info/del')?'':'hide'; ?>" title="<?php echo __('Delete'); ?>" ><i class="fa fa-trash"></i> <?php echo __('Delete'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-import <?php echo $auth->check('project/info/import')?'':'hide'; ?>" title="<?php echo __('Import'); ?>" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="fa fa-upload"></i> <?php echo __('Import'); ?></a>

                        <div class="dropdown btn-group <?php echo $auth->check('project/info/multi')?'':'hide'; ?>">
                            <a class="btn btn-primary btn-more dropdown-toggle btn-disabled disabled" data-toggle="dropdown"><i class="fa fa-cog"></i> <?php echo __('More'); ?></a>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li><a class="btn btn-link btn-multi btn-disabled disabled" href="javascript:;" data-params="status=normal"><i class="fa fa-eye"></i> <?php echo __('Set to normal'); ?></a></li>
                                <li><a class="btn btn-link btn-multi btn-disabled disabled" href="javascript:;" data-params="status=hidden"><i class="fa fa-eye-slash"></i> <?php echo __('Set to hidden'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <table id="table" class="table table-striped table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('project/info/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('project/info/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>
            
            <div class="tab-pane fade" id="two">
                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="project/info/add">
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Short'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-short" data-rule="required" class="form-control" name="row[short]" type="text">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-category_id" data-rule="required" data-source="category/selectpage" data-params='{"custom[type]":"property"}' class="form-control selectpage" name="row[category_id]" type="text" value="">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Price'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-price" class="form-control" name="row[price]" type="number">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Starttime'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-starttime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[starttime]" type="text" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Days'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-days" class="form-control" name="row[days]" type="number">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Address'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="c-address" class="form-control" name="row[address]" type="text">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Surveycontent'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <textarea id="c-surveycontent" class="form-control" name="row[surveycontent]" rows="5"></textarea>
                        </div>                        
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_construct_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-project_construct_id" data-source="project/construct/index" class="form-control selectpage" name="row[project_construct_id]" type="text" value="">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Build_contactsname'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-build_contactsname" class="form-control" name="row[build_contactsname]" type="text">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Build_phone'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-build_phone" class="form-control" name="row[build_phone]" type="text">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_supervision_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-project_supervision_id" data-source="project/supervision/index" class="form-control selectpage" name="row[project_supervision_id]" type="text" value="">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Supervision_contactsname'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-supervision_contactsname" class="form-control" name="row[supervision_contactsname]" type="text">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Supervision_phone'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-supervision_phone" class="form-control" name="row[supervision_phone]" type="text">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remarkcontent'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <textarea id="c-remarkcontent" class="form-control" name="row[remarkcontent]" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="row form-row-height layer-footer">
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
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>