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
                    import_url: 'contract/info/import',
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
                        {field: 'number', title: __('Number')},
                        {field: 'project_info.short', title: __('Info.short')},
                        {field: 'project_section_names', title: __('Section.name')},
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

                $(document).on('click', ".btn-classify", function () {
                    Layer.open({
                        type: 2,
                        area: ['50%', '50%'], //宽高
                        content: "http://127.0.0.1/admin/contract/info/category?dialog=1"
                    });
                });
            }
        }
    };
    return Controller;
});