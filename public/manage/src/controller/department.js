/**
 * 部门管理
 */
layui.define(['treeTable', 'form','layer'], function(exports){
  let $ = layui.$
    ,admin = layui.admin
    ,view = layui.view
    ,treeTable = layui.treeTable
    ,layer = layui.layer
    ,setter = layui.setter
    ,form = layui.form;

  // 渲染树形表格
  var insTb = treeTable.render({
    elem: '#LAY-permission-departments-table',
    url: '/department',
    request: {v: new Date().getTime()},
    headers: {Authorization: layui.data(setter.tableName).Authorization},
    tree: {
      iconIndex: 0,           // 折叠图标显示在第几列
      isPidData: true,        // 是否是id、pid形式数据
      idName: 'id',  // id字段名称
      pidName: 'parent_id',     // pid字段名称
    },
    cols: [[
      {field: 'department_name', title: '部门名称',width: 180},
      {field: 'identify', width: 120,title: '英文名称'},
      {field: 'principal',width: 120, title: '负责人'},
      {field: 'sort', width: 60,  title: '排序', sort: true},
      {field: 'mobile', width: 150,title: '联系电话',align: 'center'},
      {field: 'email',width: 180,title: '联系邮箱',align: 'center'},
      {field: 'roles_name', title: '拥有角色（部门全体成员）'},
      {field: 'status', width: 60,title: '状态',align: 'center',templet:'#statusTpl'},
      {title: '操作', width: 150, align: 'center',unresize:true, fixed: 'right', toolbar: '#tree-table-departments'}
    ]]
  });

  // 工具栏点击事件
  treeTable.on('tool(LAY-permission-departments-table)', function (obj) {
    let data = obj.data;
    switch (obj.event) {
      case 'edit':
        admin.popup({
          title: '编辑菜单/权限'
          ,area: ['600px', '680px']
          ,id: 'LAY-popup-permission-departments-form'
          ,success: function(layero, index){
            view(this.id).render('system/permission/departments/add_or_edit', data).done(function(){
              form.render(null, 'permission-departments-add-or-edit');

              //监听提交
              form.on('submit(LAY-permission-departments-submit)', function(data){
                let field = data.field; //获取提交的字段
                //提交 Ajax 成功后，关闭当前弹层并重载表格
                admin.req({
                  url: '/department/save'
                  ,type: 'post'
                  ,data: field
                  ,done: function(res){
                    layer.msg(res.msg);
                    insTb.refresh();  // 刷新(异步模式)
                  }
                });
                layer.close(index); //执行关闭
              });
            });
          }
        });
        break;
      case 'del':
        layer.confirm('真的删除行么', function(index){
          admin.req({
            url: '/department/del'
            ,type: 'post'
            ,data: data
            ,done: function(res){
              layer.msg(res.msg);
              obj.del(); // 重载
            }
          });
          layer.close(index);
        });
        break;
    }
  });

  exports('department', insTb)
});