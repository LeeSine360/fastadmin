define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/tax/index' + location.search,
                    add_url: 'finance/tax/add',
                    edit_url: 'finance/tax/edit',
                    del_url: 'finance/tax/del',
                    multi_url: 'finance/tax/multi',
                    table: 'finance_tax',
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
                        {field: 'id', title: __('ID')},
                        {field: 'projectinfo.name', title: __('Project_info_id')},
                        {field: 'projectsection.name', title: __('Project_section_id')},
                        {field: 'starttime', title: __('Starttime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'zzs', title: __('Zzs'), operate:'BETWEEN'},
                        {field: 'cjs', title: __('Cjs'), operate:'BETWEEN'},
                        {field: 'jyfj', title: __('Jyfj'), operate:'BETWEEN'},
                        {field: 'dfjyfj', title: __('Dfjyfj'), operate:'BETWEEN'},
                        {field: 'yhs', title: __('Yhs'), operate:'BETWEEN'},
                        {field: 'grsds_c', title: __('Grsds_c'), operate:'BETWEEN'},
                        {field: 'grsds_g', title: __('Grsds_g'), operate:'BETWEEN'},
                        {field: 'qtsr_g', title: __('Qtsr_g'), operate:'BETWEEN'},
                        {field: 'sljs', title: __('Sljs'), operate:'BETWEEN'},
                        {field: 'qysds', title: __('Qysds'), operate:'BETWEEN'},
                        {field: 'ghjf', title: __('Ghjf'), operate:'BETWEEN'},                        
                        {field: 'creattime', title: __('Creattime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},                        
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