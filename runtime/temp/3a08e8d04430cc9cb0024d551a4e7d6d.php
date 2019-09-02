<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"C:\xampp\htdocs\fastadmin\public/../application/admin\view\project\section\index.html";i:1562312028;s:68:"C:\xampp\htdocs\fastadmin\application\admin\view\layout\default.html";i:1562812435;s:65:"C:\xampp\htdocs\fastadmin\application\admin\view\common\meta.html";i:1562812435;s:67:"C:\xampp\htdocs\fastadmin\application\admin\view\common\script.html";i:1562812435;}*/ ?>
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
    <?php echo build_heading(); ?>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" class="btn btn-success btn-add <?php echo $auth->check('project/section/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>
                        <a href="javascript:;" class="btn btn-success btn-edit btn-disabled disabled <?php echo $auth->check('project/section/edit')?'':'hide'; ?>" title="<?php echo __('Edit'); ?>" ><i class="fa fa-pencil"></i> <?php echo __('Edit'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-del btn-disabled disabled <?php echo $auth->check('project/section/del')?'':'hide'; ?>" title="<?php echo __('Delete'); ?>" ><i class="fa fa-trash"></i> <?php echo __('Delete'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-import <?php echo $auth->check('project/section/import')?'':'hide'; ?>" title="<?php echo __('Import'); ?>" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="fa fa-upload"></i> <?php echo __('Import'); ?></a>

                        <div class="dropdown btn-group <?php echo $auth->check('project/section/multi')?'':'hide'; ?>">
                            <a class="btn btn-primary btn-more dropdown-toggle btn-disabled disabled" data-toggle="dropdown"><i class="fa fa-cog"></i> <?php echo __('More'); ?></a>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li><a class="btn btn-link btn-multi btn-disabled disabled" href="javascript:;" data-params="status=normal"><i class="fa fa-eye"></i> <?php echo __('Set to normal'); ?></a></li>
                                <li><a class="btn btn-link btn-multi btn-disabled disabled" href="javascript:;" data-params="status=hidden"><i class="fa fa-eye-slash"></i> <?php echo __('Set to hidden'); ?></a></li>
                            </ul>
                        </div>

                        
                    </div>
                    <table id="table" class="table table-striped table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('project/section/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('project/section/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script id="form-commonsearch" type="text/html">
    <form class="form-horizontal form-commonsearch nice-validator n-default n-bootstrap" novalidate="" method="post" action="">
        <fieldset>
            <div class="row">
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="id" class="control-label col-xs-4">ID</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="id-operate" data-name="id" value="=" readonly="">
                        <input type="text" class="form-control" name="id" value="" placeholder="ID" id="id" data-index="1">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="projectName" class="control-label col-xs-4">项目名称</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="project_info.name-operate" data-name="project_info.name" value="LIKE" readonly="">
                        <input type="text" class="form-control" name="project_info.name" value="" placeholder="项目名称" id="project_info.name" data-index="2">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="sectionName" class="control-label col-xs-4">标段名称</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="project_section.name-operate" data-name="project_section.name" value="LIKE" readonly="">
                        <input type="text" class="form-control" name="project_section.name" value="" placeholder="标段名称" id="project_section.name" data-index="3">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="price" class="control-label col-xs-4">标段金额</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="price-operate" data-name="price" value="BETWEEN" readonly="">
                        <div class="row row-between">
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="price" value="" placeholder="标段金额" id="price" data-index="4">
                            </div>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="price" value="" placeholder="标段金额" id="price" data-index="4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="managerName" class="control-label col-xs-4">项目经理姓名</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="managerName-operate" data-name="managerName" value="=" readonly="">
                        <input type="text" class="form-control" name="managerName" value="" placeholder="项目经理姓名" id="managerName" data-index="5">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="payPrice" class="control-label col-xs-4">已付金额</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="payPrice-operate" data-name="payPrice" value="BETWEEN" readonly="">
                        <div class="row row-between">
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="payPrice" value="" placeholder="已付金额" id="payPrice" data-index="6">
                            </div>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="payPrice" value="" placeholder="已付金额" id="payPrice" data-index="6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="createtime" class="control-label col-xs-4">创建时间</label>
                    <div class="col-xs-8">
                        <input type="hidden" class="form-control operate" name="createtime-operate" data-name="createtime" value="RANGE" readonly="">
                        <input type="text" class="form-control datetimerange" name="createtime" value="" placeholder="创建时间" id="createtime" data-index="7">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="col-sm-8 col-xs-offset-4">
                        <button type="submit" class="btn btn-success" formnovalidate="">提交</button> 
                        <button type="reset" class="btn btn-default">重置</button> 
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>