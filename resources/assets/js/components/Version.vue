<template>
    <div style="width:100%;height:100%">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>版本控制</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="btnn">
            <el-button type="primary" size="medium" @click="addVersions">
                <i class="el-icon-circle-plus">添加版本</i>
            </el-button>
        </div>
        <el-table :data="tableData" style="width: 100%">
            <el-table-column prop="version_name" label="版本名称" width="200" align="center">
            </el-table-column>
            <el-table-column prop="version_code" label="版本号" width="200" align="center">
            </el-table-column>
            <el-table-column prop="upgrade_url" label="下载地址" align="center" width="250">
            </el-table-column>
            <el-table-column label="操作" align="center">

                <template slot-scope="scope">
                    <!--<el-button type="info" size="mini">
                        <i class="el-icon-warning">暂停发布</i>
                    </el-button>-->
                    <el-button type="warning" size="mini" @click="editVersions(scope.row)">
                        <i class="el-icon-edit">编辑</i>
                    </el-button>
                    <el-button type="danger" size="mini" @click="delectVersionBtn(scope.row)">
                        <i class="el-icon-remove">删除</i>
                    </el-button>
                </template>

            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                _token: '',
            };
        },
        methods: {
            getData() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/app-version").then(function (res) {
                    _this.tableData = res.data.data;
                });
            },
            addVersions() {
                this.$router.push({
                    name: "addVersion"
                });
            },
            editVersions(row) {
                this.$router.push({
                    name: "editVersion",
                    params: {
                        key: row
                    }
                });
            },
            delectFun(row) {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/version/delete", {
                    params: {
                        uuid: row.uuid,
                    }
                }).then(function (res) {
                    if (res.data.message == '成功') {
                        _this.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                        setTimeout(() => {
                            _this.getData();
                        }, 500);
                    }
                });
            },
            delectVersionBtn(row) {
                this.$confirm('此操作将删除该版本, 是否继续?', '警告', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.delectFun(row);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            getToken() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper/create").then(function (res) {
                    _this.token = res.data
                });
            },
            editVersion(row) {
                this.$router.push({
                    name: "addVersion"
                });
            }
        },
        mounted: function () {
            this.getData();
            this.getToken();
        }
    };
</script>
<style>
    .el-icon-warning:before {
        margin-right: 5px;
    }

    .el-icon-edit:before {
        margin-right: 5px;
    }

    .el-icon-remove:before {
        margin-right: 5px;
    }

    .el-icon-circle-plus:before {
        margin-right: 5px;
    }

    .btnn {
        float: right;
        margin-right: 30px;
        margin-bottom: 20px;
    }
</style>