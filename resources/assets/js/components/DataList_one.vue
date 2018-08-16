<template>
    <div style="width:100%;position:relative">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>数据列表</el-breadcrumb-item>
        </el-breadcrumb>
        <!-- <div class="search_page">
            <el-button type="primary" @click="show_search_box">精确搜索</el-button>
        </div>
        <div class="search_box" :class="{ hidden: isHidden }">

            <el-button type="primary" @click="search_submit" class="search_confirm">确认</el-button>
        </div> -->



        <!-- <el-date-picker v-model="value4" type="datetimerange" :picker-options="pickerOptions2" range-separator="至" start-placeholder="开始日期"
            end-placeholder="结束日期" align="right" @change="chooseTime">
        </el-date-picker> -->
        <div class="imgBox" :class=" { hiddenBig: isHidden }" @click="hideBigPic">
            <div class="mask"></div>
            <div class="imgCon">
                <img class="imgC" v-bind:src="img_big">
            </div>
        </div>

        <el-date-picker v-model="value1" type="date" placeholder="选择日期" @change='chooseDate'>
        </el-date-picker>

        <el-table :data="tableData" style="width: 100%;" highlight-current-row>
            <el-table-column label="车牌号" width="180" align="center">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.title }}</span>
                </template>
            </el-table-column>
            
            <el-table-column label="驾驶车辆" align="center">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.sweepers_title }}</span>
                </template>
            </el-table-column>
            
            <el-table-column label="拍摄地点" align="center">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.location }}</span>
                </template>
            </el-table-column>
            
            <el-table-column label="图片" align="center">
                <template slot-scope="scope">
                    <img v-bind:src="scope.row.image_url" class="smallImgBox" @click="showBigPic(scope.$index, scope.row)"/>
                    <!-- 图片放在public img 中，编译之后路径才正确 -->
                    <!-- <img src="http://i-3.qqxzb.com/2017/10/19/bd154a0d-0070-45cc-a3ec-206d65e3ce61.jpg?width=580&height=580" alt=""> -->
                    <!-- 引入网图 -->
                </template>
            </el-table-column>
            
            <el-table-column label="时间" width="180" align="center">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>
            
            <el-table-column label="操作" width="180" align="center">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="view_data_all(scope.$index, scope.row)">查看</el-button>
                </template>
            </el-table-column>
        </el-table>
        
        <div class="block">
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page.sync="currentPage" :page-size="5"
                layout="total,prev, pager, next, jumper" :total="total1" class="a">
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
                page: 0,
                page2: 0,
                total1: 0,
                isHidden: true,
                pickerOptions2: {
                    shortcuts: [{
                            text: "最近一周",
                            onClick(picker) {
                                const end = new Date();
                                const start = new Date();
                                start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                                picker.$emit("pick", [start, end]);
                            }
                        },
                        {
                            text: "最近一个月",
                            onClick(picker) {
                                const end = new Date();
                                const start = new Date();
                                start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                                picker.$emit("pick", [start, end]);
                            }
                        },
                        {
                            text: "最近三个月",
                            onClick(picker) {
                                const end = new Date();
                                const start = new Date();
                                start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                                picker.$emit("pick", [start, end]);
                            }
                        }
                    ]
                },
                value4: [this.setDefaultTime(), new Date()],
                value1: new Date().getTime(),
                img_big: '',
                isHidden: true,
            };
        },
        methods: {
            handleEdit(index, row) {},
            handleDelete(index, row) {},
            handleSizeChange(val) {},
            handleCurrentChange(val) {
                this.currentPage = val;
                this.getData_date();
            },
            setDefaultTime() {
                let date = new Date();
                date.setDate(date.getDate());
                date.setHours(0);
                date.setMinutes(0);
                date.setSeconds(0);
                return date;
            },
            getData() {
                // console.log(this.setTime())
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http
                    .get(path + "admin/license-plates", {
                        params: {
                            page: _this.currentPage,
                            start_time: _this.value4[0].getTime() / 1000,
                            end_time: _this.value4[1].getTime() / 1000,
                            statistics: 1
                        }
                    })
                    .then(function (res) {
                        // console.log(res.data.data)
                        _this.page = res.data.data.last_page * res.data.data.per_page;
                        // _this.allpage = String(res.data.data.data.length)
                        _this.tableData = res.data.data.data;
                    });
            },
            getData_date() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http
                    .get(path + "admin/license-plates", {
                        params: {
                            page: _this.currentPage,
                            statistics: 1
                        }
                    })
                    .then(function (res) {
                        _this.total1 = res.data.data.total;
                        _this.tableData = res.data.data.data;
                    });
            },
            chooseTime() {
                setTimeout(() => {
                    this.getData();
                });
            },
            chooseDate() {
                setTimeout(() => {
                    this.getData_date();
                });
            },
            search_submit() {
                this.isHidden = !this.isHidden;
            },
            show_search_box() {
                this.isHidden = !this.isHidden;
            },
            view_data_all(index, row) {
                this.$router.push({
                    name: "viewAllData",
                    params: {
                        deviceUuid: row
                    }
                });
            },
            showBigPic(index, row) {
                // console.log(row.image_url)
                this.img_big = row.image_url;
                this.isHidden = false;
            },
            hideBigPic() {
                this.isHidden = true;
            }
        },
        mounted: function () {
            // this.setDefaultTime();
            this.getData();
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

    body {
        font-family: "微软雅黑";
    }

    .el-pagination {
        color: #303133;
    }

    .el-pager li.active {
        color: #fff !important;
        background: rgb(1, 15, 124);
    }

    .el-pager li:hover {
        color: rgb(1, 15, 124);
    }

    .el-range-editor.el-input__inner {
        float: right;
        margin-right: 50px;
        margin-bottom: 20px;
    }
    /* .el-table__body-wrapper{
        margin-bottom: 20px;
    } */

    .el-pagination {
        float: right;
    }

    .el-table--fit {
        margin-bottom: 30px;
    }

    .smallImgBox {
        height: 80px;
    }

    .search_page {
        float: left;
        margin-left: 5px;
    }

    .search_box {
        width: 100%;
        height: 100%;
        position: absolute;
        background: #000;
        opacity: 0.7;
        z-index: 5;
    }

    .hidden {
        display: none;
    }

    .search_confirm {
        position: absolute;
        right: 100px;
        bottom: 100px;
    }

    .el-date-editor.el-input,
    .el-date-editor.el-input__inner {
        float: right;
        margin-right: 20px;
        margin-bottom: 20px;
    }

    .imgBox {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 20px;
        z-index: 5;
    }

    .mask {
        position: absolute;
        left: 0;
        top: 0;
        z-index: -1;
        background: #000;
        opacity: 0.5;
        width: 100%;
        height: 100%;
    }

    .imgCon {
        z-index: 7;
        text-align: center;
        height: 100%;
    }

    .imgC {
        height: 100%
    }

    .hiddenBig {
        display: none;
    }
</style>