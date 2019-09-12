define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'accounting', 'echarts', 'echarts-theme'], function ($, undefined, Backend, Table, Form, Accounting, Echarts, undefined) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'project/section/index' + location.search,
                    add_url: 'project/section/add',
                    edit_url: 'project/section/edit',
                    del_url: 'project/section/del',
                    multi_url: 'project/section/multi',
                    table: 'project_section',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                searchFormTemplate: 'form-commonsearch',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'projectName', title: __('Projectinfo.name')},
                        {field: 'sectionName', title: __('Name')},                        
                        {field: 'price', title: __('Price'), align: 'right', halign: 'center', operate:'BETWEEN', formatter: Controller.api.formatter.accounting},                        
                        {field: 'payPrice', title: __('已付金额'), align: 'right', halign: 'center', formatter: Controller.api.formatter.accounting},
                        {field: 'managerName', title: __('Projectmanager.name')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {
                            field: 'operate', 
                            title: __('Operate'), 
                            table: table, 
                            events: Table.api.events.operate, 
                            buttons: [{
                                name: 'addtabs',
                                title: __('标段详情'),
                                classname: 'btn btn-xs btn-warning btn-addtabs',
                                icon: 'fa fa-folder-o',
                                url: 'project/section/detail'
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
        detail:function(){
            var myChart = Echarts.init(document.getElementById('echart'), 'walden');

            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: '付款曲线图',
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: [__('Sales'), __('Orders')]
                },
                toolbox: {
                    show: false,
                    feature: {
                        magicType: {show: true, type: ['stack', 'tiled']},
                        saveAsImage: {show: true}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: Orderdata.column
                },
                yAxis: {},
                grid: [{
                    left: 'left',
                    top: 'top',
                    right: '10',
                    bottom: 30
                }],
                series: [{
                    name: __('Sales'),
                    type: 'line',
                    smooth: true,
                    areaStyle: {
                        normal: {}
                    },
                    lineStyle: {
                        normal: {
                            width: 1.5
                        }
                    },
                    data: Orderdata.paydata
                },
                    {
                        name: __('Orders'),
                        type: 'line',
                        smooth: true,
                        areaStyle: {
                            normal: {}
                        },
                        lineStyle: {
                            normal: {
                                width: 1.5
                            }
                        },
                        data: Orderdata.createdata
                    }]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);

            //动态添加数据，可以通过Ajax获取数据然后填充
            setInterval(function () {
                Orderdata.column.push((new Date()).toLocaleTimeString().replace(/^\D*/, ''));
                var amount = Math.floor(Math.random() * 200) + 20;
                Orderdata.createdata.push(amount);
                Orderdata.paydata.push(Math.floor(Math.random() * amount) + 1);

                //按自己需求可以取消这个限制
                if (Orderdata.column.length >= 20) {
                    //移除最开始的一条数据
                    Orderdata.column.shift();
                    Orderdata.paydata.shift();
                    Orderdata.createdata.shift();
                }
                myChart.setOption({
                    xAxis: {
                        data: Orderdata.column
                    },
                    series: [{
                        name: __('Sales'),
                        data: Orderdata.paydata
                    },
                        {
                            name: __('Orders'),
                            data: Orderdata.createdata
                        }]
                });
                if ($("#echart").width() != $("#echart canvas").width() && $("#echart canvas").width() < $("#echart").width()) {
                    myChart.resize();
                }
            }, 2000);
            $(window).resize(function () {
                myChart.resize();
            });

            $(document).on("click", ".btn-checkversion", function () {
                top.window.$("[data-toggle=checkupdate]").trigger("click");
            });  

            var myChart_pie = Echarts.init(document.getElementById("echart-pie"));
            var option_pie = {
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
                        {value: 11212445,name: '人工工资'},
                        {value: 1212124,name: '其他已付金额'},                        
                        {value: 12121244,name: '未拨付金额'}
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
            myChart_pie.setOption(option_pie);

            //预算详情表
            var table = $("#budget_table");
            // 初始化表格
            table.bootstrapTable({
                url: 'contract/verify/payinfo',
                pk: 'id',
                sortName: 'id',
                search: false, //是否启用快速搜索
                commonSearch: false, //是否启用通用搜索
                showExport: false,
                showToggle: false,
                showColumns: false,
                columns: [
                    [{field: 'id',title: __('Id'),visible: true}, 
                    {field: 'companyName',title: __('类型名称')}, 
                    {field: 'number',title: __('单价')},
                    {field: 'projectName',title: __('数量')}, 
                    {field: 'number',title: __('单位')}, 
                    {field: 'sectionName',title: __('金额')},
                    {field: 'sectionName',title: __('已付合计')},
                    {field: 'sectionName',title: __('占比')}]                    
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
            
            //欠款明细表
            var table = $("#owe_table");
            // 初始化表格
            table.bootstrapTable({
                url: 'contract/verify/payinfo',
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
                    {field: 'projectName',title: __('合同金额')}, 
                    {field: 'number',title: __('已付合计')}, 
                    {field: 'sectionName',title: __('欠款金额')},
                    {field: 'sectionName',title: __('对账截止日期')}]                    
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        api: {
            formatter: {
                accounting: function (value, row, index) {
                    return value ? Accounting.format(value,2) : __('None');
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});