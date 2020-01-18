untuk upload gambar di ckeditor menggunakan fileman

// ini setting di textarea ckeditor nya
var roxyFileman = 'ckeditor/plugins/fileman/index.html';
    $(function () {
        CKEDITOR.replace('editor-soal-id', {filebrowserBrowseUrl: roxyFileman,
            filebrowserImageBrowseUrl: roxyFileman + '?type=image',
            removeDialogTabs: 'link:upload;image:upload'});
    });

// ini setting di fileman nya
//conf.json
"FILES_ROOT":          "/guru/images/",
"RETURN_URL_PREFIX":   "",
"SESSION_PATH_KEY":    "filemanpath",
"THUMBS_VIEW_WIDTH":   "140",
"THUMBS_VIEW_HEIGHT":  "120",
"PREVIEW_THUMB_WIDTH": "100",
"PREVIEW_THUMB_HEIGHT":"100",
"MAX_IMAGE_WIDTH":     "1000",
"MAX_IMAGE_HEIGHT":    "1000",
"INTEGRATION":         "ckeditor",