<template>
    <div>
        <h2>Home component {{ name }} </h2>
    </div>
</template>
<script type="text/javascript">
export default {
    mounted(){
        console.log("home Component called..");
    },
    data(){
        return{
            name : "vijay"
        }
    }
}
</script>
<style type="text/css" scoped>
    h2 {
        color: green;
    }
</style>