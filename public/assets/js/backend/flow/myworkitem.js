define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'flow/myworkitem/index',
                    add_url: 'flow/myworkitem/add',
                    edit_url: 'flow/myworkitem/edit',
                    del_url: 'flow/myworkitem/del',
                    multi_url: 'flow/myworkitem/multi',
                    table: 'flow_task',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'createtime',
                sortOrder: "desc",
                selectSingle: true,
                searchFormVisible: true,
                columns: [
                    [
                        {field: 'id', title: __('id'), visible: false, operate: false},
                        {field: 'url', title: __('id'), visible: false, operate: false},
                        {field: 'bizobjectid', title: __('业务表id'), visible: false, operate: false},
                        {field: 'schemeid', visible: false, operate: false},
                        {field: 'instancestatus', visible: false, operate: false},
                        {field: 'flowcode', visible: false, operate: false},
                        {field: 'instancecode', title: __('流水号'), operate: "LIKE", formatter: Controller.api.formatter.browser, events: Controller.api.events.browser},
                        {field: 'flowname', title: '流程名称', operate: "LIKE"},
                        {field: 'stepname', title: '步骤', operate: false, operate: "LIKE"},
                        {field: 'nickname', title: __('Nickname'), operate: "LIKE"},
                        {field: 'createtime', title: __('createtime'), operate: 'RANGE', addclass: 'datetimerange'},
                        {field: 'completedtime', title: __('Completedtime'), operate: 'RANGE', addclass: 'datetimerange'},
                        {field: 'status', title: '状态', formatter: Controller.api.formatter.status, operate: false}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        detail: function () {

        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                status: function (value, row, index) {
                    var res = '';
                    var className = '';
                    switch (row.instancestatus) {
                        case 0:
                            res = '待提交';
                            className = 'primary';
                            break;
                        case  1:
                            res = '审批中';
                            className = 'info';
                            break;
                        case 2:
                            res = '已完成';
                            className = 'success';
                            break;
                        case 3:
                            res = '已取消';
                            className = 'success';
                            break;
                        default:
                            break;
                    }
                    return '<a href="javascript:;" class="searchit" data-toggle="tooltip" "><span class="label label-' + className + '">' + res + '</span></a>';
                },
                browser: function (value, row, index) {
                    //这里我们直接使用row的数据
                    return '<a class="btn btn-xs btn-browser">' + value + '</a>';
                },
            },
            events: {//绑定事件的方法
                browser: {
                    'click .btn-browser': function (e, value, row, index) {
                        e.stopPropagation();
                        var url=row.url;
                        if(url!='' && url!=null){
                            url = url+'/edit?ids=' + row.bizobjectid + '&taskid=' + row.id;
                            if (url.indexOf("{ids}") !== -1) {
                                url = Table.api.replaceurl(url, {ids: ids.length > 0 ? ids.join(",") : 0}, table);
                            }
                        }
                        else{
                            url = 'flow/' + row.flowcode + '/edit?ids=' + row.bizobjectid + '&taskid=' + row.id;
                            if (url.indexOf("{ids}") !== -1) {
                                url = Table.api.replaceurl(url, {ids: ids.length > 0 ? ids.join(",") : 0}, table);
                            }
                        }
                        var title = row.flowname + '(' + row.instancecode + ')';
                        Fast.api.open(url, title, {});
                    }
                },
            }
        }
    };
    return Controller;
});