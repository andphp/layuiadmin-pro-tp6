
layui.define(['table', 'form'], function(exports){
  var $ = layui.$
    ,admin = layui.admin
    ,view = layui.view
    ,table = layui.table
    ,form = layui.form;

  var searchWhere = '';

  //配置管理
  var configTable = table.render({
    elem: '#LAY-table-config'
    ,url: '/config' //模拟接口
    ,headers: {Authorization: layui.data(layui.setter.tableName).Authorization}
    ,cols: [[
      {field:'id',  width:60,title: 'ID', sort: true}
      ,{field: 'tag', width: 180,title: '配置标签'}
      ,{field: 'group', width: 180,title: '分组'}
      ,{field: 'name', width: 180,title: 'key'}
      ,{field: 'value',title: 'value'}
      ,{field: 'description', minWidth:200,title: '描述/备注'}
      ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#LAY-table-tool-configs'}
    ]]
    ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
      layout: [  'prev', 'page', 'next', 'skip','count','limit'] //自定义分页布局
      // ,curr: 5 //设定初始在第 5 页
      ,groups: 10 //只显示 1 个连续页码
      ,first: 1 //不显示首页
      ,last: true//不显示尾页
      ,limit: 10
    }
    ,where: {
      config_name: searchWhere
    }
    ,parseData: function(res){ //res 即为原始返回的数据
      return {
        "code": res.code, //解析接口状态
        "msg": res.msg, //解析提示文本
        "count": res.data.total, //解析数据长度
        "data": res.data.data, //解析数据列表
      };
    }
    ,text: {
      none: '暂无相关数据'
    }
  });

  //搜索配置
  $('#btnSearch').click(function () {
    searchWhere = $('#edtSearch').val();
    //执行重载
    table.reload('LAY-table-config',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        config_name: searchWhere
      }
    });
  });

  $('#btnClearSearch').click(function () {
    searchWhere = '';
    $('#edtSearch').val('');
    //执行重载
    table.reload('LAY-table-config',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        config_name: searchWhere
      }
    });
  });

  //监听
  table.on('tool(LAY-table-config)', function(obj){
    var data = obj.data;
    switch(obj.event){
      case 'editPlus': //删除
        admin.popup({
          title: '添加新配置'
          ,area: ['600px', '480px']
          ,id: 'LAY-popup-configs-form'
          ,success: function(layero, index){
            delete data.id;
            view(this.id).render('system/config/list/add_or_edit',data).done(function(){
              form.render(null, 'configs-add-or-edit');
              //监听提交
              form.on('submit(LAY-configs-submit)', function(data){
                var field = data.field; //获取提交的字段
                //提交 Ajax 成功后，关闭当前弹层并重载表格
                admin.req({
                  url: '/config/save'
                  ,type: 'post'
                  ,data: field
                  ,done: function(res){
                    layer.msg(res.msg);
                    layui.table.reload('LAY-table-config'); //重载表格
                  }
                });
                layui.table.reload('LAY-table-config'); //重载表格
                layer.close(index); //执行关闭
              });
            });
          }
        });
        break;
      case 'edit': //编辑
        admin.popup({
          title: '编辑配置'
          ,area: ['600px', '480px']
          ,id: 'LAY-popup-configs-form'
          ,success: function(layero, index){
            view(this.id).render('system/config/list/add_or_edit',data).done(function(){
              form.render(null, 'configs-add-or-edit');
              //监听提交
              form.on('submit(LAY-configs-submit)', function(data){
                var field = data.field; //获取提交的字段
                //提交 Ajax 成功后，关闭当前弹层并重载表格
                admin.req({
                  url: '/config/save'
                  ,type: 'post'
                  ,data: field
                  ,done: function(res){
                    layer.msg(res.msg);
                    layui.table.reload('LAY-table-config'); //重载表格
                  }
                });
                layer.close(index); //执行关闭
              });
            });
          }
        });
        break;
    }
  });

  //对外暴露的接口
  exports('configure', {configTable});
});