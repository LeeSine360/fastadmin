define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var flowDesignPanel;
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'flow/start',
                    add_url: 'flow/scheme/add',
                    edit_url: '',
                    del_url: '',
                    table: 'flow_scheme',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                singleSelect: true,
                sortName: 'id',
                columns: [
                    [
                        {field: 'id', title: 'id', visible: false, operate: false},
                        {field: 'flowcode', title: '流程代码', operate: 'like'},
                        {field: 'flowname', title: '流程名称', operate: 'like'},
                        {field: 'operate', title: __('Operate'), table: table, formatter: Controller.api.formatter.flowCode}
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
            var options = JSON.parse($("input[name='row[flowcontent]']").val());
            var schemeContent = options;
            flowDesignPanel = $('#flow').flowdesign({
                height: 800,
                widht: 800,
                nodeData: schemeContent.nodes,
                flowcontent: schemeContent,
                OpenNode: function (object) {
                },
                OpenLine: function (id, object) {
                    return;
                }
            })
            document.getElementById("ok").addEventListener('click', function () {
                var content = flowDesignPanel.exportDataEx();
                var schemecontent = JSON.stringify(content);
                $("input[name='row[flowcontent]']").val(schemecontent);
            }, false)
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                flowCode: function (value, row, index) {
                    url = "flow/" + row.flowcode + "/add?ids=" + row.id;

                    //方式一,直接返回class带有addtabsit的链接,这可以方便自定义显示内容
                    return '<a href="' + url + '" class="btn btn-xs btn-primary btn-dialog" title="' + row.flowname + '">发起流程</a>';

                    //方式二,直接调用Table.api.formatter.addtabs
                    return Table.api.formatter.addtabs(value, row, index, url);
                }
            }
        }
    };
    return Controller;
});