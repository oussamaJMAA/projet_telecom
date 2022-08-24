import json
import pymysql

conn = pymysql.connect(host='127.0.0.1', port=3306, user='root', passwd='', db='projet_telecom')
cursor = conn.cursor()
with open('file2.json') as f:
    data = json.load(f)
for item in data:
    cursor.execute("INSERT INTO course""(name,image,link,details,rate)""VALUES(%s,%s,%s,%s,%s)",
                   (item["name"], item["image"], item["link"], item["skill"], item["rate"]))

conn.commit()
conn.close()
