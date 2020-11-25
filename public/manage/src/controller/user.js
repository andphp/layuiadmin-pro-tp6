/**

 @Name：layuiAdmin 用户登入和注册等
 @Author：贤心
 @Site：http://www.layui.com/
 @License: LPPL
    
 */
 
layui.define(['table', 'form'], function(exports){
  let $ = layui.$
  ,layer = layui.layer
  ,laytpl = layui.laytpl
  ,setter = layui.setter
  ,view = layui.view
  ,admin = layui.admin
    ,table = layui.table
    ,form = layui.form;

  let $body = $('body');
  
  //自定义验证
  form.verify({
    nickname: function(value, item){ //value：表单的值、item：表单的DOM对象
      if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
        return '用户名不能有特殊字符';
      }
      if(/(^\_)|(\__)|(\_+$)/.test(value)){
        return '用户名首尾不能出现下划线\'_\'';
      }
      if(/^\d+\d+\d$/.test(value)){
        return '用户名不能全为数字';
      }
    }
    
    //我们既支持上述函数式的方式，也支持下述数组的形式
    //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
    ,pass: [
      /^[\S]{6,12}$/
      ,'密码必须6到12位，且不能出现空格'
    ] 
  });

  
  //更换图形验证码
  $body.on('click', '#LAY-user-get-vercode', function(){
    let othis = $(this);
    this.src = '/captcha?t='+ new Date().getTime()
  });
  
  //===========
  let searchWhere = '';

  //用户管理
  var userTable = table.render({
    elem: '#LAY-table-permission-user'
    ,url: '/user' //模拟接口
    ,toolbar:'#LAY-table-toolbar-users'
    ,headers: {Authorization: layui.data(layui.setter.tableName).Authorization}
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field: 'avatar', width: 80,title: '头像',templet:'#avatarTpl'}
      ,{field: 'username', width: 180,title: '用户名称'}
      ,{field: 'email', width: 180,title: '电子邮箱'}
      ,{field: 'status', width: 80,align: 'center',title: '状态',templet:'#statusTpl'}
      ,{field: 'roles_name', title: '拥有用户'}
      ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#LAY-table-tool-users'}
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
      user_name: searchWhere
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
    },
    done:function(res,curr,count){
      hoverOpenImg();//显示大图
      $('table tr').on('click',function(){
        $('table tr').css('background','');
        $(this).css('background','<%=PropKit.use("config.properties").get("table_color")%>');
      });

      var state = "";
      for (var i in res.data) {
        var item = res.data[i];
        if (item.id == 1) {// 这里是判断需要禁用的条件（如：状态为0的）
          // checkbox 根据条件设置不可选中
          $('tr[data-index=' + i + '] input[type="checkbox"]').prop('disabled', true);
          state = "1";// 隐藏表头全选判断状态
          form.render();// 重新渲染一下
        }
      }
      //判断条件
      if(state == "1"){
        // 根据条件移除全选 checkbox
        $('th[data-field=0] div').replaceWith('<div class="layui-table-cell laytable-cell-1-0-0"><span></span></div>');
      }else {
        //翻页显示全选按钮 checkbox
        $('th[data-field=0] div').replaceWith('<div class="layui-table-cell laytable-cell-1-0-0 laytable-cell-checkbox"><input type="checkbox" name="layTableCheckbox" lay-skin="primary" lay-filter="layTableAllChoose"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div></div>');
      }

    }
  });

  function hoverOpenImg(){
    var img_show = null; // tips提示
    $('td img').hover(function(){
      var kd=$(this).width();
      kd1=kd*8;          //图片放大倍数
      kd2=kd*8+30;       //图片放大倍数
      var img = "<img class='img_msg' src='"+$(this).attr('src')+"' style='width:"+kd1+"px;' />";
      img_show = layer.tips(img, this,{
        tips:[2, 'rgba(41,41,41,.5)']
        ,area: [kd2+'px']
      });
    },function(){
      layer.close(img_show);
    });
    $('td img').attr('style','max-width:70px;display:block!important');
  }

  //搜索用户
  $('#btnSearch').click(function () {
    searchWhere = $('#edtSearch').val();
    //执行重载
    table.reload('LAY-table-permission-user',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        username: searchWhere
      }
    });
  });

  $('#btnClearSearch').click(function () {
    searchWhere = '';
    $('#edtSearch').val('');
    //执行重载
    table.reload('LAY-table-permission-user',{
      page: {
        curr: 1 //重新从第 1 页开始
      }
      ,where: {
        username: searchWhere
      }
    });
  });

  //头工具栏事件
  table.on('toolbar(LAY-table-permission-user)', function(obj){
    let checkStatus = table.checkStatus(obj.config.id);
    let batchId = checkStatus.data.map((item)=>{return item.id});

    let batchData = [];
    switch(obj.event){
      case 'batchDelete':  //批量删除
        if(batchId.length < 1){
          layer.msg('未选中任何数据哦！',{icon: 2});
          return false;
        }
        layer.confirm('确定批量删除这些用户？', function(index){
          admin.req({
            url: '/user/del_batch'
            ,type: 'post'
            ,data: {'ids':batchId}
            ,success: function(res){
              layer.msg(res.msg);
              userTable.reload('LAY-table-permission-user'); //重载表格
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
        layer.confirm('确定批量禁用这些用户？', function(index){
          checkStatus.data.forEach((item)=>{batchData.push({id:item.id,status:2})});
          admin.req({
            url: '/user/update_status_batch'
            ,type: 'post'
            ,data: {ids:batchData}
            ,success: function(res){
              layer.msg(res.msg);
              userTable.reload('LAY-table-permission-user'); //重载表格
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
        layer.confirm('确定批量启用这些用户？', function(index){
          checkStatus.data.forEach((item)=>{batchData.push({id:item.id,status:1})});
          admin.req({
            url: '/user/update_status_batch'
            ,type: 'post'
            ,data: {ids:batchData}
            ,success: function(res){
              layer.msg(res.msg);
              userTable.reload('LAY-table-permission-user'); //重载表格
            }
          });
          layer.close(index);
        });
        break;
    }
  });

  //监听
  table.on('tool(LAY-table-permission-user)', function(obj){
    let data = obj.data;
    switch(obj.event){
      case 'del': //删除
        layer.confirm('确定删除此用户？', function(index){
          admin.req({
            url: '/user/del'
            ,type: 'post'
            ,data: data
            ,success: function(res){
              layer.msg(res.msg);
              obj.del();
              // userTable.reload('LAY-table-permission-user'); //重载表格
            }
          });
          obj.del();
          layer.close(index);
        });
        break;
      case 'edit': //编辑
        admin.popup({
          title: '编辑用户'
          ,area: ['600px', '680px']
          ,id: 'LAY-popup-permission-users-form'
          ,success: function(layero, index){
            view(this.id).render('system/permission/users/add_or_edit',data).done(function(){
              form.render(null, 'permission-users-add-or-edit');
              //监听提交
              form.on('submit(LAY-permission-users-submit)', function(data){
                let field = data.field; //获取提交的字段
                //提交 Ajax 成功后，关闭当前弹层并重载表格
                admin.req({
                  url: '/user/save'
                  ,type: 'post'
                  ,data: field
                  ,done: function(res){
                    layer.msg(res.msg);
                    layui.table.reload('LAY-table-permission-user'); //重载表格
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
  exports('user', {userTable});
});