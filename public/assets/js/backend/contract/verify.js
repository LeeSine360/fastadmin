define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/verify/index',
                    add_url: 'contract/verify/add',
                    edit_url: 'contract/verify/edit',
                    del_url: 'contract/verify/del',
                    multi_url: 'contract/verify/multi',
                    table: 'contract_verify',
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
                        {field: 'number', title: __('ContractNumber')},
                        {field: 'projectName', title: __('ProjectName')},
                        {field: 'project_section_names', title: __('Project_section_names')},
                        {field: 'companyName', title: __('CompanyName')},
                        {field: 'contractName', title: __('ContractName')},
                        {field: 'categoryName', title: __('CategoryName')},
                        {field: 'price', title: __('price'), operate:'BETWEEN'},
                        {field: 'total', title: __('total')},
                        {field: 'phone', title: __('ContractPhone')},
                        {field: 'agreedata', title: __('Agreedata'), searchList: {"wait":__('Agreedata wait'),"agree":__('Agreedata agree'),"veto":__('Agreedata veto')}, formatter: Table.api.formatter.normal},
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