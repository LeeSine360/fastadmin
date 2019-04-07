define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/temp/index',
                    add_url: 'contract/temp/add',
                    edit_url: 'contract/temp/edit',
                    del_url: 'contract/temp/del',
                    multi_url: 'contract/temp/multi',
                    import_url: 'contract/temp/import',
                    table: 'contract_temp',                    
                }
            });

            var table = $("#table");console.log('index');

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'date', title: __('Date'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'project_name', title: __('Project_name')},
                        {field: 'bids_name', title: __('Bids_name')},
                        {field: 'manager_name', title: __('Manager_name')},
                        {field: 'number', title: __('Number')},
                        {field: 'company_name', title: __('Company_name')},
                        {field: 'contract_name', title: __('Contract_name')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'total', title: __('Total')},
                        {field: 'save', title: __('Save')},
                        {field: 'contents', title: __('Contents')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'state', title: __('State')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            var proId = 0;

            $("#c-project_info_id").change(function(event) {
                proId = $("#c-project_info_id").val();
            });

            $("#c-project_section_ids").data("params", function(e){
                return {custom: {project_info_id: proId}};
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