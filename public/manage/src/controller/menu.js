/**
 * 菜单管理
 */
layui.define(['treeTable', 'form','layer'], function(exports){
  var $ = layui.$
    ,admin = layui.admin
    ,view = layui.view
    ,treeTable = layui.treeTable
    ,layer = layui.layer
    ,form = layui.form;

  // 渲染树形表格
  var insTb = treeTable.render({
    elem: '#LAY-permission-menus-table',
    url: '/menu/list',
    request: {v: new Date().getTime()},
    headers: {Authorization: layui.data(layui.setter.tableName).Authorization},
    tree: {
      iconIndex: 0,           // 折叠图标显示在第几列
      isPidData: true,        // 是否是id、pid形式数据
      idName: 'id',  // id字段名称
      pidName: 'parent_id',     // pid字段名称
    },
    cols: [[
      {field: 'title', title: '菜单',width: 180},
      {field: 'name', width: 120,title: '菜单名称'},
      {field: 'icon', title: '图标',align: 'center',width: 60,templet: '#iconTpl'},
      {field: 'jump', title: '菜单【按钮】/ 按钮【权限】/ 外链【地址】',templet:'#jumpTpl'},
      {field: 'sort', width: 60,  title: '排序', sort: true},
      {field: 'spread', width: 100,title: '默认展示子菜单',align: 'center',templet:'#spreadTpl'},
      {field: 'hidden', width: 60,title: '隐藏菜单',align: 'center',templet:'#hiddenTpl'},
      {field: 'type', width: 60,title: '类型',align: 'center',templet:'#typeTpl'},
      {field: 'permission_adopt', width: 60,title: '全局权限',align: 'center',templet:'#adoptTpl'},
      {title: '操作', width: 150, align: 'center',unresize:true, fixed: 'right', toolbar: '#tree-table-menus'}
    ]]
  });

  // 工具栏点击事件
  treeTable.on('tool(LAY-permission-menus-table)', function (obj) {
    var data = obj.data;
    switch (obj.event) {
      case 'edit':
        admin.popup({
          title: '编辑菜单/权限'
          ,area: ['600px', '680px']
          ,id: 'LAY-popup-permission-menus-form'
          ,success: function(layero, index){
            view(this.id).render('system/permission/menus/add_or_edit', data).done(function(){
              form.render(null, 'permission-menus-add-or-edit');

              //监听提交
              form.on('submit(LAY-permission-menus-submit)', function(data){
                var field = data.field; //获取提交的字段
                //提交 Ajax 成功后，关闭当前弹层并重载表格
                admin.req({
                  url: '/menu/save'
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
            url: '/menu/del'
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

  exports('menu', insTb)
});