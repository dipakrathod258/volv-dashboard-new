<?php

Auth::routes();

Route::get('/home', 'ArticleController@index')->name('home');
Route::get('/config', 'TestController@configDetails');

Route::group(['middleware' => 'App\Http\Middleware\Authenticate'], function()
{
	Route::get('/allDashboard', "ArticleController@index");
	Route::get('/searchArticle', "ArticleController@searchArticle");	
	
	Route::get('/article_authory_history/{id}', "ArticleController@articleAuthorHistoryDetails");

	Route::get('/', "ArticleController@myDashboard");
	Route::get('/myDashboard', "ArticleController@myDashboard");
	Route::get('/test_route', "ArticleController@test_route");
	
	Route::get('/summarizer', "ArticleController@extractiveSummarizer");
	Route::get('//publishedArticles', "ArticleController@publishedArticles");
	Route::get('/inProgressArticles', "ArticleController@inProgressArticles");
	Route::get('/needsReviewArticles', "ArticleController@needsReviewArticles");
	Route::get('/republishableArticles', "ArticleController@republishableArticles");
	
	Route::get('/readMediaBias', "ArticleController@readMediaBias");
	
	Route::get('/publish_article/{article_id}', "ArticleController@publishArticle");
	
	
	Route::get('/breaking_news/{article_id}', "ArticleController@createBreakingNews");
	Route::get('/save_breaking_news', "ArticleController@storeBreakingNews");
	Route::get('/show_breaking_news', "ArticleController@breakingNewsIndex");
	Route::get('/edit_breaking_news/{article_id}', "ArticleController@editbreakingNewsIndex");
	Route::post('/update_breaking_news/{article_id}', "ArticleController@updateBreakingNews");
	
	
	// Route::get('/create_articles', "ArticleController@createArticle");
	
	Route::get('/create_articles', "ArticleController@checkBiasNews");
	Route::post('/submit_news', "ArticleController@submitNews");
	Route::post('/proceedToArticles', "ArticleController@createArticle");


	Route::get('/extract_articles', "ArticleController@extractArticle");
	Route::post('/submit_article', "ArticleController@submitArticle");
	Route::post('/submit_trending_article', "ArticleController@submitTrendingArticle");
	Route::get('/edit_articles/{id}', "ArticleController@editArticle");
	Route::post('/update_articles/{id}', "ArticleController@updateArticle");
	Route::get('/view_articles/{id}', "ArticleController@viewArticle");
	Route::get('/delete_articles/{id}', "ArticleController@destroyArticle");
	
	Route::get('/update_articles_status_in_progress/{id}', "ArticleController@changeArticleStatusInProgress");

	Route::get('/create_user', "AuthorController@indexUser");
	Route::get('/create_new_author', "AuthorController@createNewAuthor");
	Route::post('/submit_author', "AuthorController@submitNewAuthor");
	Route::get('/edit_author/{id}', "AuthorController@editAuthor");
	Route::post('/update_author/{id}', "AuthorController@updateAuthor");
	Route::get('/delete_author/{id}', "AuthorController@deleteAuthor");
	// Route::get('/author_submit', "AuthorController@submitAuthor");

	// =====Category Controller starts
	Route::get('/show_category', 'CategoryController@index');
	Route::get('/create_new_category', 'CategoryController@create');
	Route::get('/edit_category/{id}', 'CategoryController@edit');
	Route::post('/update_categories/{id}', 'CategoryController@updateCategory');
	Route::post('/store_category', 'CategoryController@store');
	Route::get('/delete_category/{id}', 'CategoryController@destroy');
	Route::get('/view_category/{id}', 'CategoryController@view');
	// =====Category Controller ends

	// =====Trending Category Controller starts
	Route::get('/show_trending_news', 'TrendingCategoryController@index_new');
	Route::get('/show_trending_category', 'TrendingCategoryController@index');
	Route::get('/create_trending_category', 'TrendingCategoryController@create');
	Route::post('/store_trending_category', 'TrendingCategoryController@store');
	Route::get('/delete_category/{id}', 'TrendingCategoryController@destroy');
	Route::get('/view_category/{id}', 'TrendingCategoryController@view');
	// =====Trending Category Controller ends


	//Trending section begins

	Route::get('/worldNews', 'TrendingCategoryController@worldNews');
	Route::get('/sportNews', 'TrendingCategoryController@sportNews');
	Route::get('/entertainmentNews', 'TrendingCategoryController@entertainmentNews');
	Route::get('/financeNews', 'TrendingCategoryController@financeNews');
	Route::get('/businessNews', 'TrendingCategoryController@businessNews');
	Route::get('/technologyNews', 'TrendingCategoryController@technologyNews');
	Route::get('/fashion', 'TrendingCategoryController@fashion');
	Route::get('/selfDev', 'TrendingCategoryController@selfDev');
	Route::get('/entrepreneurship', 'TrendingCategoryController@entrepreneurship');
	Route::get('/trendingNews', 'TrendingCategoryController@trendingNews');
	

	Route::get('/trendingNewsStoreArticle', 'ArticleController@trendingNewsStoreArticle');

	//Trending section ends


	//To filter the article table
	Route::get('/filterArticleTable', 'ArticleController@filterArticleTable');
	Route::get('/filterArticleTableByCategory', 'ArticleController@filterArticleTableByCategory');
	Route::get('/filterArticleTableByStatus', 'ArticleController@filterArticleTableByStatus');
	Route::get('/filterArticleDate', 'ArticleController@filterArticleDate');
	Route::get('/filterArticleDateMyDashboard', 'ArticleController@filterArticleDateMyDashboard');
	Route::get('/filterArticleTableByPriority', 'ArticleController@filterArticleTableByPriority');
	Route::get('/export_categories_pdf', 'ArticleController@exportArticlePdf');
	Route::get('/downloadExcel', 'ArticleController@downloadExcel');

	Route::get('/change_article_status/{article_status}/{article_id}/{button_class}', 'ArticleController@changeArticleStatus');


	// Route::get('/change_article_priority/{article_priority}/{article_id}/{button_class}', 'ArticleController@changeArticleStatus');
	Route::get('/change_article_priority/{article_priority}/{article_id}/{priority_button_class}', 'ArticleController@changeArticleByPriority');
	Route::get('/show_guidelines', 'ArticleController@showGuidelines');
	Route::get('/downloadUserGuidelines', 'ArticleController@downloadUserGuidelines');
	Route::post('/uploadUserGuidelines', 'ArticleController@uploadUserGuidelines');
	
	Route::get('/notify/{id}/{articleStack}', 'FCMController@notify');
	Route::get('/get_notification_data/{id}', 'FCMController@getNotificationData');
	
	
	Route::get('/getNotificationStatusEachUser', 'FCMController@getNotificationStatusEachUser');
	Route::get('/all_user_notif_status/{article_id}', 'FCMController@getNotificationStatus');
	
	
	Route::get('/writerStatus', 'WriterController@index');
	Route::get('/add_poll/{id}', 'ArticleController@addPoll');
	Route::post('/store_poll', 'ArticleController@storePoll');
	Route::get('/view_poll', 'ArticleController@viewPoll');
	
	Route::get('/articlePolls', 'ArticleController@articlePolls');
	Route::get('/change_poll_status/{poll_id}/{poll_status}', 'ArticleController@updatePolls');
	

	Route::get('/goToArticleReports', 'ArticleReportsController@goToArticleReports');
	Route::get('/getUSNewsReport', 'ArticleReportsController@getUSNewsReport');
	
	Route::get('/goToDailyReports', 'ArticleReportsController@goToDailyReports');	
	Route::get('/goToWeeklyReports', 'ArticleReportsController@goToWeeklyReports');	
	Route::get('/goToMonthlyReports', 'ArticleReportsController@goToMonthlyReports');

	Route::get('/excel-report', 'ArticleReportsController@excelReport');	
	Route::post('/excel-report-schedule-change', 'ArticleReportsController@changeExcelReport');	
	
	Route::get('/articlesOnApp', 'ArticleController@articlesOnApp');	
	Route::get('/articleScheduler', 'ArticleActivityController@articleScheduler');	
	Route::post('/schedule_weekend_article', 'ArticleController@articleScheduler');	
	
	Route::get('/plagiarismChecker', 'PlagiarismController@plagiarismChecker');	

	Route::get('/check_today_report/{date}', 'ArticleReportsController@fetchTodayReport');		
	
	Route::get('/notificatin_report', 'NotificationController@index');		
	Route::get('/notification_open_rate/{article_id}', 'NotificationController@notificationOpenRate');		
	Route::get('/viewNotificationOpenUserDetails/{article_id}', 'NotificationController@viewNotificationOpenUserDetails');		
	
	Route::get('/weekend_schedule_report', 'WeekendArticlesController@index');

	Route::get('get_weekend_schedule/{date}', 'ArticleController@getWeekendSlots');
	
	Route::post('getMiniHashtags', 'HashtagController@getMiniHashtags');
	Route::get('hashtags', 'HashtagController@hashtagIndex');
	Route::get('searchHashtagArticle/{hashtag}', 'HashtagController@searchHashtagArticle');
	Route::get('removeArticleHashtags/{article_id}/{hashtag}', 'HashtagController@removeArticleHashtags');
	
	Route::post('deleteHashtag/{minihashtag}', 'HashtagController@deleteMiniHashtags');
// ===Breaking News	
	
    Route::get('breaking_news', 'BreakingNewsController@getBreakingNews');
    Route::post('saveBreakingNewsToken', 'BreakingNewsController@saveBreakingNewsToken');

    Route::get('changeArticleBias', 'ArticleController@changeArticleBias');    
    Route::get('appAnalytics', 'AppController@appAnalytics');    
    Route::get('activeInactiveUsers', 'AppController@activeInactiveUsers');    
    Route::post('activeBasedMonth', 'AppController@activeInactiveUsersPOST');    
    Route::get('monthYearActiveUsers', 'AppController@monthYearActiveUsers');    
    
    Route::get('monthYearActiveCount', 'AppController@monthYearActiveCount');    
    Route::get('activity_after_register', 'AppController@activity_after_register');    

    Route::post('activity_after_register_post', 'AppController@activity_after_register_post');    
    
// Analysis of article shared
    Route::get('article_shared', 'AppController@articleShared');    

// Notification enabled/disabled

	Route::get('/notification_analysis', 'AppController@notificationAnalysis');
	Route::get('/notification_breakdown_analysis', 'AppController@notificationBreakdownAnalysis');


	Route::get('/publisher/index/', 'PublisherController@index');
	Route::get('/publisher/create', 'PublisherController@create');
	Route::post('/save/publisher', 'PublisherController@store');
	Route::get('/delete_publisher/{id}', 'PublisherController@destroy');
	Route::get('/edit_publisher/{id}', 'PublisherController@edit');
	Route::post('/update/publisher/{id}', 'PublisherController@update');
	Route::get('/publisher_articles/{id}', 'PublisherController@publisherArticles');

});

Route::get('getTwitterTrendingHashtags', 'BreakingNewsController@getTwitterTrendingHashtags');

Route::get('/test', 'TestController@test');
Route::post('/upload_image', 'TestController@upload_image');
Route::get('/sendNotification', 'FCMController@sendNotification');
// Route::get('/getRssFeed', 'RSSFeedController@index');
Route::get('/worldNews', 'RSSFeedController@worldNews');
Route::get('/technologyNews', 'RSSFeedController@technologyNews');
Route::get('/entertainmentNews', 'RSSFeedController@entertainmentNews');
Route::get('/usNews', 'RSSFeedController@usNews');
Route::get('/recentNews', 'RSSFeedController@recentNews');
Route::get('/politicsNews', 'RSSFeedController@politicsNews');
Route::get('/getRssFeed', 'RSSFeedController@getRSSFeed');
Route::get('/getRSSWorldFeed', 'RSSFeedController@getRSSWorldFeed');
Route::get('/getRssPoliticsFeed', 'RSSFeedController@getRssPoliticsFeed');
Route::get('/sessionCookies', 'TestController@sessionTrack');

Route::get('/sendNotificationIos', 'TestController@index');

Route::group(['middleware' => 'App\Http\Middleware\Admin'], function()
{
	Route::get('/testAdmin', 'AdminController@index');
	Route::get('/volv_app_users', 'ArticleController@volvAppUsers');
});

Route::get('/warning', 'AdminController@warning');
Route::get('/getRefferalDetails', 'AppRefferalController@getRefferalDetails');
Route::get('/sendTestNotification', 'FCMController@sendTestNotification');

Route::get('/notification_status_each_user', 'FCMController@notification_status_each_user');


// ===Google Trends begins====
Route::get('/googleTrends', 'AIController@googleTrends');
Route::get('/googleTrendsBusiness', 'AIController@googleTrendsBusiness');
Route::get('/googleTrendsEntertainment', 'AIController@googleTrendsEntertainment');
Route::get('/googleTrendsHealth', 'AIController@googleTrendsHealth');
Route::get('/googleTrendsScienceNTech', 'AIController@googleTrendsScienceNTech');
Route::get('/googleTrendsSports', 'AIController@googleTrendsSports');
Route::get('/googleTrendsTopStories', 'AIController@googleTrendsTopStories');
Route::get('/createArticleSentiment', 'AIController@googleTrendsTopStories');

Route::get('/getlastWeeksUserData', 'APIController@getlastWeeksUserData');
Route::post('/gettimeSpentLastWeek', 'APIController@gettimeSpentLastWeek');

Route::get('/lastWeeksUserData/{uid}', 'APIController@lastWeeksUserData');
Route::get('/timeSpentLastWeek/{uid}', 'APIController@timeSpentLastWeek');


// Feedback Feature begins

Route::get('/create_feedback', 'FeedbackController@index');
Route::post('/store_feedback', 'FeedbackController@store');
Route::get('/show_feedbacks', 'FeedbackController@show');
Route::get('/display_feedback/{feedback_id}', 'FeedbackController@display');
Route::post('/updateFeedbackStatus/{feedback_id}', 'FeedbackController@updateFeedbackStatus');
Route::get('/feedback_results/{feedback_id}', 'FeedbackController@feedbackResults');
Route::get('/downloadFeedbackResults/{feedback_id}', 'FeedbackController@downloadFeedbackResults');

// == User analytics begins
Route::get('/topArticlesLastWeek', 'APIController@topArticlesLastWeek');
Route::get('/topTenArticlesLastWeek', 'APIController@topTenArticlesLastWeek');
Route::get('/avgSessionsPerWeekPerUser', 'APIController@avgSessionsPerWeekPerUser');
Route::get('/avgTimeSpentPerUserPerWeek', 'APIController@avgTimeSpentPerUserPerWeek');

// == User analytics ends

// Feedback Feature ends


// ===Google Trends ends====

// AI Model API Calls starts

Route::get('/get_gpt_summarization', 'AIController@getGPTSummarization');
Route::post('/fetch_gpt_summarization', 'AIController@fetchGPTSummarization');

Route::get('/get_gpt_content', 'AIController@getGPTContent');
Route::post('/fetch_gpt_content', 'AIController@fetchGPTContent');

// AI Model API Calls ends

Route::get('/testMonth', 'TestController@testMonth');

Route::get('sunil', function (Request $request) {
	DB::insert(['data' => $request->data]);
});