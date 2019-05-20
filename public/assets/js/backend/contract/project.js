define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/project/index' + location.search,
                    add_url: 'contract/project/add',
                    edit_url: 'contract/project/edit',
                    del_url: 'contract/project/del',
                    multi_url: 'contract/project/multi',
                    table: 'contract_project',
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
                        {field: 'savedata', title: __('Savedata'), searchList: {"wait":__('Savedata wait'),"normal":__('Savedata normal')," back":__('Savedata  back')," delet":__('Savedata  delet')}, formatter: Table.api.formatter.normal},
                        {field: 'opinion', title: __('Opinion')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'contractinfo.name', title: __('Contractinfo.name')},
                        {field: 'contractinfo.number', title: __('Contractinfo.number')},
                        {field: 'contractinfo.contacts', title: __('Contractinfo.contacts')},
                        {field: 'contractinfo.price', title: __('Contractinfo.price'), operate:'BETWEEN'},
                        {field: 'contractinfo.total', title: __('Contractinfo.total')},
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