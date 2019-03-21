define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/info/index',
                    add_url: 'finance/info/add',
                    edit_url: 'finance/info/edit',
                    del_url: 'finance/info/del',
                    multi_url: 'finance/info/multi',
                    table: 'finance_info',
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
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'contacts', title: __('Contacts')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'remarkcontent', title: __('Remarkcontent')},
                        {field: 'admin.username', title: __('Admin.username')},
                        {field: 'info.short', title: __('Info.short')},
                        {field: 'section.name', title: __('Section.name')},
                        {field: 'info.name', title: __('Info.name')},
                        {field: 'category.name', title: __('Category.name')},
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