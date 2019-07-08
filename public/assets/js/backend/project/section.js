define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'project/section/index' + location.search,
                    add_url: 'project/section/add',
                    edit_url: 'project/section/edit',
                    del_url: 'project/section/del',
                    multi_url: 'project/section/multi',
                    table: 'project_section',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                searchFormTemplate: 'form-commonsearch',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'projectName', title: __('Projectinfo.name')},
                        {field: 'sectionName', title: __('Name')},                        
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'managerName', title: __('Projectmanager.name')},
                        {field: 'payPrice', title: __('已付金额')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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