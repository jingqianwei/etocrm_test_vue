<template>
    <div>
        <h1>home</h1>
        <router-view></router-view>
    </div>
</template>

<script>
    export default{
        created(){
          console.log('router:',this.$router, 'route:',this.$route)
        }
    }
</script>