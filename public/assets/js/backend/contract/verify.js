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
                search: false, //是否启用快速搜索
                commonSearch: false, //是否启用通用搜索
                showExport: false,
                showToggle: false,
                showColumns: false,
                columns: [
                    [{field: 'id',title: __('Id'),visible: false}, 
                    {field: 'number',title: __('Number')}, 
                    {field: 'projectName',title: __('ProjectName'),operate: 'LIKE'}, 
                    {field: 'sectionName',title: __('SectionName'),operate: 'FINDIN'}, 
                    {field: 'companyName',title: __('CompanyName'),operate: 'LIKE'}, 
                    {field: 'contractName',title: __('ContractName')},
                    {field: 'contractCreateTime',title: __('Createtime'),operate: 'RANGE',addclass: 'datetimerange',formatter: Table.api.formatter.datetime}, 
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
        payinfo: function(){
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/verify/payinfo' + location.search,
                }
            });
            var table = $("#payinfo_table");
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
                    [{field: 'id',title: __('Id'),visible: true}, 
                    {field: 'companyName',title: __('供应商名称')}, 
                    {field: 'number',title: __('类型')}, 
                    {field: 'projectName',title: __('预算金额')}, 
                    {field: 'sectionName',title: __('已付合计')},
                    {field: 'sectionName',title: __('欠款金额')}
                    ]
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        contract: function(){
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contract/verify/contract' + location.search,
                }
            });
            var table = $("#contract_table");
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
                    [{field: 'id',title: __('Id'),visible: true}, 
                    {field: 'companyName',title: __('供应商名称')}, 
                    {field: 'number',title: __('类型')}, 
                    {field: 'projectName',title: __('预算金额')}, 
                    {field: 'sectionName',title: __('已付合计')},
                    {field: 'sectionName',title: __('欠款金额')}
                    ]
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        examine: function() {
            var dom = document.getElementById("echarts");
            var myChart = Echarts.init(dom);
            var option = {
                title: {
                    text: '资金拨付占比情况',
                    x: 'center'
                },
                series: [{
                    name: 'pay',
                    type: 'pie',
                    radius: '60%',
                    center: ['25%', '60%'],
                    hoverOffset: 1,
                    data: [
                        {value: 125313213,name: '已拨付金额'}, 
                        {value: 121212445,name: '未拨付金额'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        },
                    },
                    label: {
                        normal: {
                            show: true,
                            formatter: "{b}:\n{d}%" //多值的嵌套
                        }
                    }
                },{
                    name: 'payinfo',
                    type: 'pie',
                    radius: '60%',
                    center: ['75%', '60%'],
                    hoverOffset: 1,
                    data: [
                        {value: 154000,name: '钢材付款金额',categoryId: 'steel'},
                        {value: 124000,name: '混凝土付款金额'},
                        {value: 542400,name: '模板付款金额'},
                        {value: 24000,name: '砂浆付款金额'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        },
                    },
                    label: {
                        normal: {
                            show: true,
                            formatter: "{b}:\n{d}%" //多值的嵌套
                        }
                    }
                }]
            };
            var options = {
                series: [{
                    name: ['pay'],
                    data: [
                            {value: 154000,name: '钢材付款金额',categoryId: 'steel'},
                            {value: 124000,name: '混凝土付款金额'}
                        ]
                },{
                     // 根据名字对应到相应的系列
                    name: ['payinfo'],
                    data: [
                            {value: 154000,name: '钢材付款金额',categoryId: 'steel'},
                            {value: 124000,name: '混凝土付款金额'}
                        ]
                }]
             };
            myChart.setOption(option, true);
            myChart.setOption(options);
            myChart.on('click', function(params) {
                //typeof(exp) == undefined
                Fast.api.open('/admin/contract/verify/payinfo')
                //console.log(params.data.type);
            });           
            
            $(document).on('click', '.btn-callback', function() {
                Fast.api.close($("input[name=callback]").val());
            });

            $(document).on("click", ".btn-default", function () {
                Fast.api.open($(this).data('url'));
            });
        },
        api: {
            bindevent: function() {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});