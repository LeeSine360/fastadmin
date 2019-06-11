define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/info/index' + location.search,
                    add_url: 'contract/info/add',
                    edit_url: 'contract/info/edit',
                    del_url: 'contract/info/del',
                    multi_url: 'contract/info/multi',
                    import_url: 'contract/info/import',
                    table: 'contract_info',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'Number',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), visible : false},
                        {field: 'number', title: __('Number')},
                        {field: 'projectName', title: __('Projectinfo.name'), operate:'LIKE'},
                        {field: 'sectionName', title: __('Projectsection.name')},
                        {field: 'companyName', title: __('Companyinfo.name'), operate:'LIKE'},
                        {field: 'contractName', title: __('Name')}, 
                        {field: 'categoryName', title: __('Category.name')},
                        {field: 'contractPrice', title: __('Price'), operate:'BETWEEN'},
                        {field: 'contractTotal', title: __('Total')},
                        {field: 'contractSave', title: __('Save')},
                        {field: 'contractPhone', title: __('Phone')},
                        {field: 'contractOperatorName', title: __('Operatorname')},
                        {field: 'contractOperatorPhone', title: __('Operatorphone')},
                        {field: 'projectSavedata', title: __('Projectsavedata')},
                        {field: 'syntheticalAgreedata', title: __('Syntheticalagreedata')},
                        {field: 'verifyAgreedata', title: __('Verifyagreedata')},
                        {field: 'contractCreateTime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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