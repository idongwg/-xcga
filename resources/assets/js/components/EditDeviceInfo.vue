<template>
    <div style="width:100%">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>车辆管理</el-breadcrumb-item>
            <el-breadcrumb-item>编辑</el-breadcrumb-item>
        </el-breadcrumb>
        <div style="width:40%;min-width:480px;margin:0 auto">
            <!-- <div class="box_item">
                <span class="items_edit">ID：</span>
                <el-input v-model="tableData.id" placeholder="请输入内容" class="con_edit"></el-input>
            </div>
            <div class="box_item">
                <span class="items_edit">车辆ID：</span>
                <el-input v-model="tableData.uuid" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">车辆编号：</span>
                <el-input v-model="tableData.code" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <div class="box_item">
                <span class="items_edit">车牌号：</span>
                <el-input v-model="tableData.title" placeholder="请输入内容" class="con_edit"></el-input>
            </div>
            <div class="box_item">
                <span class="items_edit">绑定设备ID：</span>
                <el-input v-model="tableData.device_uuid" placeholder="请输入内容" class="con_edit"></el-input>
            </div>
            
            <!-- <div class="box_item">
                <span class="items_edit">车辆所属队伍：</span>
                <el-input v-model="tableData.department_uuid" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">车辆类型：</span>
                <el-input v-model="tableData.sweeper_type" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">车辆计数：</span>
                <el-input v-model="tableData.engine_number" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">地盘计数：</span>
                <el-input v-model="tableData.chassis_number" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">车辆型号：</span>
                <el-input v-model="tableData.model_number" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">厂家：</span>
                <el-input v-model="tableData.manufacturer" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <!-- <div class="box_item">
                <span class="items_edit">描述：</span>
                <el-input v-model="tableData.department_uuid" placeholder="请输入内容" class="con_edit"></el-input>
            </div> -->
            <div class="box_item" align="center">
                <el-button type="primary">取消修改</el-button>
                <el-button type="primary" @click="submit_edit">提交修改</el-button>
            </div>
            
        </div>
        <!-- <div style="float:left;width:48%;height:720px">
            <div class="box_item_img">
                <div class="box_item box_item_show">
                    <span class="items_edit">厂家：</span>
                    <img src="tableData.img_url" class="img_show" />
                </div>
                <div>
                    <span class="items_edit">上传图片：</span>
                    <el-upload class="upload-demo" drag action="https://jsonplaceholder.typicode.com/posts/" multiple>
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">将文件拖到此处，或
                            <em>点击上传</em>
                        </div>
                        <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </div>
            </div>
            <div class="submit_box">
                <el-button type="primary">取消修改</el-button>
                <el-button type="primary">提交修改</el-button>
            </div>
        </div> -->



    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: {
                    device_uuid: ''
                },
                input_sweeper_type: "",
                token: ''
            };
        },
        methods: {
            getData() {
                //
                // console.log(this.$route.params.deviceUuid.uuid);
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http
                    .get(path + "admin/sweepe-show/", {
                        params: {
                            uuid: _this.$route.params.deviceUuid.uuid
                        }
                    })
                    .then(function (res) {
                        _this.tableData = res.data.data;
                    });
            },
            submit_edit() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                if (this.$route.params.deviceUuid) {
                    //编辑
                    this.$http
                        .post(path + "admin/sweeper/update", {
                            _token: _this.token,
                            uuid: _this.tableData.uuid,
                            title: _this.tableData.title,
                            device_uuid:_this.tableData.device_uuid
                        })
                        .then(function (res) {
                            _this.$message({
                                message: '修改成功！',
                                type: 'success'
                            });
                            setTimeout(() => {
                                _this.$router.push('/equipment');
                            }, 500);
                        });
                } else {
                    //添加
                    this.$http
                        .post(path + "admin/sweeper/save", {
                            _token: _this.token,
                            device_uuid: _this.tableData.device_uuid,
                            title: _this.tableData.title
                        })
                        .then(function (res) {
                            _this.$message({
                                message: '添加成功！',
                                type: 'success'
                            });
                            
                            setTimeout(() => {
                                _this.$router.push('/equipment');
                            }, 500);
                        });
                }

            },
            getToken() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http
                    .get(path + "admin/sweeper/create")
                    .then(function (res) {
                        _this.token = res.data;
                    });
            }
        },
        mounted: function () {
            this.getToken()
            if (this.$route.params.deviceUuid) {
                this.getData();
            } else {}
            this.input_sweeper_type = this.input_sweeper_type == "normal" ? "a" : "b";
        }
    };
</script>
<style>
    .el-table--border {
        overflow: hidden;
    }

    .smallImgBox {
        width: 80px;
    }

    .items_edit {
        float: left;
        width: 150px;
        text-align: right;
        line-height: 50px;
        height: 50px;
        font-size: 15px;
        margin-right: 40px;
    }

    .con_edit {
        float: left;
        width: 60%;
        text-align: center;
        line-height: 50px;
        height: 40px;
    }

    .box_item {
        width: 100%;
        height: 50px;
        margin-bottom: 10px;
    }

    .upload-demo {
        margin-left: 190px;
    }

    .img_show {
        width: 300px;
        height: 300px;
    }

    .box_item_show {
        height: 350px;
    }

    .submit_box {
        float: left;
        margin-left: 220px;
    }

    .box_item_img {
        margin-bottom: 50px;
    }

    body {
        font-family: "微软雅黑";
    }

    input[type="file"] {
        display: none;
    }
</style>