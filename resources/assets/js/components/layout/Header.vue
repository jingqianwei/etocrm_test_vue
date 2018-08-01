<template>
    <div class="header">
        <img src="" />
        <el-menu :default-active="this.$route.name" class="el-menu-demo" mode="horizontal" :router=true >
            <el-menu-item index="handle">
                处理中心
            </el-menu-item>
            <el-menu-item index="security">
                安全中心
            </el-menu-item>
            <el-menu-item index="operation">
                操作中心
            </el-menu-item>
            <el-menu-item index="new">
                信息中心
            </el-menu-item>
        </el-menu>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>