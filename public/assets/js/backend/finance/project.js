define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/project/index' + location.search,
                    add_url: 'finance/project/add',
                    edit_url: 'finance/project/edit',
                    del_url: 'finance/project/del',
                    multi_url: 'finance/project/multi',
                    table: 'finance_project',
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
                        {field: 'agreedata', title: __('Agreedata'), searchList: {"wait":__('Agreedata wait'),"agree":__('Agreedata agree'),"veto":__('Agreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'opinion', title: __('Opinion')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.username', title: __('Admin.username')},
                        {field: 'financeinfo.price', title: __('Financeinfo.price'), operate:'BETWEEN'},
                        {field: 'financeinfo.contacts', title: __('Financeinfo.contacts')},
                        {field: 'financeinfo.phone', title: __('Financeinfo.phone')},
                        {field: 'financeinfo.createtime', title: __('Financeinfo.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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