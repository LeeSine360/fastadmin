define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/payconfirm/index' + location.search,
                    table: 'finance_payconfirm',
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
                        {field: 'financeContacts', title: __('FinanceContacts')},
                        {field: 'financePhone', title: __('FinancePhone')},
                        {field: 'financeRemark', title: __('FinanceRemark')},
                        {field: 'projectAgreeData', title: __('ProjectAgreedata'), searchList: {"wait":__('ProjectAgreedata wait'),"agree":__('ProjectAgreedata agree'),"veto":__('ProjectAgreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'verifyAgreeData', title: __('VerifyAgreedata'), searchList: {"wait":__('VerifyAgreedata wait'),"agree":__('VerifyAgreedata agree'),"veto":__('VerifyAgreedata veto')}, formatter: Table.api.formatter.normal},
                        {field: 'opinion', title: __('Opinion')},
                        {field: 'financePrice', title: __('FinancePrice')},
                        {field: 'payprice', title: __('Payprice')},
                        {field: 'createTime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},

                        {
                            field: 'operate', 
                            title: __('Operate'), 
                            table: table, 
                            events: Table.api.events.operate,
                            buttons: [{
                                name: 'confirm',
                                text: __('确认'),
                                title: __('确认'),
                                classname: 'btn btn-xs btn-primary btn-dialog',
                                icon: 'fa fa-key',
                                url: 'finance/project/examine',
                                callback: function(data) {
                                    //Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                                }
                            }], 
                            formatter: Table.api.formatter.operate
                        }
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