
<template>

  <div>
    hi
  </div>
</template>

<script>
    export default {
        props:['login_route','register_route'],
        data(){
            return{
                errors  :   null
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
