define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/info/index',
                    add_url: 'finance/info/add',
                    edit_url: 'finance/info/edit',
                    del_url: 'finance/info/del',
                    multi_url: 'finance/info/multi',
                    table: 'finance_info',
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
                        {field: 'project_info.short', title: __('Project.name')},
                        {field: 'project_section.name', title: __('Section.name')},
                        {field: 'category.name', title: __('Category.name')},
                        {field: 'company_info.name', title: __('Company.name')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'contacts', title: __('Contacts')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'remarkcontent', title: __('Remarkcontent')},
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

                $('input:radio').click(function(event) {
                    var radioValue = $(this).val();
                    if(radioValue == 47){
                        $("#c-company_info_id_text").attr("disabled",true);
                    }else{
                        $("#c-company_info_id_text").attr("disabled",false);
                    }
                });


                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});