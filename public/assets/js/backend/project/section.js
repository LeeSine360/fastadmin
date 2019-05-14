define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'project/section/index',
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
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'info.name', title: __('Info.name')},
                        {field: 'manager.name', title: __('Manager.name')},
                        {field: 'admin.username', title: __('Admin.username')},
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
                $("#c-project_section_ids").data("params", function(e){
                    var proId = $("#c-project_info_id").val();
                    return {custom: {project_info_id: proId}};
                }); 

                Form.api.bindevent($("form[role=form]"));  
            }
        }
    };
    return Controller;
});