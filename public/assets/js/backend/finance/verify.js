define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/verify/index',
                    add_url: 'finance/verify/add',
                    edit_url: 'finance/verify/edit',
                    del_url: 'finance/verify/del',
                    multi_url: 'finance/verify/multi',
                    table: 'finance_verify',
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
                        {field: 'project_agreedata', title: __('Project_agreedata'), searchList: {"wait":__('Project_agreedata wait'),"agree":__('Project_agreedata agree'),"veto":__('Project_agreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'finance_agreedata', title: __('Finance_agreedata'), searchList: {"wait":__('Finance_agreedata wait'),"agree":__('Finance_agreedata agree'),"veto":__('Finance_agreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'info.price', title: __('Info.price'), operate:'BETWEEN'},
                        {field: 'info.contacts', title: __('Info.contacts')},
                        {field: 'info.phone', title: __('Info.phone')},
                        {field: 'info.remarkcontent', title: __('Info.remarkcontent')},
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