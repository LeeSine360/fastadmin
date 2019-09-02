define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'company/steellist/index' + location.search,
                    add_url: 'company/steellist/add',
                    edit_url: 'company/steellist/edit',
                    del_url: 'company/steellist/del',
                    multi_url: 'company/steellist/multi',
                    table: 'company_steellist',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                search: false,
                showToggle: false,
                sortName: 'date',
                searchFormVisible: true,
                searchFormTemplate: 'customformtpl',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'breed', title: __('Breed')},
                        {field: 'material', title: __('Material')},
                        {field: 'place', title: __('Place')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'raise', title: __('Raise')},
                        {field: 'spec', title: __('Spec')},
                        {field: 'unit', title: __('Unit')},
                        {field: 'note', title: __('Note')},
                        {field: 'date', title: __('Date'), operate:'RANGE', addclass:'datetimepicker', formatter: Table.api.formatter.datetime, datetimeFormat:"YYYY-MM-DD"}
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