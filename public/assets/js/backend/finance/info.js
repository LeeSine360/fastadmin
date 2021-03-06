define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/info/index' + location.search,
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
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'contacts', title: __('Contacts')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'projectinfo.name', title: __('Projectinfo.name')},
                        {field: 'projectsection.name', title: __('Projectsection.name')},
                        {field: 'companyinfo.name', title: __('Companyinfo.name')},
                        {field: 'category.name', title: __('Category.name')},
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

                $("#c-label_id").data("params", function(e){
                    var proId = $("#c-project_info_id").val();
                    var sectionId = $("#c-project_section_id").val();
                    var companyId = $("#c-company_info_id").val();
                    return {custom: {project_info_id: proId, section_info_id: sectionId, company_info_id: companyId}};
                });

                $("#c-project_section_id").data("params", function(e){
                    var proId = $("#c-project_info_id").val();
                    return {custom: {project_info_id: proId}};
                });

                $("#c-company_info_id").change(function(data){
                    $("#c-label_id").val("");
                    $("#c-label_id_text").val("");
                });

                $('input:radio').click(function(event) {
                    var radioValue = $(this).val();
                    if(radioValue == 47 ){
                        $("#c-company_info_id_text").attr("disabled",false);
                        $("#c-company_info_id_text").val("");
                        $("#c-company_info_id").val("");
                        $("#c-label_id").val("");
                        $("#c-label_id_text").val("");
                        $("#c-label_id_text").attr("disabled",true);
                    }else if(radioValue == 48){
                        $("#c-company_info_id_text").attr("disabled",false);
                        $("#c-label_id").val("");
                        $("#c-label_id_text").val("");
                        $("#c-label_id_text").attr("disabled",true);
                    }else{
                        $("#c-company_info_id_text").attr("disabled",false);    
                        $("#c-label_id_text").attr("disabled",false);                    
                    }
                });
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});