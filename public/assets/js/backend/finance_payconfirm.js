define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance_payconfirm/index' + location.search,
                    add_url: 'finance_payconfirm/add',
                    edit_url: 'finance_payconfirm/edit',
                    del_url: 'finance_payconfirm/del',
                    multi_url: 'finance_payconfirm/multi',
                    table: 'finance_payconfirm',
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
                        {field: 'payprice', title: __('Payprice'), operate:'BETWEEN'},
                        {field: 'state', title: __('State'), searchList: {"wait":__('State wait'),"agree":__('State agree'),"veto":__('State veto')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'financeinfo.price', title: __('Financeinfo.price'), operate:'BETWEEN'},
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