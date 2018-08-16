<template>
    <div style="width:100%;position:relative;">
        <div></div>
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>搜索分析</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="imgBox" :class=" { hiddenBig: isHidden }" @click="hideBigPic">
            <div class="mask"></div>
            <div class="imgCon">
                <img class="imgC" v-bind:src="img_big">
            </div>
        </div>
        <div class="box_top_analysis">
            <div class="box_top_analysis_con">
                <el-date-picker v-model="value" type="datetimerange" :picker-options="pickerOptions" range-separator="至" start-placeholder="开始日期"
                    end-placeholder="结束日期" align="right" @change="chooseTime">
                </el-date-picker>
            </div>
            <div class="box_top_analysis_con">
                <div class="box_top_analysis_con_left">
                    <p class="word_search">录入车牌号：</p>
                </div>
                <div class="box_top_analysis_con_right">
                    <el-input placeholder="请输入内容" v-model="title" clearable>
                    </el-input>
                </div>
            </div>
            <!-- <div class="box_top_analysis_con">
                <div class="box_top_analysis_con_left">
                    <p class="word_search">设备号：</p>
                </div>
                <div class="box_top_analysis_con_right">
                    <el-input placeholder="请输入内容" v-model="input10" clearable>
                    </el-input>
                </div>
            </div> -->
            <div class="box_top_analysis_con">
                <div class="box_top_analysis_con_left">
                    <p class="word_search">地址：</p>
                </div>
                <div class="box_top_analysis_con_right">
                    <el-input placeholder="请输入内容" v-model="location" clearable>
                    </el-input>
                </div>
            </div>
            <div class="box_top_analysis_con">
                <div class="box_top_analysis_con_left">
                    <p class="word_search">驾驶车辆：</p>
                </div>
                <div class="box_top_analysis_con_right">
                    <el-input placeholder="请输入内容" v-model="sweepers_title" clearable>
                    </el-input>
                </div>
            </div>
            <div class="box_top_analysis_con analysis_submit">
                <div class="sub_box">
                    <el-button type="primary" @click="cancle">重置</el-button>
                    <el-button type="primary" @click="checkData">搜索</el-button>
                </div>
            </div>
        </div>
        <div class="box_bottom_analysis" ref="box_bottom_an">
            <el-table :data="tableData" style="width: 100%" highlight-current-row :height="heightTab">
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
                        <img v-bind:src="scope.row.image_url" class="smallImgBox" @click="showBigPic(scope.$index, scope.row)" />
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
                <!-- <el-table-column label="操作" width="180" align="center">
                    <template slot-scope="scope">
                        <el-button type="primary" size="mini" @click="view_data_all(scope.$index, scope.row)">查看</el-button>
                    </template>
                </el-table-column> -->
            </el-table>
        </div>
        <div class="bottom_search">
            <el-pagination @current-change="handleCurrentChange" :current-page.sync="currentPage" :page-size="per_page" layout="total,prev, pager, next, jumper"
                :total="total1">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                pickerOptions: {
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
                value: [],
                tableData: [],
                heightTab: 400,
                input10: "",
                sub_message: {},
                currentPage: 1,
                per_page: 0,
                total1: 0,
                sweepers_title: "",
                location: "",
                title: "",
                a: "",
                b: "",
                img_big: "",
                isHidden: true
            };
        },
        methods: {
            chooseTime() {},
            getSize() {
                this.heightTab = this.$refs.box_bottom_an.clientHeight;
            },
            cancle() {
                this.tableData = [];
                this.title = "";
                this.location = "";
                this.sweepers_title = "";
                this.value = [];
            },
            checkData() {
                this.getData();
            },
            handleCurrentChange() {
                this.getData();
            },
            getData() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                if (!this.value[0]) {
                    this.a = "";
                } else {
                    this.a = Math.floor(this.value[0] / 1000);
                }
                if (!this.value[1]) {
                    this.b = "";
                } else {
                    this.b = Math.floor(this.value[1] / 1000);
                }
                this.$http
                    .get(path + "admin/license-vague/", {
                        params: {
                            location: _this.location,
                            sweepers_title: _this.sweepers_title,
                            title: _this.title,
                            start_time: _this.a,
                            end_time: _this.b,
                            page: _this.currentPage
                        }
                    })
                    .then(function (res) {
                        console.log(res);
                        _this.total1 = res.data.data.total;
                        _this.tableData = res.data.data.data;
                        _this.per_page = res.data.data.per_page;
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
            this.getSize();
        }
    };
</script>
<style>
    .box_top_analysis {
        width: 100%;
        /* height: 40%; */
        height: 26%;
        float: left;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 20px;
    }

    .box_bottom_analysis {
        width: 100%;
        height: 56.5%;
        float: left;
        margin-bottom: 10px;
    }

    .box_top_analysis .el-range-editor.el-input__inner {
        float: none;
        margin-bottom: 0;
        margin-right: 0;
        position: absolute;
        left: 50%;
        margin-left: -200px;
        top: 50%;
        margin-top: -20px;
    }

    .box_top_analysis_con {
        width: 25%;
        height: 30%;
        min-width: 403px;
        position: relative;
    }

    .box_top_analysis_con_left {
        width: 124px;
        /* min-width: 170px; */
        height: 100%;
        float: left;
        min-width: 10%;
    }

    .box_top_analysis_con_right {
        width: 250px;
        height: 100%;
        float: left;
        position: relative;
    }

    .word_search {
        width: 100%;
        height: 100%;
        line-height: 56px;
        font-size: 16px;
        text-align: right;
    }

    .box_top_analysis_con_right .el-input {
        width: 250px;
        position: absolute;
        top: 50%;
        margin-top: -23px;
    }

    .analysis_submit .el-button {
        /* margin-top: 25px; */
        margin-left: 10px;
    }

    .sub_box {
        width: 250px;
        margin: 0 auto;
    }

    .bottom_search {
        width: 100%;
        height: 10%;
        float: left;
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
        height: 100%;
    }

    .hiddenBig {
        display: none;
    }

    /* .el-popper[x-placement^=bottom] {
        left: 122px !important;
    } */
</style>