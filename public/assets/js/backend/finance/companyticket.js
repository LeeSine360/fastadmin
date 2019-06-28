define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/companyticket/index' + location.search,
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
                        {field: 'id', title: __('ID')},
                        {field: 'projectinfo.name', title: __('Projectinfo.name')},
                        {field: 'projectsection.name', title: __('Projectsection.name')},
                        {field: 'fpdm', title: __('Fpdm')},
                        {field: 'fphm', title: __('Fphm')},
                        {field: 'xfMc', title: __('Xfmc')},
                        {field: 'fplxName', title: __('Fplxname')},
                        {field: 'sfMc', title: __('Sfmc')},
                        {field: 'gfMc', title: __('Gfmc')},
                        {field: 'del', title: __('Del')},
                        {field: 'taxamount', title: __('Taxamount'), operate:'BETWEEN'},
                        {field: 'goodsamount', title: __('Goodsamount'), operate:'BETWEEN'},
                        {field: 'sumamount', title: __('Sumamount'), operate:'BETWEEN'},
                        {field: 'quantityAmount', title: __('Quantityamount')},
                        {field: 'remark', title: __('Remark')},
                        {field: 'admin_id', title: __('Admin_id')},                        
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