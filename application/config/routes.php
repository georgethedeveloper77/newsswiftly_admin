<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$config['index_page'] = "";
$config['uri_protocol'] = "REQUEST_URI";
$route['default_controller'] = 'blog';
$route['categories'] = "api/interestsListing";
$route['authorize'] = "api/get_secret_key";
$route['articles'] = "api/feedsListing";
$route['new_feeds'] = "api/newFeedsListing";
$route['youtube'] = "api/videosListing";
$route['radiosv2'] = "api/radioListing";
$route['sources'] = "api/sourcesListing";
$route['fetch_videos'] = "videos/youtube_feeds";
$route['feeds_source'] = "api/feedSourceListing";
$route['videos_source'] = "api/videoSourceListing";
$route['storeFcmTokenv2'] = "api/storeFcmToken";
$route['query'] = "api/search";
$route['get_article_contentv2'] = "api/get_article_content";
$route['delete_old'] = 'api/delete_old';
$route['fetch_livestreamsv2'] = "api/fetch_livestreams";
$route['update_post_total_viewsv2'] = "api/update_post_total_views";
$route['likeunlikepostv2'] = "api/likeunlikepost";
$route['gettotallikesandcommentsviewsv2'] = "api/gettotallikesandcommentsviews";

//livestreams routes
$route['newLivestream'] = 'livestreams/newLivestream';
$route['savenewlivestream'] = 'livestreams/savenewlivestream';
$route['editLivestream/(:num)'] = 'livestreams/editLivestream/$1';
$route['editLivestreamData'] = 'livestreams/editLivestreamData';
$route['deleteLivestream/(:num)'] = 'livestreams/deleteLivestream/$1';

//reactions and comments
$route['makecommentv2'] = "comments/makecomment";
$route['editcommentv2'] = "comments/editcomment";
$route['deletecommentv2'] = "comments/deletecomment";
$route['loadcommentsv2'] = "comments/loadcomments";
$route['reportcommentv2'] = "comments/reportcomment";
$route['replycommentv2'] = "replies/replycomment";
$route['editreplyv2'] = "replies/editreply";
$route['deletereplyv2'] = "replies/deletereply";
$route['loadrepliesv2'] = "replies/loadreplies";
$route['reportedcomments'] = 'comments/reportedcomments';
$route['deleteReport/(:num)'] = 'comments/deleteReport/$1';
$route['usercomments'] = 'comments/usercomments';
$route['getCommentsAjax'] = 'comments/getCommentsAjax';
$route['fetchandroidusers'] = 'account/fetchandroidusers';
$route['publishComment/(:num)'] = 'comments/publishComment/$1';
$route['unPublishComment/(:num)'] = 'comments/unPublishComment/$1';
$route['thrashUserComment/(:num)'] = 'comments/thrashUserComment/$1';


//blog routes
$route['post/(:num)'] = 'blog/post/$1';
$route['video/(:num)'] = 'blog/video/$1';
$route['posts/(:any)'] = 'blog/posts/$1';
$route['posts/(:any)/(:num)'] = 'blog/posts/$1/$1';
$route['videos/(:any)'] = 'blog/videos/$1';
$route['videos/(:any)/(:num)'] = 'blog/videos/$1/$1';
$route['post'] = 'blog';
$route['video'] = 'blog';
$route['category'] = 'blog';
$route['about'] = 'blog/about';
$route['terms'] = 'blog/terms';
$route['privacy'] = 'blog/privacy';

$route['authenticate'] = 'login/authenticate';

//admin routes
$route['adminListing'] = 'user';
$route['newAdmin'] = 'user/newAdmin';
$route['savenewadmin'] = 'user/savenewadmin';
$route['editAdmin/(:num)'] = 'user/editAdmin/$1';
$route['editadmindata'] = 'user/editadmindata';
$route['deleteAdmin/(:num)'] = 'user/deleteAdmin/$1';
$route['notification'] = "user/notification";
$route['sendNotification'] = "user/sendNotification";
$route['settings'] = "user/settings";
$route['updateSettings'] = "user/updateSettings";
$route['sendArticleNotification/(:num)'] = 'user/sendArticleNotification/$1';
$route['sendVideoNotification/(:num)'] = 'user/sendVideoNotification/$1';

//interest routes
$route['interestListing'] = 'interests';
$route['newInterest'] = 'interests/newInterest';
$route['savenewinterest'] = 'interests/savenewinterest';
$route['editInterest/(:num)'] = 'interests/editInterest/$1';
$route['editInterestData'] = 'interests/editInterestData';
$route['deleteInterest/(:num)'] = 'interests/deleteInterest/$1';

//language routes
$route['langaugeListing'] = 'languages';
$route['newLanguage'] = 'languages/newLanguage';
$route['savenewlanguage'] = 'languages/savenewlanguage';
$route['editLanguage/(:num)'] = 'languages/editLanguage/$1';
$route['editLanguageData'] = 'languages/editLanguageData';
$route['deleteLanguage/(:num)'] = 'languages/deleteLanguage/$1';

//rss links routes
$route['rssLinksListing'] = 'rsslinks/rssLinksListing';
$route['newRssLink'] = 'rsslinks/newRssLink';
$route['saveNewRssLink'] = 'rsslinks/saveNewRssLink';
$route['editRssLink/(:num)'] = 'rsslinks/editRssLink/$1';
$route['editRssLinkData'] = 'rsslinks/editRssLinkData';
$route['deleteRssLink/(:num)'] = 'rsslinks/deleteRssLink/$1';


//rss feeds routes
$route['getFeeds'] = 'rssfeeds/getFeeds';
$route['rssFeedsListing'] = 'rssfeeds/rssFeedsListing';
$route['newRssFeed'] = 'rssfeeds/newRssFeed';
$route['saveNewRssFeed'] = 'rssfeeds/saveNewRssFeed';
$route['editRssFeed/(:num)'] = 'rssfeeds/editRssFeed/$1';
$route['editRssFeedData'] = 'rssfeeds/editRssFeedData';
$route['deleteRssFeed/(:num)'] = 'rssfeeds/deleteRssFeed/$1';

//youtube feeds routes
$route['getYoutubeFeeds'] = 'youtubefeeds/getYoutubeFeeds';
$route['youtubeFeedsListing'] = 'youtubefeeds/youtubeFeedsListing';
$route['newYoutubeFeed'] = 'youtubefeeds/newYoutubeFeed';
$route['saveNewYoutubeFeed'] = 'youtubefeeds/saveNewYoutubeFeed';
$route['editYoutubeFeed/(:num)'] = 'youtubefeeds/editYoutubeFeed/$1';
$route['editYoutubeFeedData'] = 'youtubefeeds/editYoutubeFeedData';
$route['deleteYoutubeFeed/(:num)'] = 'youtubefeeds/deleteYoutubeFeed/$1';


//youtube rss links routes
$route['youtubeLinksListing'] = 'youtube/youtubeLinksListing';
$route['newYoutubeRssLink'] = 'youtube/newYoutubeRssLink';
$route['saveNewYoutubeRssLink'] = 'youtube/saveNewYoutubeRssLink';
$route['editYoutubeRssLink/(:num)'] = 'youtube/editYoutubeRssLink/$1';
$route['editYoutubeRssLinkData'] = 'youtube/editYoutubeRssLinkData';
$route['deleteYoutubeRssLink/(:num)'] = 'youtube/deleteYoutubeRssLink/$1';


//radio routes
$route['radioListing'] = 'radio/radioListing';
$route['newRadioLink'] = 'radio/newRadioLink';
$route['saveNewRadioLink'] = 'radio/saveNewRadioLink';
$route['editRadioLink/(:num)'] = 'radio/editRadioLink/$1';
$route['editRadioLinkData'] = 'radio/editRadioLinkData';
$route['deleteRadioLink/(:num)'] = 'radio/deleteRadioLink/$1';

//android users routes
//admin and android users
$route['signinUser'] = 'account/loginUser';
$route['registerUser'] = 'account/registerUser';
$route['passwordReset'] = 'account/resetPassword';
$route['verifyUserPhone'] = 'account/verifyUserPhone';
$route['resendVerificationCode'] = 'account/resendVerificationCode';
$route['resendVerificationMail'] = 'account/resendVerificationMail';
$route['verifyEmailLink/(:any)/(:any)'] = 'account/verifyEmailLink/$1/$2';
$route['resetLink/(:any)/(:any)'] = 'account/resetLink/$1/$2';
$route['changeUserPassword'] = 'account/changeUserPassword';
$route['fetchandroidusers'] = 'account/fetchandroidusers';
$route['androidUsers'] = 'account/users';
$route['getUsersAjax'] = 'account/getUsersAjax';
$route['deleteUser/(:num)'] = 'account/deleteUser/$1';
$route['blockUser/(:num)'] = 'account/blockUser/$1';
$route['unBlockUser/(:num)'] = 'account/unBlockUser/$1';
$route['uploadavatarwithdata'] = "account/uploadavatarwithdata";
$route['updateUserData'] = "account/updateUserData";

$route['register'] = 'account/register';
$route['signin'] = 'account/signin';
$route['socialsignin'] = 'account/socialsignin';
$route['reset'] = 'account/reset';
$route['authenticateUser'] = 'account/authenticateUser';
$route['createAccount'] = 'account/createAccount';
$route['resetAccount'] = 'account/resetAccount';
$route['verify'] = 'account/verify';
$route['verifyPhone'] = 'account/verifyPhone';
$route['resendcode'] = 'account/resendcode';
$route['updateAccount'] = 'account/updateAccount';
$route['updateAccountInfo'] = 'account/updateAccountInfo';
$route['logoutUser'] = 'account/logout';


$route['logout'] = 'user/logout';
//$route['(:any)'] = 'view/$1';
$route['404_override'] = 'errorpage';
$route['404'] = 'errorpage';
$route['translate_uri_dashes'] = FALSE;
