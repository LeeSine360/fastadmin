<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/Users/work/WEB/fastadmin/public/../application/admin/view/contract/verify/examine.html";i:1560949957;s:68:"/Users/work/WEB/fastadmin/application/admin/view/layout/default.html";i:1557482264;s:65:"/Users/work/WEB/fastadmin/application/admin/view/common/meta.html";i:1557482264;s:67:"/Users/work/WEB/fastadmin/application/admin/view/common/script.html";i:1557482264;}*/ ?>
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
                                <div class="row">
    <div class="col-xs-12 col-sm-12">
        <div id="echarts" style="height:250px;width:100%;">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-2">项目名称:</div>
    <div class="col-xs-12 col-sm-4">汉寿恒大御府</div>
    <div class="col-xs-12 col-sm-2"></div>
    <div class="col-xs-12 col-sm-4"></div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-2">标段名称:</div>
    <div class="col-xs-12 col-sm-4">A区</div>
    <div class="col-xs-12 col-sm-2">标段总金额:</div>
    <div class="col-xs-12 col-sm-4">2239823984.00</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-2">项目经理:</div>
    <div class="col-xs-12 col-sm-4">李恒孝</div>
    <div class="col-xs-12 col-sm-2">联系电话:</div>
    <div class="col-xs-12 col-sm-4">1388888888</div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-2">申请付款金额:</div>
    <div class="col-xs-12 col-sm-4">2300000.00</div>
    <div class="col-xs-12 col-sm-2">类型:</div>
    <div class="col-xs-12 col-sm-4">混凝土</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-2">预算金额:</div>
    <div class="col-xs-12 col-sm-4">230000000.00</div>
    <div class="col-xs-12 col-sm-2">已拨付金额:</div>
    <div class="col-xs-12 col-sm-4">20000000.00</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-2">供应商欠款金额:</div>
    <div class="col-xs-12 col-sm-4">230000000.00</div>
    <div class="col-xs-12 col-sm-2">数量:</div>
    <div class="col-xs-12 col-sm-4">20</div>
</div>
<div class="row">
    <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
        
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2"><?php echo __('Contract_info_id'); ?>:</label>
            <div class="col-xs-12 col-sm-8">
                <input id="c-contract_info_id" data-rule="required" data-source="contract/info/index" class="form-control selectpage" name="row[contract_info_id]" type="text" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2"><?php echo __('Agreedata'); ?>:</label>
            <div class="col-xs-12 col-sm-8">
                
                <div class="radio">
                <?php if(is_array($agreedataList) || $agreedataList instanceof \think\Collection || $agreedataList instanceof \think\Paginator): if( count($agreedataList)==0 ) : echo "" ;else: foreach($agreedataList as $key=>$vo): ?>
                <label for="row[agreedata]-<?php echo $key; ?>"><input id="row[agreedata]-<?php echo $key; ?>" name="row[agreedata]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"wait"))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-12 col-sm-2"><?php echo __('Opinion'); ?>:</label>
            <div class="col-xs-12 col-sm-8">
                <input id="c-opinion" class="form-control" name="row[opinion]" type="text">
            </div>
        </div>
    </form>
</div>
<div class="hide layer-footer">
    <label class="control-label col-xs-12 col-sm-2"></label>
    <div class="col-xs-12 col-sm-8">
        <button type="reset" class="btn btn-primary btn-embossed btn-close" onclick="Layer.closeAll();"><?php echo __('Close'); ?></button>
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