define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'reimbursement/verify/index',
                    add_url: 'reimbursement/verify/add',
                    edit_url: 'reimbursement/verify/edit',
                    del_url: 'reimbursement/verify/del',
                    multi_url: 'reimbursement/verify/multi',
                    table: 'reimbursement_verify',
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
                        {field: 'project_agreedata', title: __('Project_agreedata'), searchList: {"wait":__('Project_agreedata wait'),"agree":__('Project_agreedata agree'),"veto":__('Project_agreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'finance_agreedata', title: __('Finance_agreedata'), searchList: {"wait":__('Finance_agreedata wait'),"agree":__('Finance_agreedata agree'),"veto":__('Finance_agreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'info.price', title: __('Info.price'), operate:'BETWEEN'},
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