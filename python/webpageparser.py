#!/usr/bin/python
# -*- coding: utf-8 -*-

import feedparser
import MySQLdb
import dateutil.parser
import time
import string
import random
import newspaper
import datetime
from newspaper import Article, ArticleException

def text_extractor2(article):
    try:
        article.download()
    except ArticleException:
        article = article.parse()
        return np.nan

    return article

def verify_date(date):
  tm = time.mktime(time.strptime(date, '%Y-%m-%d %H:%M:%S'))
  ts = time.time()
  return tm>ts

# Open database connection
db = MySQLdb.connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME", charset='utf8')

# prepare a cursor object using cursor() method
cursor = db.cursor()
# Prepare SQL query to INSERT a record into the database.
sql = "SELECT * FROM tbl_rss_urls WHERE rss_type = 'webpage'"
try:
   # Execute the SQL command
   cursor.execute(sql)
   # Fetch all the rows in a list of lists.
   results = cursor.fetchall()
   for row in results:
       url = row[2]
       location = row[4]
       lang = row[5]
       channel = row[0]
       interest = row[3]
       paper = newspaper.build(url,memoize_articles = False,keep_article_html=True,MAX_TEXT=200000, MIN_WORD_COUNT=500, MAX_TITLE=700)
       #a = Article('http://www.cnn.com/2014/01/12/world/asia/north-korea-charles-smith/index.html'
       #, keep_article_html=True)
       for article in paper.articles:
           try:
               article.download()
               article.parse()
               title = article.title
               thumbnail = article.top_image
               content = article.text
               html = article.article_html
               date = article.publish_date
               if date == '' or date == 'None' or date == None or verify_date(date.strftime('%Y-%m-%d %H:%M:%S')) == True:
                 date = datetime.datetime.now()
               link = article.url
               text_len = len(content)
               print(link)
               if text_len>100:
                   try:
                       record = [channel,link.replace("#comments", ""),title.strip(),thumbnail,content.strip(),html,location,"english",date,interest,1]
                       cursor.execute("INSERT INTO tbl_rss_feeds (channel,link,title,thumbnail,content,html,location,lang,date,interest,type) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", record)
                       db.commit()
                       print("success")
                   except MySQLdb.Error as e:
                       print(e)

           except ArticleException:
               pass
except MySQLdb.Error as e:
    print(e)

# disconnect from server
db.close()
