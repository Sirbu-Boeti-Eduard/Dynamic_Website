import requests
from bs4 import BeautifulSoup
import pandas as pd
from datetime import datetime

url = "https://nyaa.si/?page=rss&c=3_1&f=0"

resp = requests.get(url)

soup = BeautifulSoup(resp.content, features="xml")

items = soup.findAll('item')

nyaa = []

for item in items:
	nyaa_temp = {}
	nyaa_temp['title'] = item.title.text
	nyaa_temp['link'] = item.link.text
	aux=item.size.text
	for i in aux:
		if (i=='M' or i=='G' or i=='T'):
			type=i
	position=aux.rfind(' ')
	truncate=aux[0:position]
	number=float(truncate)
	if (type=='G'):
		number*=1000
	if (type=='T'):
		number*=1000000
	nyaa_temp['size'] = int(number)
	aux=item.pubDate.text
	position=aux.rfind('-')
	aux=aux[0:position-1]
	nyaa_temp['pubDate']=datetime.strptime(aux, "%a, %d %b %Y %H:%M:%S").strftime("%Y-%m-%d %H:%M:%S")
	
	nyaa_temp['trusted'] = item.trusted.text
	nyaa.append(nyaa_temp)

df = pd.DataFrame(nyaa,columns=['title','link','size','pubDate','trusted'])
df.head()
df.to_csv("/home/parallels/web_scraping/Nyaa/Nyaa.csv",mode='a', index=False,header=False, encoding = "utf-8")
