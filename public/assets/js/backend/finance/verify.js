define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/verify/index' + location.search,
                    table: 'finance_verify',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                search: false, //是否启用快速搜索
                commonSearch: false, //是否启用通用搜索
                showExport: false,
                showToggle: false,
                showColumns: false,
                columns: [
                    [
                        {field: 'id', title: __('ID')},
                        {field: 'financeId', title: __('FinanceId')},
                        {field: 'projectName', title: __('ProjectName')},
                        {field: 'sectionName', title: __('SectionName')},
                        {field: 'companyName', title: __('CompanyName')},
                        {field: 'categoryName', title: __('CategoryName')}, 
                        {field: 'financePrice', title: __('FinancePrice')},
                        {field: 'financeContacts', title: __('FinanceContacts')},
                        {field: 'financePhone', title: __('FinancePhone')},
                        {field: 'financeRemark', title: __('FinanceRemark')},
                        {field: 'agreeData', title: __('Agreedata'), searchList: {"wait":__('Agreedata wait'),"agree":__('Agreedata agree'),"veto":__('Agreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'createTime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [{
                                name: 'examine',
                                text: __('审核'),
                                title: __('审核'),
                                classname: 'btn btn-xs btn-primary btn-dialog',
                                icon: 'fa fa-key',
                                url: 'finance/verify/examine',
                                callback: function(data) {
                                    //Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                                }
                        }],
                        formatter: Table.api.formatter.operate
                    }]
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