<template>
    <el-container>
        <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
            <el-menu :default-active='activeTab'>
                <el-menu-item index="/" @click="router0">
                    <i class="el-icon-menu">首页</i>
                </el-menu-item>
                <el-menu-item index="/Equipment" @click="router1">
                    <i class="el-icon-tickets">车辆管理</i>
                </el-menu-item>
                <el-menu-item index="/datalist" @click="router2">
                    <i class="el-icon-tickets">数据列表</i>
                </el-menu-item>
                <el-menu-item index="/analysis" @click="router4">
                    <i class="el-icon-search">搜索分析</i>
                </el-menu-item>
                <el-menu-item index="/userlist" @click="router3">
                    <i class="el-icon-setting">用户管理</i>
                </el-menu-item>
                <el-menu-item index="/version" @click="router5">
                    <i class="el-icon-upload">版本控制</i>
                </el-menu-item>


            </el-menu>
        </el-aside>

        <el-container style="padding:20px">
            <!-- {{$router.options.routes}}
            <br/>
            <br>
            <br>-->
            <!-- {{activeTab}} -->
            <router-view></router-view>


        </el-container>
    </el-container>
</template>

<style>
    .el-header {
        background-color: #b3c0d1;
        color: #333;
        line-height: 60px;
    }

    .el-aside {
        color: #333;
        min-height: 870px;
        background: #364150 !important;
    }

    .el-container {
        overflow: hidden;
    }

    .el-menu-item [class^=el-icon-] {
        font-size: 14px !important;
    }

    .el-icon-message:before {
        margin-right: 14px;
    }

    .el-icon-tickets:before {
        margin-right: 14px;
    }

    .el-icon-more:before {
        margin-right: 14px;
    }

    .el-icon-search:before {
        margin-right: 14px;
    }

    .el-icon-setting:before {
        margin-right: 14px;
    }

    .el-icon-upload:before {
        margin-right: 14px;
    }

    .el-icon-menu:before {
        margin-right: 14px;
    }

    .el-menu-item.is-active {
        color: #409eff;
        background: #e4e8ec;
    }

    body {
        font-family: "微软雅黑"
    }

    .el-menu-item {
        background: #364150;
    }

    .el-menu-item i {
        color: #b4bcc8;
        font-weight: bolder
    }

    .el-menu-item:focus,
    .el-menu-item:hover {
        background: #2C3542;
    }

    .el-icon-message {
        color: #fff;
    }

    .el-menu-item.is-active {
        background: #3E4B5C;
        color: #f1f1f1;
    }
</style>

<script>
    export default {
        data() {
            const item = {
                date: "2016-05-02",
                name: "王小虎",
                address: "上海市普陀区金沙江路 1518 弄"
            };
            return {
                tableData: Array(20).fill(item),
                activeTab: "",
                isHidden: true
            };
        },
        methods: {
            router0() {
                this.$router.push("/");
            },
            router1() {
                this.$router.push("/equipment");
            },
            router2() {
                this.$router.push("/datalist");
            },
            router3() {
                this.$router.push("/userlist");
            },
            router4() {
                this.$router.push("/analysis");
            },
            router5() {
                this.$router.push("/version");
            }

        },
        mounted: function () {
            this.activeTab = this.$route.path == "/" ? "/equipment" : this.$route.path;
            // console.log(this.activeTab);
        }
    };
</script>