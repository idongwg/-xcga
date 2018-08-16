<template>
    <div style="width:100%;height:100%">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>版本控制</el-breadcrumb-item>
            <el-breadcrumb-item>添加版本</el-breadcrumb-item>
        </el-breadcrumb>
        <div style="width:50%;height:100%;margin:0 auto">
            <el-form label-position="right" label-width="80px">
                <el-form-item label="版本名称">
                    <el-input v-model="version_name"></el-input>
                </el-form-item>
                <el-form-item label="版本编号">
                    <el-input v-model="version_code"></el-input>
                </el-form-item>
                <el-form-item label="下载地址">
                    <el-input placeholder="请输入内容" v-model="upgrade_url">
                        <template slot="prepend">Http://</template>
                    </el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input type="textarea" v-model="description" :rows="20"></el-input>
                </el-form-item>
                <el-form-item align="center">
                    <el-button type="primary" @click="onSubmit">立即创建</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                version_name: '',
                version_code: '',
                upgrade_url: '',
                description: '',
                token: ''
            };
        },
        methods: {
            getToken() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper/create").then(function (res) {
                    _this.token = res.data
                });
            },
            onSubmit() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.post(path + "admin/version/save", {
                    _token: _this.token,
                    version_name: _this.version_name,
                    version_code: _this.version_code,
                    description: _this.description,
                    upgrade_url: 'http://' + _this.upgrade_url
                }).then(function (res) {
                    if (res.data.message == '成功') {
                        _this.$message({
                            type: 'success',
                            message: '创建成功!'
                        });
                        setTimeout(() => {
                            _this.$router.push({
                                name: "version"
                            });
                        }, 500);
                    } else {
                        _this.$message({
                            type: 'error',
                            message: '创建失败!'
                        });
                    }

                });
            }
        },
        mounted: function () {
            this.getToken();
        }
    };
</script>