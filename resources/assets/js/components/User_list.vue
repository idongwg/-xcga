<template>

    <div style="width:100%;">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>用户管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-button type="primary" icon="el-icon-circle-plus" class="add_user" @click="add_userF">添加新用户</el-button>
        <el-table :data="tableData" style="width: 100%">
            <el-table-column prop="username" label="工号" width="350" align='center'>

            </el-table-column>
            <el-table-column prop="realname" label="姓名" width="350" align='center'>
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.realname }}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作" align='center'>
                <template slot-scope="scope">
                    <!-- <el-button type="primary" size="mini" @click="edit(scope.row)">编辑</el-button> -->
                    <el-button type="primary" size="mini" @click="deleted(scope.row)">删除</el-button>
                    <el-popover ref="popover4" placement="right" width="400" trigger="click">
                        <el-form :model="ruleForm2" status-icon :rules="rules2" ref="ruleForm2" label-width="100px" class="demo-ruleForm">
                            <el-form-item label="密码" prop="pass">
                                <el-input type="password" v-model="ruleForm2.pass" auto-complete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="确认密码" prop="checkPass">
                                <el-input type="password" v-model="ruleForm2.checkPass" auto-complete="off"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="submitForm('ruleForm2')">提交</el-button>
                                <el-button @click="resetForm('ruleForm2')">重置</el-button>
                            </el-form-item>
                        </el-form>
                    </el-popover>
                    <el-button v-popover:popover4 type="danger" size="mini" @click="edit(scope.row)">修改密码</el-button>
                </template>

            </el-table-column>
        </el-table>
        <el-pagination @current-change="handleCurrentChange2" :current-page.sync="currentPage1" :page-size="10" layout="total,prev, pager, next, jumper"
            :total="total1">
        </el-pagination>
    </div>
</template>
<script>
    export default {
        data() {
            var validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入密码'));
                } else {
                    if (!new RegExp(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z_]{8,16}$/).test(value)) {
                        callback(new Error('请输入密码:8-16位数字字母组合'));
                    }
                    callback();
                }
            };
            var validatePass2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请再次输入密码'));
                } else if (value !== this.ruleForm2.pass) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
                tableData: [],
                total1: 0,
                currentPage1: 1,
                ruleForm2: {
                    pass: '',
                    checkPass: '',
                },
                rules2: {
                    pass: [{
                        validator: validatePass,
                        trigger: 'blur'
                    }],
                    checkPass: [{
                        validator: validatePass2,
                        trigger: 'blur'
                    }],
                },
                token: '',
                uuid:''
            }
        },
        methods: {
            add_userF() {
                this.$router.push('/addUserList');
            },
            getData() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/users", {
                    params: {

                    }
                }).then(function (res) {
                    _this.total1 = res.data.data.total
                    _this.tableData = res.data.data.data
                });
            },
            edit(row) {
                this.uuid = row.uuid
            },
            deleted(row) {
                this.$confirm('此操作将删除该用户, 是否继续?', '警告', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.deletedFun(row)
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });

            },
            deletedFun(row) {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/users/delete", {
                    params: {
                        uuid: row.uuid
                    }
                }).then(function (res) {
                    _this.getData()
                }).then(function () {
                    _this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                });
            },
            handleCurrentChange2() {
                this.getData()
            },
            getToken() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper/create")
                    .then(function (res) {
                        _this.token = res.data
                    });
            },
            submitForm() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http
                    .post(path + "admin/users/updatepassword", {
                        _token: _this.token,
                        uuid: _this.uuid,
                        password:_this.ruleForm2.pass
                    })
                    .then(function (res) {
                        _this.$message({
                            message: '修改成功！',
                            type: 'success'
                        });
                        setTimeout(() => {
                            window.location.reload()
                        }, 500);
                    });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        },
        mounted: function () {
            this.getData();
            this.getToken();
        }
    }
</script>
<style>
    .add_user {
        float: right;
        margin-right: 100px;
        margin-bottom: 20px;
    }

    .el-popper {
        box-shadow: 0px 0px 50px 0px;
        padding-right: 50px;
        padding-top: 30px;
    }
</style>