define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'company/bill/index' + location.search,
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
                        {field: 'project_info_id', title: __('Project_info_id')},
                        {field: 'project_section_id', title: __('Project_section_id')},
                        {field: 'company_info_id', title: __('Company_info_id')},
                        {field: 'endtime', title: __('Endtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'unpayment', title: __('Unpayment'), operate:'BETWEEN'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'contacts', title: __('Contacts')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'projectinfo.short', title: __('Projectinfo.short')},
                        {field: 'projectsection.name', title: __('Projectsection.name')},
                        {field: 'companyinfo.name', title: __('Companyinfo.name')},
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