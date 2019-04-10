<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"/Users/work/WEB/fastadmin/public/../application/admin/view/finance/info/index.html";i:1554898136;s:68:"/Users/work/WEB/fastadmin/application/admin/view/layout/default.html";i:1553167192;s:65:"/Users/work/WEB/fastadmin/application/admin/view/common/meta.html";i:1553167192;s:67:"/Users/work/WEB/fastadmin/application/admin/view/common/script.html";i:1553167192;}*/ ?>
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
            <li class="active"><a href="#one" data-toggle="tab">报账列表</a></li>
            <li><a href="#two" data-toggle="tab">添加</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" class="btn btn-success btn-add <?php echo $auth->check('finance/info/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>
                        <a href="javascript:;" class="btn btn-success btn-edit btn-disabled disabled <?php echo $auth->check('finance/info/edit')?'':'hide'; ?>" title="<?php echo __('Edit'); ?>" ><i class="fa fa-pencil"></i> <?php echo __('Edit'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-del btn-disabled disabled <?php echo $auth->check('finance/info/del')?'':'hide'; ?>" title="<?php echo __('Delete'); ?>" ><i class="fa fa-trash"></i> <?php echo __('Delete'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-import <?php echo $auth->check('finance/info/import')?'':'hide'; ?>" title="<?php echo __('Import'); ?>" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="fa fa-upload"></i> <?php echo __('Import'); ?></a>

                        <div class="dropdown btn-group <?php echo $auth->check('finance/info/multi')?'':'hide'; ?>">
                            <a class="btn btn-primary btn-more dropdown-toggle btn-disabled disabled" data-toggle="dropdown"><i class="fa fa-cog"></i> <?php echo __('More'); ?></a>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li><a class="btn btn-link btn-multi btn-disabled disabled" href="javascript:;" data-params="status=normal"><i class="fa fa-eye"></i> <?php echo __('Set to normal'); ?></a></li>
                                <li><a class="btn btn-link btn-multi btn-disabled disabled" href="javascript:;" data-params="status=hidden"><i class="fa fa-eye-slash"></i> <?php echo __('Set to hidden'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <table id="table" class="table table-striped table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('finance/info/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('finance/info/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>
    
            <div class="tab-pane fade" id="two">
                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="finance/info/add">

                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_info_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-project_info_id" data-rule="required" data-source="project/info/index" class="form-control selectpage input-left-padding45" name="row[project_info_id]" type="text" value="">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Project_section_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-project_section_ids" data-rule="required" data-source="project/section/index" class="form-control selectpage input-left-padding45" name="row[project_section_ids]" type="text" value="">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <div class="radio">
                            <?php if(is_array($categoryList) || $categoryList instanceof \think\Collection || $categoryList instanceof \think\Paginator): if( count($categoryList)==0 ) : echo "" ;else: foreach($categoryList as $key=>$vo): ?>
                                <label for="row[category_id]-<?php echo $key; ?>">
                                    <input id="row[category_id]-<?php echo $key; ?>" name="row[category_id]" type="radio" value="<?php echo $vo['id']; ?>" <?php if(in_array(($key), explode(',',"供应商付款"))): ?>checked<?php endif; ?> /> <?php echo $vo['name']; ?> </label> 
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Company_info_id'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-company_info_id" data-source="company/info/index" class="form-control selectpage input-left-padding45" name="row[company_info_id]" type="text" value="">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Price'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-price" data-rule="required" class="form-control" name="row[price]" type="number">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Contacts'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-contacts" data-rule="required" class="form-control" name="row[contacts]" type="text">
                        </div>
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Phone'); ?>:</label>
                        <div class="col-xs-12 col-sm-3">
                            <input id="c-phone" data-rule="required" class="form-control" name="row[phone]" type="text">
                        </div>
                    </div>
                    <div class="row form-row-height">
                        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remarkcontent'); ?>:</label>
                        <div class="col-xs-12 col-sm-8">
                            <textarea id="c-remarkcontent" class="form-control " rows="5" name="row[remarkcontent]" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="row form-row-height layer-footer">
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
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>