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
            var dom = document.getElementById("echarts");
            var myChart = Echarts.init(dom);
            var option = {
                title: {
                    text: '资金拨付占比情况',
                    x: 'center'
                },
                series: [{
                    name: '资金拨付情况',
                    type: 'pie',
                    radius: '60%',
                    center: ['25%', '60%'],
                    hoverOffset: 1,
                    data: [
                        {value: 125313213,name: '已拨付金额',url: 'www.baidu.com'}, 
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
                    name: '拨付情况',
                    type: 'pie',
                    radius: '60%',
                    center: ['70%', '60%'],
                    hoverOffset: 1,
                    data: [
                        {value: 335,name: '材料已付金额',url: 'www.baidu.com'}, 
                        {value: 514,name: '设备已付金额'},
                        {value: 4543,name: '分包已付金额'},
                        {value: 1242,name: '人工已付金额'},
                        {value: 3746,name: '其他已付金额'}
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
            myChart.setOption(option, true);
            myChart.on('click', function(params) {
                console.log(params.data.url);
            });           
            
            $(document).on('click', '.btn-callback', function() {
                Fast.api.close($("input[name=callback]").val());
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