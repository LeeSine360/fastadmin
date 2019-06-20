define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'echarts'], function($, undefined, Backend, Table, Form, Echarts) {
    var Controller = {
        index: function() {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/verify/index' + location.search,
                    table: 'contract_verify',
                }
            });
            var table = $("#table");
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [{
                        field: 'id',
                        title: __('Id'),
                        visible: false
                    }, {
                        field: 'number',
                        title: __('Number')
                    }, {
                        field: 'projectName',
                        title: __('ProjectName'),
                        operate: 'LIKE'
                    }, {
                        field: 'sectionName',
                        title: __('SectionName'),
                        operate: 'FINDIN'
                    }, {
                        field: 'companyName',
                        title: __('CompanyName'),
                        operate: 'LIKE'
                    }, {
                        field: 'contractName',
                        title: __('ContractName')
                    }, {
                        field: 'contractCreateTime',
                        title: __('Createtime'),
                        operate: 'RANGE',
                        addclass: 'datetimerange',
                        formatter: Table.api.formatter.datetime
                    }, {
                        field: 'operate',
                        title: __('Operate'),
                        table: table,
                        events: Table.api.events.operate,
                        buttons: [{
                            name: 'examine',
                            title: __('审核'),
                            classname: 'btn btn-xs btn-primary btn-dialog',
                            icon: 'fa fa-key',
                            url: 'contract/verify/examine',
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
        add: function() {
            Controller.api.bindevent();
        },
        edit: function() {
            Controller.api.bindevent();
        },
        examine: function() {
            
        },
        api: {
            bindevent: function() {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});