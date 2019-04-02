define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/info/index',
                    add_url: 'contract/info/add',
                    edit_url: 'contract/info/edit',
                    del_url: 'contract/info/del',
                    multi_url: 'contract/info/multi',
                    table: 'contract_info',
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
                        {field: 'name', title: __('Name')},
                        {field: 'category.name', title: __('Category.name')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'phone', title: __('Phone')},
                        {field: 'signdate', title: __('Signdate'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'expirydate', title: __('Expirydate'), operate:'RANGE', addclass:'datetimerange'}, 
                        {field: 'operatorname', title: __('Operatorname')},
                        {field: 'operatorphone', title: __('Operatorphone')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            $("#c-project_info_id").on("change",function(e){
                var value = $("#c-project_info_id").val();
                var option = {"custom[type]":"classify","custom[pid]":value};
                $("#c-project_section_ids").attr("data-params",option);
            })

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
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});