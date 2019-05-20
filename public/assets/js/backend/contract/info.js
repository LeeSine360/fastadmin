define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/info/index' + location.search,
                    add_url: 'contract/info/add',
                    edit_url: 'contract/info/edit',
                    del_url: 'contract/info/del',
                    multi_url: 'contract/info/multi',
                    table: 'contract_info',
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
                        {field: 'name', title: __('Name')},
                        {field: 'number', title: __('Number')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'total', title: __('Total')},
                        {field: 'save', title: __('Save')},
                        {field: 'operatorname', title: __('Operatorname')},
                        {field: 'operatorphone', title: __('Operatorphone')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin_id', title: __('Admin_id')},
                        {field: 'projectinfo.name', title: __('Projectinfo.name')},
                        {field: 'projectsection.name', title: __('Projectsection.name')},
                        {field: 'companyinfo.name', title: __('Companyinfo.name')},
                        {field: 'category.name', title: __('Category.name')},
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