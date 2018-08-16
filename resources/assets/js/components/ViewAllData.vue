<template>
    <div style="width:100%">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="margin-bottom:20px;">
            <el-breadcrumb-item>首页</el-breadcrumb-item>
            <el-breadcrumb-item>数据列表</el-breadcrumb-item>
            <el-breadcrumb-item>查看数据</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="boxInfo">
            <div class="info_left">
                <p class="info_word">
                    <span class="title_">拍摄车辆：</span>
                    <span class="word_">{{tableData.sweepers_title}}</span>
                </p>
                <p class="info_word">
                    <span class="title_">拍摄时间：</span>
                    <span class="word_">{{tableData.created_at}}</span>
                </p>
                <p class="info_word">
                    <span class="title_">拍摄地点：</span>
                    <span class="word_">{{tableData.location}}</span>
                </p>
                <p class="info_word">
                    <span class="title_">录入车牌：</span>
                    <span class="word_">{{tableData.title}}</span>
                </p>
            </div>
            <div class="info_right">
                <img :src="tableData.image_url" alt="">
            </div>
        </div>
        <div class="boxMap">
            <baidu-map class="map" :center="center" :zoom="12" :scroll-wheel-zoom="true" @ready="getSimpleData">
                <bm-marker :position="pointZ" :dragging="true" animation="BMAP_ANIMATION_BOUNCE">
                </bm-marker>
            </baidu-map>
        </div>
    </div>
</template>

<script>
    import {
        BaiduMap
    } from 'vue-baidu-map'
    export default {
        components: {
            BaiduMap
        },
        data() {
            return {
                center: {
                    lng: 116.404,
                    lat: 39.915
                },
                zoom: 3,
                pointZ: {
                    lng: null,
                    lat: null
                },
                tableData: {
                    image_url: ''
                },
            };
        },
        methods: {
            getSimpleData() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/license-show", {
                    params: {
                        id: _this.$route.params.deviceUuid.id
                    }
                }).then(function (res) {
                    _this.tableData = res.data.data
                    _this.pointZ.lng = res.data.data.longitude
                    _this.pointZ.lat = res.data.data.latitude
                    // _this.center.lng = res.data.data.longitude
                    // _this.center.lat = res.data.data.latitude
                    // _this.pointZ.lng = res.data.data.longitude
                    // _this.pointZ.lat = res.data.data.latitude
                });
            },
        },
        beforeCreate: function () {

        }
    };
</script>
<style>
    .boxInfo {
        width: 100%;
        height: 50%;
    }

    .boxMap {
        width: 100%;
        height: 50%;
        padding: 10px;
    }

    .map {
        height: 100%;
    }

    .info_left {
        width: 40%;
        float: left;
        padding: 10px;
        font-size: 20px;
        line-height: 30%;
    }

    .info_right {
        width: 60%;
        height: 100%;
        float: left;
        padding: 10px;
    }

    .info_word {
        margin-bottom: 50px
    }

    .info_right img {
        width: 100%;
        height: 100%;
    }

    .title_ {}

    .word_ {}
</style>