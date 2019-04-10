define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'company/bill/index',
                    add_url: 'company/bill/add',
                    edit_url: 'company/bill/edit',
                    del_url: 'company/bill/del',
                    multi_url: 'company/bill/multi',
                    table: 'company_bill',
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
                        {field: 'project_info.short', title: __('Info.short')},
                        {field: 'project_section.name', title: __('Section.name')},
                        {field: 'company_info.name', title: __('Info.name')},
                        {field: 'payment', title: __('Payment'), operate:'BETWEEN'},
                        {field: 'unpayment', title: __('Unpayment'), operate:'BETWEEN'},
                        {field: 'starttime', title:__('Starttime')},
                        {field: 'endtime', title:__('Endtime')},
                        {field: 'contacts', title: __('Contacts')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            Controller.api.bindevent();
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                var proId = 0;

                $("#c-project_info_id").change(function(event) {
                    proId = $("#c-project_info_id").val();
                });

                $("#c-project_section_ids").data("params", function(e){
                    return {custom: {project_info_id: proId}};
                }); 
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});