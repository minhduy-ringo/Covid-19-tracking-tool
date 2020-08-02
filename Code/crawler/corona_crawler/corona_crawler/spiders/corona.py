# -*- coding: utf-8 -*-
import scrapy
from datetime import datetime
import csv

# Scrapy spider to get COVID-19 from Worldometers
class CoronaSpider(scrapy.Spider):
    name = 'corona'
    
    allowed_domains = ['www.worldometers.info']
    start_urls = ['https://www.worldometers.info/coronavirus/'] 
    item_list = []

    def parse(self, response):
        countries = response.xpath("//table[@id='main_table_countries_yesterday']/tbody[1]/tr")

        for country in countries:
            items = {}
            items["#"] = country.xpath(".//td[1]/text()").get()    
            items["Country/Other"] = country.xpath(".//td[2]/nobr/text()").get() or country.xpath(".//td[2]//text()").get()
            items["Total Cases"] = country.xpath(".//td[3]/text()").get()
            items["New Cases"] = country.xpath(".//td[4]/text()").get()
            items["Total Deaths"] = country.xpath(".//td[5]/text()").get()
            items["New Deaths"] = country.xpath(".//td[6]/text()").get()
            items["Total Recovered"] = country.xpath(".//td[7]/text()").get()
            items["New Recovered"] = country.xpath(".//td[8]/text()").get()
            items["Active Cases"] = country.xpath(".//td[9]/text()").get()
            items["Serious/Critical"] = country.xpath(".//td[10]/text()").get()
            items["Tot Cases/1M pop"] = country.xpath(".//td[11]/text()").get()
            items["Deaths/1M pop"] = country.xpath(".//td[12]/text()").get()
            items["Total Tests"] = country.xpath(".//td[13]/text()").get()
            items["Population"] = country.xpath(".//td[14]/text()").get()
            self.item_list.append(items)

        now = datetime.now()
        day = now.strftime("%Y%m%d")
        time = now.strftime("%H%M")

        with open("corona_tracking/Corona_Worldwide_" + day + "_" + time + ".csv","x", newline="") as f:
            writer = csv.DictWriter(f,['#', 'Country/Other', 'Total Cases', 'New Cases', 'Total Deaths', 'New Deaths', 'Total Recovered', 
                                    'New Recovered', 'Active Cases', 'Serious/Critical', 'Tot Cases/1M pop', 'Deaths/1M pop', 'Total Tests', 
                                    'Population'])
            writer.writeheader()
            for data in self.item_list:
                if data['Country/Other'] == '\n' or data['Country/Other'] == ' ':
                    continue
                else:
                    writer.writerow(data)