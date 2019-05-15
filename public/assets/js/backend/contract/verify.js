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
                sortName: 'info.number',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),visible:false},
                        {field: 'info.number', title: __('Info.number')},
                        {field: 'info.project_info_id', title: __('Info.project_info_id')},
                        {field: 'info.project_section_ids', title: __('Info.project_section_ids')},
                        {field: 'info.company_info_id', title: __('Info.company_info_id')},                      
                        {field: 'info.name', title: __('Info.name')}, 
                        {field: 'info.label_ids', title: __('Info.label_ids')},
                        {field: 'info.phone', title: __('Info.phone')},
                        {field: 'info.price', title: __('Info.price'), operate:'BETWEEN'},
                        {field: 'info.total', title: __('Info.total')},
                        {field: 'info.save', title: __('Info.save')},
                        {field: 'info.operatorname', title: __('Info.operatorname')},
                        {field: 'info.operatorphone', title: __('Info.operatorphone')},
                        {field: 'agreedata', title: __('Agreedata'), searchList: {"wait":__('Agreedata wait'),"agree":__('Agreedata agree'),"veto":__('Agreedata veto')}, formatter: Table.api.formatter.normal},
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