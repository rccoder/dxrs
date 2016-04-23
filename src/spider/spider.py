# -*- coding: utf-8 -*-
import re
import urllib2
import MySQLdb
__author__ = 'yumendy'

DEBUG = True



class Item(object):
    def __init__(self, page_url, title):
        self.page_url = page_url
        self.title = title
        self.publish_time = None
        self.content = None


class Today(object):
    __base_url = 'http://today.hit.edu.cn'
    __announcement_url = 'http://today.hit.edu.cn/classList/1.html'
    __news_url = 'http://today.hit.edu.cn/classList/2.html'
    __content_block_pattern = re.compile(
        r'<div style=" margin-left:35px;" class="sidelist7">\s*<ul>(?P<content>.*?)</ul>')
    __list_item_pattern = re.compile(
        r"<li>(.*)d>(?P<college>.*)</f(.*)f='(?P<page_url>.*)' ti(.*)k'>(?P<title>.*)</a(.*)</li>")
    __li_item = re.compile(r"<li>.*?</li>")
    __post_content_pattern = re.compile(
        r'<div id="text" class="articletext">(?P<post_content>.*)</div>\s*<div class="clearfloat"></div>\s*<center>',
        re.S)
    __post_time_pattern = re.compile(
        r'<div id="date">(.*)(?P<publish_time>\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:\d{1,2})')

    def __get_content(self, url):
        page = urllib2.urlopen(url).read().decode('gbk')
        return self.__content_block_pattern.search(page).group('content')

    def __get_li_list(self, content):
        return self.__li_item.findall(content)

    def __get_item_list(self, li_list):
        search_list = map(lambda y: self.__list_item_pattern.search(y), li_list)
        keep_list = filter(lambda x: x.group('college') == u'团委', search_list)
        item_list = map(
            lambda x: Item(self.__base_url + x.group('page_url'), x.group('title')), keep_list)
        return item_list

    def __get_post_content_and_publish_time(self, url):
        page = urllib2.urlopen(url).read().decode('gbk')
        content = self.__post_content_pattern.search(page).group('post_content')
        publish_time = self.__post_time_pattern.search(page).group('publish_time')
        content = content.replace(r'src="/', 'src="' + self.__base_url + '/')
        content = content.replace(r'href="/uploadfiles', 'href="' + self.__base_url + '/uploadfiles')
        content = content.replace(r'font-family', '')
        return content, publish_time

    def __add_content_and_publish_time_to_item(self, item):
        item.content, item.publish_time = self.__get_post_content_and_publish_time(item.page_url)

    def __get_tw_item_list(self, url):
        content = self.__get_content(url)
        li_list = self.__get_li_list(content)
        item_list = self.__get_item_list(li_list)
        map(self.__add_content_and_publish_time_to_item, item_list)
        return item_list

    def get_announcement_list(self):
        return self.__get_tw_item_list(self.__announcement_url)

    def get_news_list(self):
        return self.__get_tw_item_list(self.__news_url)

    def test(self):
        announcement_list = self.__get_tw_item_list(self.__announcement_url)
        news_list = self.__get_tw_item_list(self.__news_url)
        print len(announcement_list), len(news_list)



class MysqlDB(object):

    def __init__(self, value, judge):
        self.value = value
        self.db = self.connect_mysql()
        self.judge = judge


    def connect_mysql(self):
        return MySQLdb.connect("localhost","username","password","database", charset='utf8')

    def close_mysql(self):
       self.db.close()

    def operate_db(self, data):
        cursor = self.db.cursor()

        sql = "SELECT * FROM wp_posts WHERE post_title = '%s'" % (data.title.encode('utf-8'))
        cursor.execute(sql)

        if(cursor.fetchall()):
            print "表中已经存在"
        else:
            sql = "INSERT INTO wp_posts (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES(NULL, '0', '%s', '%s', '%s', '%s', '', 'publish', 'open', 'open', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0', 'post', '', '0')" % (data.publish_time.encode('utf-8'), data.publish_time.encode('utf-8'), data.content.encode('utf-8'), data.title.encode('utf-8'))
            #print sql
            cursor.execute(sql)
            self.db.commit()

            sql = "SELECT ID FROM wp_posts WHERE post_title = '%s'" % (data.title.encode('utf-8'))
            cursor.execute(sql)
            result = cursor.fetchall()[0][0]

            sql = "INSERT INTO wp_term_relationships (`object_id`, `term_taxonomy_id`, `term_order`) VALUES ('%s', '%s', 0)" % (result, self.judge)
            cursor.execute(sql)
            self.db.commit()

            sql = "SELECT count FROM wp_term_taxonomy WHERE term_id = '%s'" % (self.judge)
            cursor.execute(sql)
            result = cursor.fetchall()[0][0]

            sql = "UPDATE wp_term_taxonomy set count = %d WHERE term_id = '%s'" % (result+1, self.judge)
            cursor.execute(sql)
            self.db.commit()

            print "Done"



    def get_max_id(self):
        cursor = self.connect_mysql().cursor()
        sql = "select MAX(ID) from %s" % self.table

        try:
            return cursor.execut(sql)
        except:
            print "Error in %s" % sql

        self.close_mysql()

    def action(self):
        map(self.operate_db, self.value)
        self.close_mysql()

def main():
    t = Today()
    announcement_list = t.get_announcement_list()
    news_list = t.get_news_list()
    m1 = MysqlDB(announcement_list, 9)
    m1.action()

    m2 = MysqlDB(news_list, 8)
    m2.action()


    if DEBUG:
        t.test()


if __name__ == '__main__':
    main()
