<template>
    <div>
      <PDFViewer
        :source="link"
        style="height: 100vh; width: 100vw"
        @download="handleDownload"
      />
    </div>
  </template>
  
  <script>
  import PDFViewer from 'pdf-viewer-vue'
  
  export default {
    props:{
        link: String
    },
    components: {
      PDFViewer,
    },
  
    data() {
      return {
        url: '<PDF_URL>',
        base64: '<BASE64_ENCODED_PDF>',
      }
    },
  }
  </script>