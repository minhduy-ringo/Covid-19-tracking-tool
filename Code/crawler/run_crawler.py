import scrapy
from scrapy.crawler import CrawlerProcess
from scrapy.utils.project import get_project_settings

from corona_crawler.corona_crawler.spiders.corona import CoronaSpider

process = CrawlerProcess(get_project_settings())
process.crawl(CoronaSpider)
process.start()