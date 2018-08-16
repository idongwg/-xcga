<template>
    <div style="width:100%">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>用户管理</el-breadcrumb-item>
            <el-breadcrumb-item>添加用户</el-breadcrumb-item>
        </el-breadcrumb>
        <div style="width:50%;height:50%;margin:0 auto;height:100%">
            <div style="float:left;width:100%;min-width:480px;margin-left:auto;margin-right:auto;height:100%">
                <div class="box_item">
                    <span class="items_edit">工号</span>
                    <el-input v-model="tableData.username" placeholder="请输入工号" class="con_edit"></el-input>
                </div>
                <div class="box_item">
                    <span class="items_edit">用户名</span>
                    <el-input v-model="tableData.realname" placeholder="请输入用户名" class="con_edit"></el-input>
                </div>
                <div class="box_item">
                    <span class="items_edit">密码</span>
                    <el-input type="password" v-model="tableData.password" placeholder="请输入密码：8-16位数字字母组合" :class="{iRed:isRed}" class="con_edit"
                        v-on:input="check_password"></el-input>
                </div>
                <div class="box_item">
                    <span class="items_edit">确认密码</span>
                    <el-input type="password" v-model="confirm.password" placeholder="请再次输入密码" :class="{iRed:isRed2||isDiff}" class="con_edit"
                        v-on:input="check_password_again"></el-input>
                </div>
                <div class="submit_box">
                    <el-button type="primary" @click="submitCreat">确定</el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: {
                    username: '',
                    realname: '',
                    team_uuid: '',
                    role_uuid: '',
                    password: '',
                    _token: ''
                },
                confirm: {
                    password: ''
                },
                isRed: true,
                isRed2: true,
                isDiff: true,
                input_sweeper_type: "",
            };
        },
        methods: {
            getData() {
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
            check_password() {
                let patt_password = new RegExp(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z_]{8,16}$/);
                this.isRed = patt_password.test(this.tableData.password) ? false : true;
            },
            check_password_again() {
                let patt_password = new RegExp(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z_]{8,16}$/);
                this.isRed2 = patt_password.test(this.tableData.password) ? false : true;
                if (this.confirm.password == this.tableData.password) {
                    this.isDiff = false;
                } else {
                    this.isDiff = true;
                }
            },
            submitCreat() {
                if (this.isRed || this.isRed2 || this.isDiff) {
                    this.$message.error('请检查输入的密码！');
                } else {
                    let _this = this;
                    let path = window.location.href.split("home#")[0];
                    this.$http
                        .post(path + "admin/users/save", {
                            _token: _this.tableData._token,
                            username: _this.tableData.username,
                            realname: _this.tableData.realname,
                            password:_this.tableData.password
                        })
                        .then(function (res) {
                            _this.$message({
                                message: '添加成功！',
                                type: 'success'
                            });
                            setTimeout(() => {
                                _this.$router.push('/userlist');
                            }, 500);
                        });
                }
            },
            getToken() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper/create")
                    .then(function (res) {
                        _this.tableData._token = res.data
                    });
            }
        },
        mounted: function () {
            this.getToken()
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
        margin: 0 auto;
        float: none;
        width: 230px;
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

    .iRed .el-input__inner {
        border-color: red
    }
</style>