define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/project/index',
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
                        {field: 'contract_info_id', title: __('Contract_info_id')},
                        {field: 'savedata', title: __('Savedata'), searchList: {"wait":__('Savedata wait'),"normal":__('Savedata normal')," back":__('Savedata  back')," delet":__('Savedata  delet')}, formatter: Table.api.formatter.normal},
                        {field: 'opinion', title: __('Opinion')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'info.name', title: __('Info.name')},
                        {field: 'info.number', title: __('Info.number')},
                        {field: 'info.project_info_id', title: __('Info.project_info_id')},
                        {field: 'info.project_section_ids', title: __('Info.project_section_ids')},
                        {field: 'info.project_company_id', title: __('Info.project_company_id')},
                        {field: 'info.total', title: __('Info.total')},
                        {field: 'info.save', title: __('Info.save')},
                        {field: 'info.operatorname', title: __('Info.operatorname')},
                        {field: 'info.operatorphone', title: __('Info.operatorphone')},
                        {field: 'info.createtime', title: __('Info.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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