define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'project/manager/index' + location.search,
                    add_url: 'project/manager/add',
                    edit_url: 'project/manager/edit',
                    del_url: 'project/manager/del',
                    multi_url: 'project/manager/multi',
                    table: 'project_manager',
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
                        {field: 'name', title: __('Name')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin_id', title: __('Admin_id')},
                        {field: 'admin.id', title: __('Admin.id')},
                        {field: 'admin.username', title: __('Admin.username')},
                        {field: 'admin.nickname', title: __('Admin.nickname')},
                        {field: 'admin.password', title: __('Admin.password')},
                        {field: 'admin.salt', title: __('Admin.salt')},
                        {field: 'admin.avatar', title: __('Admin.avatar'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'admin.email', title: __('Admin.email')},
                        {field: 'admin.loginfailure', title: __('Admin.loginfailure')},
                        {field: 'admin.logintime', title: __('Admin.logintime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.createtime', title: __('Admin.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.updatetime', title: __('Admin.updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.token', title: __('Admin.token')},
                        {field: 'admin.status', title: __('Admin.status'), formatter: Table.api.formatter.status},
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