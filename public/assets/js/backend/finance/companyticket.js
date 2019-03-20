define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/companyticket/index',
                    add_url: 'finance/companyticket/add',
                    edit_url: 'finance/companyticket/edit',
                    del_url: 'finance/companyticket/del',
                    multi_url: 'finance/companyticket/multi',
                    table: 'finance_companyticket',
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
                        {field: 'categorydata', title: __('Categorydata'), searchList: {"vat":__('Categorydata vat'),"general":__('Categorydata general')}, formatter: Table.api.formatter.normal},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'code', title: __('Code')},
                        {field: 'rate', title: __('Rate')},
                        {field: 'invoicedate', title: __('Invoicedate'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'name', title: __('Name')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'info.short', title: __('Info.short')},
                        {field: 'section.name', title: __('Section.name')},
                        {field: 'info.name', title: __('Info.name')},
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