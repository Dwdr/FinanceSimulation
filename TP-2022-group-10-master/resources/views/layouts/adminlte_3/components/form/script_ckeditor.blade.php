<?php
if(!isset($id)){
  $id = 'contents';
}
?>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.15.1/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('{{$id}}', {
        filebrowserUploadUrl: "{{route('cs.ckeditor.upload', ['_token' => csrf_token(),'type'=> 'message' ])}}",
        filebrowserUploadMethod: 'form',
        language: 'en',
        height: '23em',
        extraPlugins: 'colorbutton,colordialog,emoji,undo,embed,autoembed',
        removePlugins: 'sourcearea',
        contentsCss: [
            'http://cdn.ckeditor.com/4.15.1/full-all/contents.css',
        ],
        // Setup content provider. See https://ckeditor.com/docs/ckeditor4/latest/features/media_embed
        embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
    });
</script>