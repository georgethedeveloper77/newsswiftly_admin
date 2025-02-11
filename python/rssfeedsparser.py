#!/usr/bin/python
# -*- coding: utf-8 -*-

import feedparser
import MySQLdb
import dateutil.parser
from dateutil import parser
import time
import string
import random
import newspaper
import datetime
import feedparser #extract links from rss feed page
import requests #extract contents from each rss feed link
from newspaper import Article, ArticleException #parse the content and get required data

#function to parse and get all links from rss page
def getLinks(url):
    d = feedparser.parse(url)
    links = []

    for post in d.entries:
        date = ""
        if hasattr(post, 'published'):
            date = parser.parse(post.published)
        else:
            date = 'None'
        links.append(init_page(post.link,date))

    return links

class Page(object):
    link = ""
    date = ""

def init_page(link, date):
    page = Page()
    page.link = link
    page.date = date
    return page

#function to verify if date is valid or in the future
def verify_date(date):
  tm = time.mktime(time.strptime(date, '%Y-%m-%d %H:%M:%S'))
  ts = time.time()
  return tm>ts

# Open database connection
db = MySQLdb.connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME", charset='utf8')

# prepare a cursor object using cursor() method
cursor = db.cursor()
# Prepare SQL query to INSERT a record into the database.
sql = "SELECT * FROM tbl_rss_urls WHERE rss_type = 'rsspage'"
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
       links = getLinks(url)
       for page in links:
           try:
               p = requests.get(page.link)
               article = Article('')
               article.set_html(p.content)
               article.parse()
               title = article.title
               thumbnail = article.top_image
               content = article.text
               html = article.article_html
               date = page.date
               if date == '' or date == 'None' or date == None or verify_date(date.strftime('%Y-%m-%d %H:%M:%S')) == True:
                 date = datetime.datetime.now()
               text_len = len(content)
               print(text_len)
               if text_len>100:
                   try:
                       record = [channel,page.link.replace("#comments", ""),title.strip(),thumbnail,content.strip(),html,location,lang,date,interest,1]
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
