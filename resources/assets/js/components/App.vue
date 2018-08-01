<template>
    <div class="app-main">
        <el-container>
            <el-header>
                <router-view name="header"></router-view>
            </el-header>
            <el-container>
                <el-aside width="200px">
                    <router-view name="aside"></router-view>
                </el-aside>
                <el-main>
                    <router-view name="main"></router-view>
                </el-main>
            </el-container>
            <el-footer>
                <router-view name="footer"></router-view>
            </el-footer>
        </el-container>
    </div>
</template>

<script>
    export default {
        created(){
            console.log('router:',this.$router, 'route:',this.$route)
        }
    }
</script>