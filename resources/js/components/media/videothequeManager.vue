<template>
    <div class="px-4 h-100" style="overflow-y: auto;">
      <common-header :title="'VIDEOTHEQUE'"/>
      <div class="row">
        <div class="col-3">
          <div class="card" style="width: 18rem;">
            <video controls>
                <source src="videos/video1.mp4" type="video/mp4">
                Your browser does not support the video tags.
            </video>
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Some quick example text to build on the card title and card content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import CommonHeader from './CommonHeader.vue';
  export default {
    components:{
      CommonHeader
    }
  }
  </script>
  
  <style>
  .card-zone{
    border: solid 1px gray;
    box-shadow: 0px 0px 2px 0px grey;
    border-radius: 2px;
    margin: 4px;
  }
  </style>