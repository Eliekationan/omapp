<template>
  <div class="h-100">
    <header-component style="position: sticky; top: 0;"></header-component>
    <workspace-component></workspace-component>
    <!-- <example-component></example-component> -->
    <widget-container-modal />
  </div>
</template>

<script>
import {container} from "jenesius-vue-modal";
export default {
  components:{
    WidgetContainerModal: container
  }
}
</script>

<style>

</style>