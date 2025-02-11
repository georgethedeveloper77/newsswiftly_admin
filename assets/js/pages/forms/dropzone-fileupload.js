
$(function () {
    //Dropzone
    Dropzone.options.myDropzone = {
        paramName: "file",
        maxFilesize: 1,
        maxFiles:1,
        acceptedFiles:'.csv',
        addRemoveLinks: "true",
        accept: function(file, done) {
           alert('hello'); 
       }
    };
});
