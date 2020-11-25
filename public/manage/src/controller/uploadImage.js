
layui.define(['table', 'form'], function(exports){
  var $ = layui.$
    ,admin = layui.admin
    ,view = layui.view
    ,table = layui.table
    ,form = layui.form;

  var searchWhere = '';

  //上传文件管理
  var uploadTable = table.render({
    elem: '#LAY-table-upload'
    ,url: '/upload' //模拟接口
    ,headers: {Authorization: layui.data(layui.setter.tableName).Authorization}
    ,cols: [[
      // {type: 'checkbox', fixed: 'left'}
      {field:'id',  width:60, title: 'ID', sort: true}
      ,{field: 'file_name', width: 180,title: '文件名'}
      ,{field: 'storage', width: 180,title: '储存方式'}
      ,{field: 'app', width: 180,title: '来自应用'}
      ,{field: 'file_size', width: 80,title: '大小'}
      ,{field: 'type', width: 80,title: '类型'}
      ,{field: 'url',title: '路径'}
      ,{field: 'created_time', minWidth:200,title: '创建时间'}
      ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#LAY-table-tool-uploads'}
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
      search_name: searchWhere
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

  //搜索上传文件
  $('#btnSearch').click(function () {
    searchWhere = $('#edtSearch').val();
    //执行重载
    table.reload('LAY-table-upload',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        search_name: searchWhere
      }
    });
  });

  $('#btnClearSearch').click(function () {
    searchWhere = '';
    $('#edtSearch').val('');
    //执行重载
    table.reload('LAY-table-upload',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        search_name: searchWhere
      }
    });
  });

  //监听
  table.on('tool(LAY-table-upload)', function(obj){
    var data = obj.data;
    switch(obj.event){
      case 'del': //删除
        layer.confirm('确定删除此文件吗？', function(index){
          admin.req({
            url: '/upload/del'
            ,type: 'post'
            ,data: data
            ,success: function(res){
              layer.msg(res.msg);
              obj.del();
              // roleTable.reload('LAY-table-permission-role'); //重载表格
            }
          });
          obj.del();
          layer.close(index);
        });
        break;
    }
  });

  //对外暴露的接口
  exports('uploadImage', {uploadTable});
});