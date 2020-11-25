# layuiadmin-pro-tp6
layuiadmin v1.4.0 pro（单页版） + thinkphp6.0.4

### 注：仅用于学习使用

### 效果图
![登录页](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme1.png?raw=true)
![登录成功](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme2.png?raw=true)
![欢迎页](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme3.png?raw=true)
![菜单权限页](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme4.png?raw=true)
![切换主题](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme5.png?raw=true)
![切换主题](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme6.png?raw=true)
![切换主题](https://github.com/andphp/layuiadmin-pro-tp6/blob/master/public/static/images/readme7.png?raw=true)
### 下载

```
git clone https://github.com/andphp/layuiadmin-pro-tp6.git
```

### 安装

```
cd layuiadmin-pro-tp6(项目目录)
```

### 配置数据库信息

```
cp .example.env .env
```

### 安装依赖
```
composer install && composer update
```
### 执行数据迁移

```
php think migrate:run
```

### 访问后台

```
http://localhost/manage/start/index.html
```

### 初始管理员账户密码

```
admin     =>    admin
```

### 注意

> 项目默认开启了 自动多应用模式 ，并默认需要进行域名绑定，需要配置 localhost（admin.test.com）
> 若取消配置 域名绑定，需要修改**/public/manage** 下涉及后端数据请求url路径（todo: config中加入公共前置变量）