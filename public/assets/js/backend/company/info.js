define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'company/info/index',
                    add_url: 'company/info/add',
                    edit_url: 'company/info/edit',
                    del_url: 'company/info/del',
                    multi_url: 'company/info/multi',
                    import_url: 'company/info/import',
                    table: 'company_info',
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
                        {field: 'name', title: __('Name')},
                        {field: 'code', title: __('Code')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'account', title: __('Account')},
                        {field: 'bankname', title: __('Bankname')},
                        {field: 'admin.username', title: __('Admin.username')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

           /* if ($(".com-btn-refresh").size() > 0) {
                $(".btn-refresh").on('click', function () {
                    $(this).find(".fa").addClass("fa-spin");
                    //$(this).find(".fa").removeClass("fa-spin");
                }
            }*/
            console.log($(".com-btn-refresh").size());

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