function delete_item(e){
  var id = e.target.getAttribute('data-id');
  var type = e.target.getAttribute('data-type');
  var msg = '';
  var url = '';

  switch(type){
    case 'admin':
       var msg = 'You want to delete this Admin User';
       url = baseURL+'deleteAdmin/'+id;
    break;
    case 'interest':
       var msg = 'You want to delete this Interest';
       url = baseURL+'deleteInterest/'+id;
    break;
    case 'reports':
       var msg = 'You want to delete this reported comment';
       url = baseURL+'deleteReport/'+id;
    break;
    case 'rss_link':
       var msg = 'You want to delete this Rss Link';
       url = baseURL+'deleteRssLink/'+id;
    break;
    case 'livestream':
       var msg = 'You want to delete this livestream';
       url = baseURL+'deleteLivestream/'+id;
    break;
    case 'youtube_link':
       var msg = 'You want to delete this Youtube Rss Link';
       url = baseURL+'deleteYoutubeRssLink/'+id;
    break;
    case 'radio':
       var msg = 'You want to delete this Radio Channel';
       url = baseURL+'deleteRadioLink/'+id;
    break;
    case 'rss_feed':
       var msg = 'You want to delete this Rss Feed';
       url = baseURL+'deleteRssFeed/'+id;
    break;
    case 'youtube_feed':
       var msg = 'You want to delete this Youtube Feed';
       url = baseURL+'deleteYoutubeFeed/'+id;
    break;

  }
   swal({
     title: 'Are you sure?',
     text: msg,
     type: 'warning',
     confirmButtonColor: "#DD6B55",
     showCancelButton: true,
     confirmButtonText: 'Sure'
   },function () {
       document.location.href = url;
   });
}

function comment_action(e){
  var id = e.target.getAttribute('data-id');
  var action = e.target.getAttribute('data-action');
  var deleted = e.target.getAttribute('data-deleted');
  console.log(action);
  var msg = '';
  var url = '';

  switch(action){
    case 'publish':
       if(deleted==1){
         msg = 'You want to unpublish this comment, users wont be able to see this comment if you unpublish.';
         url = baseURL+'unPublishComment/'+id;
       }else{
         msg = 'You want to publish this comment, users will be able to see this comment if you publish.';
         url = baseURL+'publishComment/'+id;
       }

    break;
    case 'delete':
       msg = 'You want to completely thrash this comment and all corresponding replies, this action cannot be undone.';
       url = baseURL+'thrashUserComment/'+id;
    break;
  }
   swal({
     title: 'Are you sure?',
     text: msg,
     type: 'warning',
     confirmButtonColor: "#DD6B55",
     showCancelButton: true,
     confirmButtonText: 'Sure'
   },function () {
       document.location.href = url;
   });
}


function user_action(e){
  var id = e.target.getAttribute('data-id');
  var action = e.target.getAttribute('data-action');
  var blocked = e.target.getAttribute('data-blocked');
  console.log(action);
  var msg = '';
  var url = '';

  switch(action){
    case 'block':
       if(blocked==1){
         msg = 'You want to block this User';
         url = baseURL+'blockUser/'+id;
       }else{
         msg = 'You want to unblock this User';
         url = baseURL+'unBlockUser/'+id;
       }

    break;
    case 'delete':
       msg = 'You want to delete this User';
       url = baseURL+'deleteUser/'+id;
    break;
  }
   swal({
     title: 'Are you sure?',
     text: msg,
     type: 'warning',
     confirmButtonColor: "#DD6B55",
     showCancelButton: true,
     confirmButtonText: 'Sure'
   },function () {
       document.location.href = url;
   });
}


$('.dropify').dropify({
    messages: {
        'default': 'Drag or drop thumbnail here',
        'replace': 'Drag and drop or click to replace',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
});

$('#feeds_table').DataTable({
  "bProcessing": true,
   "serverSide": true,
    "pageLength" : 10,
    "ajax": {
        url : baseURL+"getFeeds",
        type : 'POST'
    },
    dom: 'frtip',
    "columnDefs": [
    { className: "td_width", "targets": [ 3,4 ] }
  ]
});

$('#youtube_table').DataTable({
  "bProcessing": true,
   "serverSide": true,
    "pageLength" : 10,
    "ajax": {
        url : baseURL+"getYoutubeFeeds",
        type : 'POST'
    },
    dom: 'frtip',
    "columnDefs": [
    { className: "td_width", "targets": [ 3,4 ] }
  ]
});

$('#source').on('change', function(e) {
  document.getElementById('interest').value=$(this).find(':selected').data('interest');
  document.getElementById('location').value=$(this).find(':selected').data('location');
  document.getElementById('lang').value=$(this).find(':selected').data('lang');
})

$('#reports_table').DataTable({
    "pageLength" : 20,
    dom: 'frtip'
});

function view_comments_by_date(){
  var date = document.getElementById('reportrange').value;
  if(date!=""){
    var res = date.split(" - ");
    if(res[0]== undefined || res[1] == undefined){
      error_alert("Selected date(s) is invalid!!");
      return;
    }
     var date1 = res[0];
     var date2 = res[1];
      load_comments(date1,date2);

  }
}

function load_comments(date1,date2){
  $('#comments_table').DataTable({
    "bDestroy": true,
    "bProcessing": true,
     "serverSide": true,
      "pageLength" : 20,
      "ajax": {
          url : baseURL+"getCommentsAjax?date="+date1+"&date2="+date2,
          type : 'POST'
      },
      dom: 'frtip'
  });
}
load_comments(0,0);


function warn_user(evt){
  evt.preventDefault();
  var el = evt.target;
  var email = el.getAttribute('data-email');
  var comment = el.getAttribute('data-comment');

  swal({
  title: "",
  text: "Block Alert Warning",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Warn user of consquences of making such comments",
  showLoaderOnConfirm: true
},
function(message){
  if (message === false) return false;

  if (message === "") {
    swal.showInputError("You need to write something!");
    return false;
  }

  show_loader();
  var form_obj = JSON.stringify({
    email:email,
    comment: comment,
    message: message
  });
  //console.log(form_obj); return;
  var fd = new FormData();
  fd.append("data", form_obj);

  makeAjaxCall( baseURL+"reportedCommentWarnEmail", "POST",fd).then(function(response){
       if(data.status == "ok"){
         success_alert(data.msg);
       }else{
          error_alert(data.msg);
       }
  },  function(status){
     console.log("failed with status", status);
     error_alert("failed with status", status);
  });
});
}

$('#users_table').DataTable({
  "bProcessing": true,
   "serverSide": true,
    "pageLength" : 20,
    "ajax": {
        url : baseURL+"getUsersAjax",
        type : 'POST'
    },
    dom: 'frtip'
});

function load_comments(date1,date2){
  $('#comments_table').DataTable({
    "bDestroy": true,
    "bProcessing": true,
     "serverSide": true,
      "pageLength" : 20,
      "ajax": {
          url : baseURL+"getCommentsAjax?date="+date1+"&date2="+date2,
          type : 'POST'
      },
      dom: 'frtip'
  });
}
load_comments(0,0);

function push_item(e){
  var id = e.target.getAttribute('data-id');
  var type = e.target.getAttribute('data-type');
  var msg = 'Send this article as push notification to users, they should be able to open and read this article on their device.';
  var url = baseURL+'sendArticleNotification/'+id;

  if(type=="video"){
      msg = 'Send this video as push notification to users, they should be able to open and watch this video on their device.';
      url = baseURL+'sendVideoNotification/'+id;
  }

   swal({
     title: 'Are you sure?',
     text: msg,
     type: 'warning',
     confirmButtonColor: "#DD6B55",
     showCancelButton: true,
     confirmButtonText: 'Sure'
   },function () {
       document.location.href = url;
   });
}

function show_loader(){
  var submit = document.getElementById('submit');
  var loader = document.getElementById('loader');
  if(submit!=undefined){
    submit.style.display='none';
  }
  if(loader!=undefined){
    loader.style.display='block';
  }
}

function hide_loader(){
  var submit = document.getElementById('submit');
  var loader = document.getElementById('loader');
  if(submit!=undefined){
    submit.style.display='block';
  }
  if(loader!=undefined){
    loader.style.display='none';
  }
}
