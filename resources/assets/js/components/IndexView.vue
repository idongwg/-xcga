<template>
    <div style="width:100%;height:100%;">
        <div class="index_top">
            <ul>
                <li>
                    <div class="index_top_box">
                        <span>车辆总数：</span>
                        <span>{{a}}</span>
                    </div>
                </li>
                <li>
                    <div class="index_top_box">
                        <span>当前工作车辆数：</span>
                        <span>{{b}}</span>
                    </div>
                </li>
                <li @click="tiao" class="index_skip">
                    <div class="index_top_box">
                        <span>获取车牌号总数：</span>
                        <span>{{c}}</span>
                    </div>
                </li>
                <li @click="tiao2" class="index_skip">
                    <div class="index_top_box">
                        <span>今日获取数车牌号数：</span>
                        <span>{{d}}</span>
                    </div>
                </li>
            </ul>
        </div>
        <!-- <div><span>车辆总数：</span><span>{{a}}</span></div>
        <div><span>今日工作车辆数：</span><span>{{b}}</span></div>
        <div><span>今日获取数据数：</span><span>{{c}}</span></div> -->
    </div>

</template>

<script>
    export default {
        data() {
            return {
                a: 0,
                b: 0,
                c: 0,
                d: 0,
            };
        },
        methods: {
            getData() {
                let _this = this;
                let path = window.location.href.split("home#")[0];
                this.$http.get(path + "admin/sweeper-status").then(function (res) {
                    _this.a = res.data.sweeper_count
                    _this.b = res.data.sweeper_onstart
                    _this.c = res.data.license_count
                    _this.d = res.data.license_day
                });
            },
            tiao() {
				this.$router.push('/datalist_all');
            },
        	tiao2() {
				this.$router.push('/datalist_one');
           }
        },
        mounted: function () {
            this.getData();
        }
    };
</script>
<style>
    .index_top {
        width: 100%;
        height: 200px;
    }

    .index_top ul,
    li {
        margin: 0;
        list-style: none;
    }

    .index_top li {
        float: left;
        margin-left: 50px;
        line-height: 100px;
        background: #42aaf3;
        border-radius: 10px;
        text-align: center;
        color: #fff;
        font-size: 16px;
        overflow: hidden;
        width: 20%;
    }

    .index_top .index_top_box {
        width: 100%;
        height: 100px;
        background: url(../img/dizhi.png) no-repeat left bottom;
        background-size: 100px 100px;
        background-position: -50px 50px;
    }
    #apps {
        margin-top: -22px;
    }
    .index_skip{
        cursor: pointer;
    }
    .index_skip :hover{
        background-color: #1b6294
    }
</style>