define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'company/visit/index' + location.search,
                    add_url: 'company/visit/add',
                    edit_url: 'company/visit/edit',
                    del_url: 'company/visit/del',
                    multi_url: 'company/visit/multi',
                    table: 'company_visit',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'state', title: __('State'), searchList: {"call":__('State call'),"wait":__('State wait'),"error":__('State error')}, operate:'FIND_IN_SET', formatter: Table.api.formatter.label},
                        {field: 'completedata', title: __('Completedata'), searchList: {"no":__('No'),"yes":__('Yes')}, formatter: Table.api.formatter.normal},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin_id', title: __('Admin_id')},
                        {field: 'projectinfo.name', title: __('Projectinfo.name')},
                        {field: 'projectsection.name', title: __('Projectsection.name')},
                        {field: 'companyinfo.name', title: __('Companyinfo.name')},
                        {field: 'admin.username', title: __('Admin.username')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});