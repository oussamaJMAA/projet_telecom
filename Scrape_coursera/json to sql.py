import json
import pymysql

conn = pymysql.connect(host='127.0.0.1', port=3306, user='root', passwd='', db='projet_telecom')
cursor = conn.cursor()
with open('file2.json') as f:
    data = json.load(f)
    for index, item in enumerate(data):
        sql_update_query = f"UPDATE course " \
                           f"SET image = '{item['image']}' " \
                           f"WHERE id = {index + 1}"
        print(sql_update_query)
        cursor.execute(sql_update_query)

conn.commit()
conn.close()