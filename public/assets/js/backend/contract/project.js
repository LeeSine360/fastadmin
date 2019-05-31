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
                        {field: 'number', title: __('Number')},
                        {field: 'projectName', title: __('ProjectName')},
                        {field: 'sectionName', title: __('SectionName')},
                        {field: 'companyName', title: __('CompanyName')},
                        {field: 'contractName', title: __('ContractName')},
                        {field: 'savedata', title: __('Savedata'), searchList: {"wait":__('Savedata wait'),"normal":__('Savedata normal')," back":__('Savedata  back')," delet":__('Savedata  delet')}, formatter: Table.api.formatter.normal},
                        {field: 'save', title: __('Save')},
                        {field: 'operatorname', title: __('Operatorname')},
                        {field: 'operatorphone', title: __('Operatorphone')},
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