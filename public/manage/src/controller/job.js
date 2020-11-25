
layui.define(['table', 'form'], function(exports){
  let $ = layui.$
    ,admin = layui.admin
    ,view = layui.view
    ,table = layui.table
    ,form = layui.form;

  let searchWhere = '';

  //岗位管理
  let jobTable = table.render({
    elem: '#LAY-table-permission-job'
    ,url: '/job' //模拟接口
    ,toolbar:'#LAY-table-toolbar-jobs'
    ,headers: {Authorization: layui.data(layui.setter.tableName).Authorization}
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field: 'job_name', width: 180,title: '岗位名称'}
      ,{field: 'coding', width: 180,title: '岗位编码'}
      ,{field: 'status', width: 80,align: 'center',title: '状态',templet:'#statusTpl'}
      ,{field: 'roles_name', title: '拥有岗位'}
      ,{field: 'description', minWidth:200,title: '具体描述'}
      ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#LAY-table-tool-jobs'}
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
      job_name: searchWhere
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

  //搜索岗位
  $('#btnSearch').click(function () {
    searchWhere = $('#edtSearch').val();
    //执行重载
    table.reload('LAY-table-permission-job',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        job_name: searchWhere
      }
    });
  });

  $('#btnClearSearch').click(function () {
    searchWhere = '';
    $('#edtSearch').val('');
    //执行重载
    table.reload('LAY-table-permission-job',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        job_name: searchWhere
      }
    });
  });

  //头工具栏事件
  table.on('toolbar(LAY-table-permission-job)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    var batchId = checkStatus.data.map((item)=>{return item.id});

    var batchData = [];
    switch(obj.event){
      case 'batchDelete':  //批量删除
        if(batchId.length < 1){
          layer.msg('未选中任何数据哦！',{icon: 2});
          return false;
        }
        layer.confirm('确定批量删除这些岗位？', function(index){
          admin.req({
            url: '/job/del_batch'
            ,type: 'post'
            ,data: {'ids':batchId}
            ,success: function(res){
              layer.msg(res.msg);
              jobTable.reload('LAY-table-permission-job'); //重载表格
            }
          });
          layer.close(index);
        });
        break;
      case 'batchDisable':  //批量禁用
        if(batchId.length < 1){
          layer.msg('未选中任何数据哦！',{icon: 2});
          return false;
        }
        layer.confirm('确定批量禁用这些岗位？', function(index){
          checkStatus.data.forEach((item)=>{batchData.push({id:item.id,status:2})});
          admin.req({
            url: '/job/update_status_batch'
            ,type: 'post'
            ,data: {ids:batchData}
            ,success: function(res){
              layer.msg(res.msg);
              jobTable.reload('LAY-table-permission-job'); //重载表格
            }
          });
          layer.close(index);
        });
        break;
      case 'batchEnable':  //批量启用
        if(batchId.length < 1){
          layer.msg('未选中任何数据哦！',{icon: 2});
          return false;
        }
        layer.confirm('确定批量启用这些岗位？', function(index){
          checkStatus.data.forEach((item)=>{batchData.push({id:item.id,status:1})});
          admin.req({
            url: '/job/update_status_batch'
            ,type: 'post'
            ,data: {ids:batchData}
            ,success: function(res){
              layer.msg(res.msg);
              jobTable.reload('LAY-table-permission-job'); //重载表格
            }
          });
          layer.close(index);
        });
        break;
    }
  });

  //监听
  table.on('tool(LAY-table-permission-job)', function(obj){
    var data = obj.data;
    switch(obj.event){
      case 'del': //删除
        layer.confirm('确定删除此岗位？', function(index){
          admin.req({
            url: '/job/del'
            ,type: 'post'
            ,data: data
            ,success: function(res){
              layer.msg(res.msg);
              obj.del();
              // jobTable.reload('LAY-table-permission-job'); //重载表格
            }
          });
          obj.del();
          layer.close(index);
        });
        break;
      case 'edit': //编辑
        admin.popup({
          title: '编辑岗位'
          ,area: ['600px', '680px']
          ,id: 'LAY-popup-permission-jobs-form'
          ,success: function(layero, index){
            view(this.id).render('system/permission/jobs/add_or_edit',data).done(function(){
              form.render(null, 'permission-jobs-add-or-edit');
              //监听提交
              form.on('submit(LAY-permission-jobs-submit)', function(data){
                var field = data.field; //获取提交的字段
                //提交 Ajax 成功后，关闭当前弹层并重载表格
                admin.req({
                  url: '/job/save'
                  ,type: 'post'
                  ,data: field
                  ,done: function(res){
                    layer.msg(res.msg);
                    layui.table.reload('LAY-table-permission-job'); //重载表格
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
  exports('job', {jobTable});
});