#!/usr/bin/python
# -*- coding: utf-8 -*-

import mysql.connector
import feedparser
import dateutil.parser
import time
import string
import random
import newspaper
import datetime
import requests
from newspaper import Article, ArticleException

# Function to parse and get all links from the RSS page
def getLinks(url):
    d = feedparser.parse(url)
    links = []

    for post in d.entries:
        date = ""
        if hasattr(post, 'published'):
            date = dateutil.parser.parse(post.published)
        else:
            date = 'None'
        links.append(init_page(post.link, date))

    return links

class Page(object):
    link = ""
    date = ""

def init_page(link, date):
    page = Page()
    page.link = link
    page.date = date
    return page

# Function to verify if the date is valid or in the future
def verify_date(date):
    tm = time.mktime(date.timetuple())
    ts = time.time()
    return tm > ts

# ... (rest of the script)

# Open database connection using the correct connector library
db = mysql.connector.connect(
    host="localhost",
    user="newsflash_user",
    password="!HkhDw3emYP0IduN",
    database="newsflash_db",
    charset='utf8'
)

# Prepare a cursor object using cursor() method
cursor = db.cursor()

# Calculate the date 7 days ago
seven_days_ago = datetime.datetime.now() - datetime.timedelta(days=7)

# Delete feeds older than 7 days from the database
try:
    delete_query = "DELETE FROM tbl_rss_feeds WHERE date < %s"
    cursor.execute(delete_query, (seven_days_ago,))
    db.commit()
    print("Old feeds older than 7 days have been deleted.")
except mysql.connector.Error as e:
    print("Error deleting old feeds:", e)

# Prepare SQL query to SELECT the RSS URLs
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
                if date == '' or date == 'None' or date is None or verify_date(date) == True:
                    date = datetime.datetime.now()
                text_len = len(content)
                print(text_len)
                if text_len > 100:
                    try:
                        # Prepare the SQL query with correct placeholder formatting
                        sql_query = "INSERT INTO tbl_rss_feeds (channel,link,title,thumbnail,content,html,location,lang,date,interest,type) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
                        record = (channel, page.link.replace("#comments", ""), title.strip(), thumbnail, content.strip(), html, location, lang, date, interest, 1)
                        cursor.execute(sql_query, record)
                        db.commit()
                        print("success")
                    except mysql.connector.Error as e:
                        print(e)
            except ArticleException:
                pass
except mysql.connector.Error as e:
    print(e)

# Disconnect from the server
db.close()
