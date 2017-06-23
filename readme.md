#后端 API 文档 v1.0.0

##设计原则
- 命名清晰准确
- 版本号


##接口说明
所有的 API 都以 `domain.cn/api/...` 开头，API 分为两个部分，如`domain.cn/api/arg1/arg2`,arg1为 model 名称，arg2为动作行为名称。

每个 model 都存在增删改查 CURD 的方法，分别对应 create、delete、edit、read。

##模型部分

###Question

###字段说明
- `id` integer 编号
- `title` string 标题
- `description`  string 描述

###create
- 权限： 已登录
- 传参：
    - 必填：title 标题
    - 可选：desciption 描述

###change
- 权限：已登录且为问题所有者
- 传参：
    - 必填：id integer 问题编号
    - 可选：title string 
    - 可选：description
