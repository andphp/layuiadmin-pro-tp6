# layuiadmin-pro-tp6
layuiadmin v1.4.0 pro + thinkphp6.0.4

### 效果图

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