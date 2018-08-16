<template>
    <div style="width:100%">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>车辆管理</el-breadcrumb-item>
        </el-breadcrumb>
        <!-- <img src="http://i-3.qqxzb.com/2017/10/19/bd154a0d-0070-45cc-a3ec-206d65e3ce61.jpg?width=580&height=580" style="display:none"> -->
        <!-- <img v-bind:src="./" ref="imgS" style="width:100%;height:100%;"/> -->
        <el-button type="primary" size="mini" style="float:right;margin-right:20px;margin-bottom:20px" @click="addCar">添加车辆</el-button>
        <el-table :data="tableData" style="width: 100%;" highlight-current-row :default-sort="{prop: 'date', order: 'descending'}">
            <!-- <el-table-column type="selection" width="55" align="center">
            </el-table-column> -->
            <!-- checkbox -->
            <!-- <el-table-column label="日期" width="180" align="center">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span style="margin-left: 10px">{{ scope.row.date }}</span>
                </template>
            </el-table-column> -->
            <el-table-column label="车牌号" width="300" align="center">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.title }}</span>
                    <!-- <el-popover trigger="hover" placement="top">
                        <p>姓名: {{ scope.row.name }}</p>
                        <p>住址: {{ scope.row.address }}</p>
                        <div slot="reference" class="name-wrapper">
                            <el-tag size="medium">{{ scope.row.name }}</el-tag>
                        </div>
                    </el-popover> -->
                </template>
            </el-table-column>
            <el-table-column label="设备编号" width="300" align="center">
                <template slot-scope="scope">
                    <!-- <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button> -->
                    <span style="margin-left: 10px">{{ scope.row.device_uuid }}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作" align="center">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="viewInfoList(scope.$index, scope.row)">查看</el-button>
                    <el-button type="primary" size="mini" @click="editDeviceInfo(scope.$index, scope.row)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="deleteEquipment(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>

            <!-- <el-table-column label="img" align="center">
                <template slot-scope="scope">
                    <img v-bind:src="scope.row.image_url" ref="imgS" />
                    图片放在public img 中，编译之后路径才正确
                    <img src="http://i-3.qqxzb.com/2017/10/19/bd154a0d-0070-45cc-a3ec-206d65e3ce61.jpg?width=580&height=580" alt="">
                    引入网图
                </template>
            </el-table-column> -->
        </el-table>
        <div class="block">
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page.sync="currentPage" :page-size="10"
                layout="total,prev, pager, next, jumper" :total="total1">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                currentPage: 1,
                total1: 0
            };
        },
        methods: {
            handleEdit(index, row) {
            },
            handleDelete(index, row) {
            },
            viewInfoList(index, row) {
                this.$router.push({
                    name: 'datalist_equipment',
                    params: {
                        deviceUuid: row
                    }
                });
            },
            editDeviceInfo(index, row) {
                // console.log(index,row);
                this.$router.push({
                    name: 'editDeviceInfo',
                    params: {
                        deviceUuid: row
                    }
                });
            },
            getData() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper", {
                    params: {
                        page: _this.currentPage
                    }
                }).then(function (res) {
                    _this.tableData = res.data.data.data;
                    _this.total1 = res.data.data.total

                });
            },
            handleSizeChange(val) {
            },
            handleCurrentChange(val) {
                this.currentPage = val
                this.getData()
            },
            deleteEquipment(index, row) {

                this.$confirm('此操作将删除该车辆, 是否继续?', '警告', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.deletedEquipmentFun(row)
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
            deletedEquipmentFun(row) {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper/delete", {
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
            addCar() {
                this.$router.push({
                    name: 'editDeviceInfo'
                });
            }
        },
        mounted: function () {
            this.getData();
        }
    };
</script>
<style>
    .el-table--border {
        overflow: hidden;
    }
    .el-pager li.active {
    	background: rgb(204, 207, 210) !important;
    }

    body {
        font-family: "微软雅黑"
    }
</style>